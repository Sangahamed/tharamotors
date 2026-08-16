#!/bin/bash
#
# Diagnostic de l'environnement serveur, declenche par une tache cron cPanel.
#
# Repond a une seule question : de quoi dispose le compte pour deployer ?
# Selon la presence de git et composer, le deploiement se fait entierement par
# deploy.sh, ou bien vendor/ doit etre televerse a la main (DEPLOY.md 9.1).
#
# Appel depuis cPanel > Taches cron :
#   /bin/bash /home/tharamotors/repositories/tharamotors/deploy/diag.sh
#
# Ecrit /home/tharamotors/diag.log, a lire dans le Gestionnaire de fichiers.
# Ne modifie rien : le lancer est sans consequence.

LOG=/home/tharamotors/diag.log

{
    echo "=============================================================="
    echo "Diagnostic serveur : $(date)"
    echo "Compte  : $(whoami)"
    echo "Shell   : $SHELL"
    echo "=============================================================="

    echo
    echo "--- PHP ---"
    # Les binaires cPanel par version, puis celui du PATH.
    ls -1 /opt/cpanel/ea-php*/root/usr/bin/php 2>/dev/null || echo "aucun binaire /opt/cpanel/ea-php*"
    echo "php du PATH : $(command -v php || echo 'absent')"
    echo "/usr/local/bin/php : $([ -x /usr/local/bin/php ] && echo present || echo absent)"
    for bin in /opt/cpanel/ea-php83/root/usr/bin/php /usr/local/bin/php "$(command -v php)"; do
        [ -x "$bin" ] && echo "  $bin -> $("$bin" -r 'echo PHP_VERSION;' 2>/dev/null)"
    done

    echo
    echo "--- Extensions PHP requises ---"
    PHPBIN=/opt/cpanel/ea-php83/root/usr/bin/php
    [ -x "$PHPBIN" ] || PHPBIN=$(command -v php)
    if [ -x "$PHPBIN" ]; then
        for ext in bcmath ctype curl dom fileinfo json mbstring openssl pdo_mysql tokenizer xml zip; do
            if "$PHPBIN" -m 2>/dev/null | grep -qix "$ext"; then
                echo "  OK      $ext"
            else
                echo "  MANQUE  $ext"
            fi
        done
    else
        echo "  (pas de binaire PHP utilisable pour tester)"
    fi

    echo
    echo "--- Composer ---"
    echo "composer du PATH   : $(command -v composer || echo 'absent')"
    echo "/opt/cpanel/composer/bin/composer : $([ -x /opt/cpanel/composer/bin/composer ] && echo present || echo absent)"

    echo
    echo "--- Git ---"
    echo "git : $(command -v git || echo 'absent')"
    command -v git >/dev/null && git --version

    echo
    echo "--- Arborescence ---"
    for d in /home/tharamotors/repositories/tharamotors /home/tharamotors/laravel /home/tharamotors/public_html; do
        [ -d "$d" ] && echo "  present : $d" || echo "  absent  : $d"
    done
    echo "  .env applicatif : $([ -f /home/tharamotors/laravel/.env ] && echo present || echo ABSENT)"
    echo "  vendor/         : $([ -f /home/tharamotors/laravel/vendor/autoload.php ] && echo present || echo absent)"

    echo
    echo "--- Contenu de public_html ---"
    ls -la /home/tharamotors/public_html 2>/dev/null | head -20

    echo
    echo "--- Depot clone ---"
    if [ -d /home/tharamotors/repositories/tharamotors/.git ]; then
        cd /home/tharamotors/repositories/tharamotors || exit 0
        echo "  branche : $(git branch --show-current 2>/dev/null)"
        echo "  commit  : $(git log --oneline -1 2>/dev/null)"
        echo "  deploy.sh present : $([ -f deploy/deploy.sh ] && echo oui || echo NON)"
    else
        echo "  pas de depot git clone"
    fi

    echo
    echo "Diagnostic termine."
} > "$LOG" 2>&1
