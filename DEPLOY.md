# Déploiement — tharamotors.com

Hébergement cPanel (Jupiter), compte `tharamotors`, quota 20 Go.
DNS : `ns1.whazhe.com` / `ns2.whazhe.com`.

## 0. Prérequis bloquants

- [x] Accès cPanel rétabli (serveur de nouveau disponible, 14 août 2026)
- [ ] `public_html` vidé de tout fichier non identifié
- [ ] Accès SSH ouvert et clé autorisée (cPanel → *SSH Access* → *Manage SSH Keys*)
- [ ] PHP **8.3 ou supérieur** sélectionné dans cPanel → *Sélectionner la version de PHP*
      (Laravel 13 refuse de démarrer en dessous)
- [ ] Extensions PHP activées : `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`,
      `json`, `mbstring`, `openssl`, `pcre`, `pdo_mysql`, `tokenizer`, `xml`, `zip`

## 1. Base de données

cPanel → *Bases de données MySQL* :

1. Créer la base `tharamotors_prod`
2. Créer l'utilisateur `tharamotors_user` avec un mot de passe fort
3. Associer l'utilisateur à la base avec **TOUS LES PRIVILÈGES**

cPanel préfixe automatiquement les noms avec `tharamotors_` — reporter les noms
complets tels qu'affichés dans le `.env`.

## 2. Arborescence sur le serveur

Le code applicatif ne doit **jamais** être servi par le web. Seul `public/`
est exposé.

```
/home/tharamotors/
├── laravel/              ← tout le projet SAUF public/
│   ├── app/  bootstrap/  config/  database/
│   ├── resources/  routes/  storage/  vendor/
│   ├── artisan  composer.json  .env
└── public_html/          ← contenu de public/
    ├── .htaccess  index.php  robots.txt
    ├── build/  images/
    └── storage/          ← lien symbolique (étape 5)
```

Un troisième dossier s'ajoute, `~/repositories/tharamotors`, où cPanel garde le
clone git. Il n'est ni servi par le web, ni utilisé à l'exécution.

### `public_html/index.php`

Rien à modifier à la main : `deploy/index.php` du dépôt contient déjà les
chemins de production (`__DIR__.'/../laravel/...'`) et le déploiement l'installe
par-dessus la copie de `public/index.php`.

## 3. Envoi des fichiers — cPanel *Git™ Version Control*

Le dépôt <https://github.com/Sangahamed/tharamotors> est **public** : cPanel le
clone en HTTPS, aucune clé de déploiement n'est nécessaire côté GitHub.

### 3.1 Cloner le dépôt

cPanel → *Git™ Version Control* → **Create** :

| Champ | Valeur |
|---|---|
| Clone a Repository | activé |
| Clone URL | `https://github.com/Sangahamed/tharamotors.git` |
| Repository Path | `/home/tharamotors/repositories/tharamotors` |
| Repository Name | `tharamotors` |

> Le chemin du dépôt n'est **pas** `public_html` ni `laravel`. cPanel garde le
> clone à part et `.cpanel.yml` répartit ensuite les fichiers.

### 3.2 Branche déployée

Onglet *Manage* → **Checked-Out Branch** → sélectionner la branche de
production, puis *Update*.

### 3.3 Déployer

Onglet *Pull or Deploy* → **Update from Remote** puis **Deploy HEAD Commit**.

`.cpanel.yml` (à la racine du dépôt) exécute alors, dans l'ordre :

1. `php artisan down` si l'appli est déjà installée
2. copie du code applicatif vers `~/laravel/` (sans `storage/`, préservé)
3. copie de `public/` vers `~/public_html/`, puis de `deploy/index.php` par-dessus
   `public_html/index.php` (chemins ajustés vers `~/laravel`)
4. `composer install --no-dev --optimize-autoloader`
5. `migrate --force`, `config:cache`, `route:cache`, `view:cache`, `storage:link`
6. `php artisan up`

Le journal complet s'affiche dans l'onglet *Pull or Deploy* — en cas d'échec,
c'est là que se trouve l'erreur.

### 3.4 Points à vérifier avant le premier déploiement

- Le chemin PHP dans `.cpanel.yml` (`/opt/cpanel/ea-php83/root/usr/bin/php`)
  doit exister. Le confirmer en SSH : `ls /opt/cpanel/ea-php*/root/usr/bin/php`
  et corriger la variable `PHP` si la version diffère.
- Composer doit être présent en `/opt/cpanel/composer/bin/composer`. Sinon :
  `which composer` en SSH, et adapter la tâche correspondante.
- `~/laravel/.env` doit exister **avant** le premier déploiement (étape 4) :
  `migrate` échouerait sinon. Il n'est jamais écrasé par le déploiement.

### Ce qui n'est pas versionné

`node_modules/`, `vendor/`, `.env`, `public/images.zip` (27 Mo inutiles) et
`storage/` restent hors dépôt. `vendor/` est reconstruit par Composer sur le
serveur.

En revanche `public/build/` **est** versionné : le serveur n'a pas Node. Après
toute modification de `resources/css` ou `resources/js`, relancer en local :

```bash
npm run build
git add public/build && git commit -m "build assets"
```

## 4. Configuration — **avant** le premier déploiement

`.env` n'est jamais versionné ni écrasé : il se crée une seule fois, à la main,
et il doit exister avant le premier *Deploy HEAD Commit* (sinon `migrate`
échoue).

```bash
mkdir -p /home/tharamotors/laravel
cd /home/tharamotors/laravel
# coller le contenu de .env.production.example, puis completer
# DB_PASSWORD et MAIL_PASSWORD
nano .env
```

Générer ensuite la clé applicative, en local :

```bash
php artisan key:generate --show
```

et coller la valeur (`base64:...`) dans `APP_KEY` du `.env` serveur. (En SSH,
`php artisan key:generate` fonctionne aussi, mais seulement une fois `vendor/`
installé — donc après le premier déploiement.)

> ⚠️ La clé du `.env` local est à considérer comme compromise (le serveur
> l'était). Générer une **nouvelle** clé pour la production.

## 5. Permissions, lien storage, migrations, caches

Tout est pris en charge par `.cpanel.yml` à chaque déploiement :
`composer install`, `migrate --force`, `config:cache`, `route:cache`,
`view:cache`, `storage:link`, `chmod 755` sur `storage` et `bootstrap/cache`.

Rien à faire à la main. Si une de ces étapes échoue, le message apparaît dans le
journal de l'onglet *Pull or Deploy*.

## 6. Compte administrateur

Une seule fois, en SSH :

```bash
cd /home/tharamotors/laravel
php artisan tinker
```

## 7. HTTPS

cPanel → *SSL/TLS Status* → activer AutoSSL sur `tharamotors.com` et `www`.

La redirection HTTP → HTTPS est déjà dans `public/.htaccess` du dépôt,
conditionnée à l'hôte `tharamotors.com` (elle n'affecte donc pas le
développement local). Ne pas l'ajouter à la main dans `public_html/.htaccess` :
le fichier est réécrit à chaque déploiement.

## 8. Vérifications finales

- [ ] `https://tharamotors.com` répond en HTTPS sans avertissement
- [ ] Aucune trace de debug affichée sur une URL inexistante (page 404 propre)
- [ ] `https://tharamotors.com/storage/vehicles/…` sert bien une image
- [ ] Formulaire de devis → mail reçu sur `contact@tharamotors.com`
- [ ] Connexion admin fonctionnelle
- [ ] `laravel/storage/logs/` ne contient pas d'erreur après navigation

## Mises à jour ultérieures

En local :

```bash
npm run build                 # si resources/css ou resources/js ont change
git add -A && git commit -m "..."
git push origin master
```

Puis dans cPanel → *Git™ Version Control* → *Pull or Deploy* :
**Update from Remote**, puis **Deploy HEAD Commit**. `.cpanel.yml` refait le
reste (maintenance, copie, composer, migrations, caches).

Équivalent en SSH, sans passer par l'interface :

```bash
cd /home/tharamotors/repositories/tharamotors
git pull
uapi VersionControlDeployment create repository_root=/home/tharamotors/repositories/tharamotors
```

---

## Incident sécurité — août 2026

Avant le premier déploiement, `public_html` contenait trois webshells :
`IKxX22j9o6.php`, `OxZMCq0eOp.php`, `zjRvIHz32U.php` (~15 Ko, noms aléatoires,
déposés entre le 9 et le 10 août 2026). L'accès cPanel renvoyait une erreur 500,
symptôme d'un `.htaccess` altéré.

Mesures prises / à prendre :

- [ ] Hébergeur `digitalworka-ci.com` alerté, scan malware demandé
- [ ] Mots de passe changés : cPanel, FTP, MySQL, comptes email
- [ ] Logs d'accès analysés pour identifier le vecteur d'entrée
- [ ] `public_html` reparti d'un état vide

Ne pas se contenter de supprimer les fichiers : sans identification du vecteur,
la réinfection est probable.
