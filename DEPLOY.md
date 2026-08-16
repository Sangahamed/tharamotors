# Déploiement — tharamotors.com

Hébergement cPanel (Jupiter), compte `tharamotors`, quota 20 Go.
DNS : `ns1.whazhe.com` / `ns2.whazhe.com`.

## 0. Prérequis bloquants

- [x] Accès cPanel rétabli (serveur de nouveau disponible, 16 août 2026)
- [x] Version de PHP modifiable et création de base MySQL débloquées par
      l'hébergeur (16 août 2026)
- [ ] **Accès shell activé sur le compte** — bloquant, voir §0 bis
- [ ] `public_html` vidé de tout fichier non identifié
- [ ] Clé SSH autorisée (cPanel → *SSH Access* → *Manage SSH Keys*)
- [ ] PHP **8.3 ou supérieur** sélectionné dans cPanel → *Sélectionner la version de PHP*
      (Laravel 13 refuse de démarrer en dessous)
- [ ] Extensions PHP activées : `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`,
      `json`, `mbstring`, `openssl`, `pcre`, `pdo_mysql`, `tokenizer`, `xml`, `zip`

## 0 bis. Accès shell — verrou du déploiement

**C'est le blocage en cours (16 août 2026).** *Deploy HEAD Commit* est grisé et
inactif dans cPanel → *Git™ Version Control* → *Pull or Deploy*, alors que la
branche sortie est bien `master`, que le commit correspond au dernier push et
que `.cpanel.yml` est présent et valide.

Cause : le déploiement cPanel exécute les tâches de `.cpanel.yml` **dans un
shell**. Sans shell activé sur le compte, cPanel affiche le bouton et son texte
d'aide (« Run the configured tasks to deploy your repository ») mais ne
l'active jamais. Aucun message d'erreur n'accompagne le bouton : le symptôme est
silencieux, d'où la confusion possible avec un problème de branche ou de dépôt.

Vérification :

```bash
ssh -p 22 tharamotors@tharamotors.com
ssh -p 2222 tharamotors@tharamotors.com   # certains hebergeurs deplacent SSH
```

`Connection refused` sur les deux ports = shell non activé (constaté le
16 août 2026 sur le port 22).

Correction, à demander à `digitalworka-ci.com` :

> Activer l'accès SSH (**jailed shell**) sur le compte cPanel `tharamotors`,
> nécessaire pour la fonction *Git Version Control → Deploy*.

Le jailed shell suffit — c'est le réglage standard en mutualisé, et il se
refuse moins souvent qu'un shell complet.

> **Si l'hébergeur refuse le shell**, le déploiement automatique est
> définitivement impossible : basculer sur la procédure manuelle du **§9**.
> Elle fonctionne, mais chaque mise à jour se refait entièrement à la main —
> dépannage, pas mode de fonctionnement.

## 0 ter. Page d'attente (à faire tout de suite)

Tant que les prérequis ci-dessus ne sont pas levés, le domaine affiche le
contenu brut de `public_html` (`cgi-bin/`) : mauvaise image, et indexation par
les moteurs de recherche d'une page vide.

Téléverser dans `public_html/`, via le Gestionnaire de fichiers ou en SSH :

| Source (dépôt) | Destination |
|---|---|
| `deploy/holding/index.html` | `public_html/index.html` |
| `deploy/holding/.htaccess` | `public_html/.htaccess` |
| `public/images/logo.png` | `public_html/images/logo.png` |

En SSH, depuis le clone cPanel :

```bash
cd /home/tharamotors/repositories/tharamotors
cp deploy/holding/index.html deploy/holding/.htaccess /home/tharamotors/public_html/
mkdir -p /home/tharamotors/public_html/images
cp public/images/logo.png /home/tharamotors/public_html/images/
```

La page est autonome : pas de PHP, pas de base de données, pas de requête
externe. Elle fonctionne donc même avec la version de PHP actuelle du serveur.
`Options -Indexes` supprime l'affichage de `cgi-bin/`.

> Le logo est facultatif : sans lui, la page bascule sur le nom en toutes
> lettres plutôt que d'afficher une image cassée.

**Retrait automatique** : le premier `Deploy HEAD Commit` réussi supprime
`public_html/index.html` (tâche prévue dans `.cpanel.yml`) et remplace le
`.htaccess`. Rien à défaire à la main.

## 0 quater. Ordre du premier déploiement

Les deux premiers blocages hébergeur (version de PHP verrouillée, création de
base MySQL impossible) sont levés depuis le 16 août 2026. Reste l'accès shell
(§0 bis), sans lequel l'étape 7 est inaccessible. Ensuite, **dans cet ordre** —
chaque étape conditionne la suivante :

1. Accès shell activé par l'hébergeur (§0 bis)
2. cPanel → PHP **8.3+** sélectionné, extensions de la §0 activées
3. Base et utilisateur MySQL créés, privilèges accordés (§1)
4. Dépôt cloné dans `~/repositories/tharamotors` (§3.1) et branche choisie (§3.2)
5. `~/laravel/.env` écrit à la main avec une **nouvelle** `APP_KEY` (§4) —
   sans lui `migrate` échoue
6. Chemins `PHP` et `composer` de `.cpanel.yml` vérifiés en SSH (§3.4)
7. *Update from Remote* puis *Deploy HEAD Commit* (§3.3)

Le déploiement supprime lui-même `public_html/index.html` : la page d'attente
disparaît au premier déploiement réussi, rien à défaire à la main.

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

## 9. Déploiement manuel — sans shell

Procédure de repli tant que l'accès shell n'est pas accordé (§0 bis). Elle
n'utilise que FTP et le Gestionnaire de fichiers cPanel. **Aucune commande
`artisan` ne peut être lancée sur le serveur** : tout ce qui en dépend est
préparé en local ou contourné ci-dessous.

À relire avant chaque mise à jour : contrairement au déploiement automatique,
rien n'est rejoué tout seul.

### 9.1 Préparer les fichiers en local

```bash
composer install --no-dev --optimize-autoloader   # produit vendor/
npm run build                                     # si resources/ a change
php artisan key:generate --show                   # noter la cle base64:...
```

La clé sert au `.env` de production (§4). **Générer une nouvelle clé**, celle du
`.env` local est compromise.

Compresser ensuite les deux arborescences — un envoi FTP de `vendor/` fichier
par fichier, c'est des milliers d'éléments et plusieurs heures :

| Archive à créer | Contenu |
|---|---|
| `laravel.zip` | `app/ bootstrap/ config/ database/ resources/ routes/ storage/ vendor/ artisan composer.json composer.lock` |
| `web.zip` | le **contenu** de `public/` (pas le dossier lui-même) |

> Ne pas inclure `bootstrap/cache/*` : un `config.php` généré en local
> contiendrait les chemins et les identifiants de la machine de développement,
> et l'application de production les utiliserait. Le dossier `bootstrap/cache/`
> doit partir **vide**.

### 9.2 Envoyer et extraire

Téléverser les archives par FTP, puis *Extract* dans le Gestionnaire de
fichiers cPanel :

- `laravel.zip` → extraire dans `/home/tharamotors/laravel/`
- `web.zip` → extraire dans `/home/tharamotors/public_html/`

Puis, dans `public_html/` :

- remplacer `index.php` par le contenu de `deploy/index.php` du dépôt
  (chemins pointés vers `~/laravel`) ;
- supprimer `index.html` — la page d'attente, qu'Apache sert **avant**
  `index.php` et qui masquerait le site.

### 9.3 `.env`

Créer `/home/tharamotors/laravel/.env` avec le Gestionnaire de fichiers, à
partir de `.env.production.example` (§4). Compléter `APP_KEY` (celle du §9.1),
`DB_PASSWORD` et `MAIL_PASSWORD`. Vérifier `APP_DEBUG=false`.

### 9.4 Base de données — sans `artisan migrate`

Les migrations se jouent en local, puis le schéma est importé :

```bash
# sur une base locale vide, aux memes nom et version que la production
php artisan migrate
mysqldump -u root tharamotors_local > schema.sql
```

cPanel → *phpMyAdmin* → base `tharamotors_prod` → *Importer* → `schema.sql`.

> Vérifier que le dump ne contient pas de données de test : `SESSION_DRIVER`,
> `CACHE_STORE` et `QUEUE_CONNECTION` sont sur `database`, donc les tables
> `sessions`, `cache` et `jobs` doivent partir **vides**.

### 9.5 Lien `storage` — sans `artisan storage:link`

Le Gestionnaire de fichiers ne sait pas créer de lien symbolique. Déposer
temporairement dans `public_html/` un fichier `lien.php` :

```php
<?php
symlink(
    '/home/tharamotors/laravel/storage/app/public',
    '/home/tharamotors/public_html/storage'
);
```

L'appeler **une fois** dans le navigateur, puis **supprimer immédiatement le
fichier**. Un script exécutable laissé dans `public_html/` est exactement le
type de porte d'entrée à l'origine de l'incident d'août 2026 (voir plus bas) :
ne pas le laisser « au cas où ».

### 9.6 Permissions et caches

Gestionnaire de fichiers → *Permissions*, en récursif :

- `laravel/storage/` → `755`
- `laravel/bootstrap/cache/` → `755`

Les caches `config:cache`, `route:cache` et `view:cache` ne peuvent pas être
générés. Ce n'est pas bloquant : Laravel fonctionne sans, simplement un peu
plus lentement. Ne **pas** tenter de les produire en local et de les
téléverser, pour la raison donnée en §9.1.

### 9.7 Limites de cette procédure

- Aucun mode maintenance : le site est incohérent pendant l'envoi.
- Aucun retour arrière automatique en cas d'erreur.
- Chaque mise à jour, même d'une ligne, impose de refaire §9.1 → §9.6.
- Les migrations futures devront être rejouées à la main par phpMyAdmin, avec
  le risque de désynchronisation entre `migrations` locale et production.

C'est pourquoi l'accès shell (§0 bis) reste la vraie solution : cette
procédure est un dépannage, pas un mode de fonctionnement.

## Mises à jour ultérieures

> Sans accès shell, ces étapes ne s'appliquent pas — voir §9.

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
