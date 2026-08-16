#!/bin/bash
#
# Deploiement declenche par une tache cron cPanel.
#
# Contourne l'absence d'acces SSH interactif : les taches cron s'executent
# dans un shell, sous l'utilisateur du compte. Ce script reprend les memes
# etapes que .cpanel.yml, que le bouton « Deploy HEAD Commit » ne peut pas
# lancer sur cette offre d'hebergement (voir DEPLOY.md 0 bis).
#
# Appel depuis cPanel > Taches cron :
#   /bin/bash /home/tharamotors/repositories/tharamotors/deploy/deploy.sh \
#     >> /home/tharamotors/deploy.log 2>&1
#
# Le script est idempotent : le relancer est sans danger.

set -u

REPO=/home/tharamotors/repositories/tharamotors
APP=/home/tharamotors/laravel
WEB=/home/tharamotors/public_html

echo "=============================================================="
echo "Deploiement demarre : $(date)"
echo "=============================================================="

# --- Interpreteur PHP -------------------------------------------------------
PHP=/opt/cpanel/ea-php83/root/usr/bin/php
if [ ! -x "$PHP" ]; then
    PHP=$(command -v php || true)
fi
if [ -z "$PHP" ] || [ ! -x "$PHP" ]; then
    echo "ERREUR : aucun binaire PHP utilisable. Deploiement abandonne."
    exit 1
fi
echo "PHP     : $PHP ($("$PHP" -r 'echo PHP_VERSION;'))"

# Laravel 13 exige PHP 8.3. Sans ce garde-fou l'application casse a la
# premiere requete, avec une erreur illisible.
if ! "$PHP" -r 'exit(PHP_VERSION_ID >= 80300 ? 0 : 1);'; then
    echo "ERREUR : PHP 8.3 minimum requis par Laravel 13. Deploiement abandonne."
    exit 1
fi

# --- Garde-fou : .env ------------------------------------------------------
# Sans .env, migrate echoue apres avoir deja remplace le code : on verifie
# avant de toucher quoi que ce soit.
if [ ! -f "$APP/.env" ]; then
    echo "ERREUR : $APP/.env absent. Le creer d'abord (DEPLOY.md 4)."
    exit 1
fi

# --- Mise a jour du depot ---------------------------------------------------
if [ -d "$REPO/.git" ] && command -v git >/dev/null 2>&1; then
    cd "$REPO" || exit 1
    BRANCHE=$(git branch --show-current 2>/dev/null)
    BRANCHE=${BRANCHE:-master}
    echo "--- git fetch + reset --hard origin/$BRANCHE ---"

    # `git pull` ne restaure PAS les fichiers supprimes localement : il
    # n'applique que les nouveautes du distant. Le 16 aout 2026, resources/
    # manquait sur le serveur et chaque pull le laissait manquant, puisque le
    # dossier n'avait pas bouge sur GitHub. `reset --hard` aligne le clone sur
    # le distant et restaure tout ce qui a disparu.
    #
    # Les modifications locales du clone sont donc ecrasees : c'est voulu, ce
    # depot est un miroir de deploiement, il n'a pas vocation a etre edite.
    git fetch origin "$BRANCHE" || {
        echo "ERREUR : git fetch a echoue. Deploiement abandonne."
        exit 1
    }
    git reset --hard "origin/$BRANCHE" || {
        echo "ERREUR : git reset a echoue. Deploiement abandonne."
        exit 1
    }
    echo "Clone aligne sur : $(git log --oneline -1)"

    # Le git reset ci-dessus peut avoir mis a jour CE script. Bash continuerait
    # alors d'executer l'ancienne version, et le correctif ne prendrait effet
    # qu'au deploiement suivant. On relance donc une fois la version fraiche.
    # DEPLOY_REEXEC empeche toute boucle.
    if [ -z "${DEPLOY_REEXEC:-}" ]; then
        export DEPLOY_REEXEC=1
        echo "Relance avec la version a jour du script."
        exec /bin/bash "$REPO/deploy/deploy.sh"
    fi
else
    echo "git indisponible ou depot absent : deploiement des fichiers en place."
fi
cd "$REPO" || exit 1

# --- Verification des sources ----------------------------------------------
# Controle AVANT de toucher a $APP : une copie partielle laisserait une
# application cassee, mise en cache puis remise en ligne comme si tout allait
# bien. C'est exactement ce qui s'est produit le 16 aout 2026, ou l'absence de
# resources/ n'a pas interrompu le deploiement.
MANQUE=""
for src in app bootstrap config database public resources routes storage artisan composer.json composer.lock; do
    [ -e "$REPO/$src" ] || MANQUE="$MANQUE $src"
done
if [ -n "$MANQUE" ]; then
    echo "ERREUR : sources absentes du depot :$MANQUE"
    echo "Contenu reel de $REPO :"
    ls -la "$REPO"
    echo "Deploiement abandonne, rien n'a ete modifie."
    exit 1
fi

# --- Mode maintenance -------------------------------------------------------
[ -f "$APP/artisan" ] && "$PHP" "$APP/artisan" down --render=errors::503 || true

# --- Code applicatif --------------------------------------------------------
# Les dossiers cibles sont supprimes avant copie : sans cela `cp -R app $APP/`
# creerait $APP/app/app au deuxieme passage, et les fichiers supprimes du
# depot survivraient sur le serveur.
mkdir -p "$APP" "$WEB"
rm -rf "$APP/app" "$APP/config" "$APP/database" "$APP/resources" "$APP/routes"
cp -R app config database resources routes "$APP/" || {
    echo "ERREUR : copie du code applicatif incomplete. Site laisse en maintenance."
    exit 1
}

# bootstrap/ contient bootstrap/cache (caches generes) : on remplace le code
# sans toucher au dossier cache.
rm -rf "$APP/bootstrap/providers.php" "$APP/bootstrap/app.php"
cp -R bootstrap/. "$APP/bootstrap/"
mkdir -p "$APP/bootstrap/cache"
cp artisan composer.json composer.lock "$APP/"

# storage/ n'est copie qu'au premier deploiement : il contient les fichiers
# televerses, les logs et les caches du serveur.
[ -d "$APP/storage" ] || cp -R storage "$APP/"

# --- Racine web -------------------------------------------------------------
# public/. copie le contenu, pas le dossier ; le lien symbolique
# public_html/storage n'est pas touche.
cp -R public/. "$WEB/"
# index.php de production : chemins pointes vers ~/laravel
cp deploy/index.php "$WEB/index.php"
# Apache sert index.html avant index.php : la page d'attente masquerait le site.
rm -f "$WEB/index.html"

# --- Dependances ------------------------------------------------------------
# Si composer est absent du serveur, vendor/ doit avoir ete televerse a la
# main (DEPLOY.md 9). On ne considere pas son absence comme fatale ici, mais
# on refuse de continuer sans vendor/ du tout.
COMPOSER=$(command -v composer || true)
[ -x /opt/cpanel/composer/bin/composer ] && COMPOSER=/opt/cpanel/composer/bin/composer

if [ -n "$COMPOSER" ]; then
    echo "--- composer install ---"
    cd "$APP" && "$PHP" "$COMPOSER" install --no-dev --no-interaction --optimize-autoloader
else
    echo "composer introuvable : vendor/ televerse a la main est utilise tel quel."
fi

if [ ! -f "$APP/vendor/autoload.php" ]; then
    echo "ERREUR : $APP/vendor/autoload.php absent et composer indisponible."
    echo "Televerser vendor.zip puis relancer (DEPLOY.md 9)."
    exit 1
fi

# --- Base de donnees et caches ---------------------------------------------
cd "$APP" || exit 1
echo "--- migrations ---"
"$PHP" artisan migrate --force || {
    echo "ERREUR : migrate a echoue. Le site reste en maintenance."
    exit 1
}

for c in config:cache route:cache view:cache; do
    "$PHP" artisan "$c" || {
        echo "ERREUR : artisan $c a echoue. Site laisse en maintenance."
        exit 1
    }
done

# --- Lien storage -----------------------------------------------------------
# `artisan storage:link` echoue ici : il vise public_path(), soit
# $APP/public/storage, alors que la racine web est $WEB. On cree donc le lien
# a la main, vers le bon emplacement.
mkdir -p "$APP/storage/app/public"
ln -sfn "$APP/storage/app/public" "$WEB/storage" || {
    echo "AVERTISSEMENT : lien $WEB/storage non cree, les images televersees ne s'afficheront pas."
}

# --- Permissions et fin de maintenance --------------------------------------
chmod -R 775 "$APP/storage" "$APP/bootstrap/cache"
"$PHP" artisan up
echo "Site remis en ligne."

echo "Deploiement termine : $(date)"
