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
    echo "--- git pull ---"
    cd "$REPO" && git pull --ff-only || {
        echo "ERREUR : git pull a echoue. Deploiement abandonne."
        exit 1
    }
else
    echo "git indisponible ou depot absent : deploiement des fichiers en place."
fi
cd "$REPO" || exit 1

# --- Mode maintenance -------------------------------------------------------
[ -f "$APP/artisan" ] && "$PHP" "$APP/artisan" down --render=errors::503 || true

# --- Code applicatif --------------------------------------------------------
# Les dossiers cibles sont supprimes avant copie : sans cela `cp -R app $APP/`
# creerait $APP/app/app au deuxieme passage, et les fichiers supprimes du
# depot survivraient sur le serveur.
mkdir -p "$APP" "$WEB"
rm -rf "$APP/app" "$APP/config" "$APP/database" "$APP/resources" "$APP/routes"
cp -R app config database resources routes "$APP/"

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

"$PHP" artisan config:cache
"$PHP" artisan route:cache
"$PHP" artisan view:cache
"$PHP" artisan storage:link || true

# --- Permissions et fin de maintenance --------------------------------------
chmod -R 775 "$APP/storage" "$APP/bootstrap/cache"
"$PHP" artisan up

echo "Deploiement termine : $(date)"
