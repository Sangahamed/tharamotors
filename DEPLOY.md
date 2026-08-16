# Déploiement — tharamotors.com

Hébergement cPanel (Jupiter), compte `tharamotors`, quota 20 Go.
DNS : `ns1.whazhe.com` / `ns2.whazhe.com`.

## 0. Prérequis bloquants

- [x] Accès cPanel rétabli (serveur de nouveau disponible, 16 août 2026)
- [x] Version de PHP modifiable et création de base MySQL débloquées par
      l'hébergeur (16 août 2026)
- [~] **Accès shell** — *indisponible sur l'offre souscrite* (réponse de
      l'hébergeur, 16 août 2026). Contourné par les tâches cron, voir §0 bis
      et §9
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

**Réponse de l'hébergeur (16 août 2026) : l'accès SSH n'est pas disponible sur
l'offre souscrite.** Le bouton *Deploy HEAD Commit* restera donc inactif tant
que le compte n'est pas monté en gamme.

### Contournement retenu : les tâches cron

Les **tâches cron cPanel s'exécutent, elles, dans un shell**, sous
l'utilisateur du compte. `artisan`, `composer` et `git` redeviennent donc
accessibles, et le script `deploy/deploy.sh` rejoue les étapes de
`.cpanel.yml`. C'est la méthode de déploiement du projet : **§9**.

Cron a été confirmé fonctionnel sur le compte le 16 août 2026.

Si les tâches cron venaient elles aussi à manquer, il resterait la procédure
100 % manuelle du **§10** — dépannage, pas mode de fonctionnement.

### Question ouverte : montée en gamme

Reste à demander à `digitalworka-ci.com` **quelle formule inclut l'accès SSH,
et à quel tarif**. Si l'écart est faible, l'upgrade rétablit le déploiement en
un clic et supprime la manipulation cron à chaque mise à jour.

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

**Retrait automatique** : le premier déploiement réussi supprime
`public_html/index.html` et remplace le `.htaccess`. Rien à défaire à la main.
La tâche est prévue à la fois dans `.cpanel.yml` et dans `deploy/deploy.sh`,
donc quelle que soit la méthode employée.

## 0 quater. Ordre du premier déploiement

Les blocages sur la version de PHP et la création de base MySQL sont levés
depuis le 16 août 2026. L'accès SSH, lui, n'existe pas sur l'offre : le
déploiement passe par une tâche cron (§0 bis et §9). **Dans cet ordre** —
chaque étape conditionne la suivante :

1. cPanel → PHP **8.3+** sélectionné, extensions de la §0 activées
2. Base et utilisateur MySQL créés, privilèges accordés (§1)
3. Dépôt cloné dans `~/repositories/tharamotors` (§3.1) et branche choisie (§3.2)
4. `~/laravel/.env` écrit à la main avec une **nouvelle** `APP_KEY` (§4) —
   sans lui `deploy.sh` s'arrête avant de toucher aux fichiers
5. Tâche cron de diagnostic pour situer `php`, `composer` et `git` (§9.1)
6. `vendor.zip` téléversé si `composer` est absent du serveur (§10.1)
7. Tâche cron de déploiement, passée une fois puis supprimée (§9.3)

Le script supprime lui-même `public_html/index.html` : la page d'attente
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

> ⚠️ **Indisponible sur l'offre actuelle.** *Deploy HEAD Commit* exige un accès
> shell que le compte n'a pas (§0 bis) : le bouton reste grisé. Cette section
> décrit la cible, à utiliser telle quelle après une éventuelle montée en
> gamme. En attendant, déployer par tâche cron — **§9**.

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

## 9. Déploiement par tâche cron — sans SSH

**C'est la méthode retenue.** L'accès SSH interactif n'est pas disponible sur
l'offre (§0 bis), mais les **tâches cron cPanel s'exécutent dans un shell**,
sous l'utilisateur du compte. On retrouve donc `artisan`, `composer` et `git` :
l'essentiel du déploiement automatique, sans passer par le bouton *Deploy HEAD
Commit* qui reste inactif.

Le script `deploy/deploy.sh` du dépôt reprend les étapes de `.cpanel.yml`. Il
est idempotent : le relancer est sans danger.

### 9.1 Diagnostic — ce dont dispose le serveur

Avant tout, savoir si `composer` et `git` sont présents : cela détermine s'il
faut téléverser `vendor/` à la main. cPanel → *Tâches cron*, exécution dans
5 minutes, commande :

```bash
{ date; echo "--- PHP ---"; ls /opt/cpanel/ea-php*/root/usr/bin/php; command -v php; php -v | head -1; echo "--- COMPOSER ---"; command -v composer; ls -l /opt/cpanel/composer/bin/composer; echo "--- GIT ---"; command -v git; git --version; echo "--- DEPOT ---"; ls -d /home/tharamotors/repositories/tharamotors; } > /home/tharamotors/diag.log 2>&1
```

Lire ensuite `/home/tharamotors/diag.log` dans le Gestionnaire de fichiers,
puis **supprimer la tâche**. Trois cas :

| Résultat | Suite |
|---|---|
| `composer` **et** `git` présents | Idéal : §9.2, rien à téléverser |
| `git` seul | §9.2, mais téléverser `vendor.zip` (§10.1) |
| Aucun des deux | Tout téléverser à la main : §10 |

### 9.2 Mise en place

1. Créer `/home/tharamotors/laravel/.env` (§4) — le script refuse de démarrer
   sans lui, avant d'avoir touché au moindre fichier.
2. Vérifier que le dépôt est cloné dans `~/repositories/tharamotors` (§3.1).
   Sinon, téléverser le code à la main (§10.2) : le script fonctionne aussi
   sans `git`, il se contente alors de déployer les fichiers en place.
3. Si `composer` est absent, téléverser `vendor.zip` et l'extraire dans
   `/home/tharamotors/laravel/` (§10.1).

### 9.3 La tâche cron de déploiement

cPanel → *Tâches cron*. Commande :

```bash
/bin/bash /home/tharamotors/repositories/tharamotors/deploy/deploy.sh >> /home/tharamotors/deploy.log 2>&1
```

> **Ne pas la laisser sur une fréquence récurrente.** Le déploiement se
> déclenche à la demande : programmer l'exécution quelques minutes plus tard,
> laisser tourner, puis **supprimer la tâche**. Une tâche laissée toutes les
> cinq minutes rejouerait `migrate` et les copies de fichiers en boucle.

Le journal complet est dans `/home/tharamotors/deploy.log`, lisible depuis le
Gestionnaire de fichiers. Le script s'arrête et laisse le site en maintenance
si PHP est trop ancien, si `.env` manque, si `git pull` échoue, si `vendor/`
est introuvable ou si `migrate` échoue — le message est alors en clair dans le
journal.

### 9.4 Mises à jour suivantes

En local : `npm run build` si `resources/` a changé, puis `git push`. Sur le
serveur : recréer la tâche cron du §9.3, la laisser passer une fois, la
supprimer. Le `git pull` du script récupère le nouveau code.

## 10. Déploiement 100 % manuel — dernier recours

Uniquement si les tâches cron sont elles aussi indisponibles, ou si ni `git`
ni `composer` ne sont présents sur le serveur (§9.1). **Aucune commande
`artisan` ne peut alors être lancée** : tout ce qui en dépend est préparé en
local ou contourné ci-dessous.

Elle n'utilise que FTP et le Gestionnaire de fichiers cPanel.

À relire avant chaque mise à jour : contrairement au déploiement automatique,
rien n'est rejoué tout seul.

### 10.1 Préparer les fichiers en local

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

### 10.2 Envoyer et extraire

Téléverser les archives par FTP, puis *Extract* dans le Gestionnaire de
fichiers cPanel :

- `laravel.zip` → extraire dans `/home/tharamotors/laravel/`
- `web.zip` → extraire dans `/home/tharamotors/public_html/`

Puis, dans `public_html/` :

- remplacer `index.php` par le contenu de `deploy/index.php` du dépôt
  (chemins pointés vers `~/laravel`) ;
- supprimer `index.html` — la page d'attente, qu'Apache sert **avant**
  `index.php` et qui masquerait le site.

### 10.3 `.env`

Créer `/home/tharamotors/laravel/.env` avec le Gestionnaire de fichiers, à
partir de `.env.production.example` (§4). Compléter `APP_KEY` (celle du §9.1),
`DB_PASSWORD` et `MAIL_PASSWORD`. Vérifier `APP_DEBUG=false`.

### 10.4 Base de données — sans `artisan migrate`

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

### 10.5 Lien `storage` — sans `artisan storage:link`

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

### 10.6 Permissions et caches

Gestionnaire de fichiers → *Permissions*, en récursif :

- `laravel/storage/` → `755`
- `laravel/bootstrap/cache/` → `755`

Les caches `config:cache`, `route:cache` et `view:cache` ne peuvent pas être
générés. Ce n'est pas bloquant : Laravel fonctionne sans, simplement un peu
plus lentement. Ne **pas** tenter de les produire en local et de les
téléverser, pour la raison donnée en §9.1.

### 10.7 Limites de cette procédure

- Aucun mode maintenance : le site est incohérent pendant l'envoi.
- Aucun retour arrière automatique en cas d'erreur.
- Chaque mise à jour, même d'une ligne, impose de refaire §9.1 → §9.6.
- Les migrations futures devront être rejouées à la main par phpMyAdmin, avec
  le risque de désynchronisation entre `migrations` locale et production.

C'est pourquoi l'accès shell (§0 bis) reste la vraie solution : cette
procédure est un dépannage, pas un mode de fonctionnement.

## Mises à jour ultérieures

> Sur l'offre actuelle, seule la partie locale ci-dessous s'applique : côté
> serveur, le déploiement passe par la tâche cron du **§9.4**.

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
