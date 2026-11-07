# 🛠️ ChatConnect – Technisches Handbuch & Admin-Schulung
## Installation auf dem Raspberry Pi (`pironman`), Git-Workflow & `php artisan` Referenz

**Autor:** Antigravity AI für Robert Hofer  
**Stand:** November 2026  
**Entwicklungsumgebung (Lokal):** Windows mit Laragon (`C:\laragon\www\ChatConnect`)  
**GitHub-Repository:** `https://github.com/roberthoferzuerich-alt/chatconnect-backend.git`  
**Produktionsserver:** Raspberry Pi (`pi@pironman:/var/www/chatconnect` • `https://rhz.internet-box.ch:8443`)

---

## 📑 Inhaltsverzeichnis

1. [🏗️ 1. Architektur-Überblick: Wie Zusammenspiel & Deployment funktionieren](#1-architektur-überblick-wie-zusammenspiel--deployment-funktionieren)
2. [🍓 2. Komplette Installation & Einrichtung auf dem Raspberry Pi (`pironman`)](#2-komplette-installation--einrichtung-auf-dem-raspberry-pi-pironman)
3. [🌿 3. Ausführliche Git-Schulung: Schritt für Schritt verstehen & anwenden](#3-ausführliche-git-schulung-schritt-für-schritt-verstehen--anwenden)
4. [⚡ 4. Ausführliche `php artisan` Schulung: Dein Schweizer Taschenmesser für Laravel](#4-ausführliche-php-artisan-schulung-dein-schweizer-taschenmesser-für-laravel)
5. [💾 5. Datenbank-Backup, Synchronisation & Notfall-Wiederherstellung](#5-datenbank-backup-synchronisation--notfall-wiederherstellung)
6. [📋 6. Täglicher Admin-Spickzettel (Cheat Sheet zum Ausdrucken)](#6-täglicher-admin-spickzettel-cheat-sheet-zum-ausdrucken)

---

## 1. 🏗️ Architektur-Überblick: Wie Zusammenspiel & Deployment funktionieren

Damit jederzeit klar ist, wo welche Änderung passiert, hilft dieses mentale Modell aus **3 Stationen**:

```text
┌────────────────────────────────────┐
│ 1. LOKAL (Windows / Laragon)       │  Hier programmieren und testen wir.
│    Pfad: C:\laragon\www\ChatConnect│  Befehle: npm run build, git add, git commit, git push
└─────────────────┬──────────────────┘
                  │
                  ▼  (git push origin main)
┌────────────────────────────────────┐
│ 2. GITHUB (Cloud-Zwischenspeicher) │  Sicherer Online-Tresor für deinen Programmcode.
│    roberthoferzuerich-alt/         │  Speichert alle Versionen (Commits), aber KEINE
│    chatconnect-backend.git         │  privaten Passwörter (.env) und KEINE Datenbank!
└─────────────────┬──────────────────┘
                  │
                  ▼  (git pull origin main)
┌────────────────────────────────────┐
│ 3. PRODUKTION (Raspberry Pi)       │  Dein Live-Server für die ganze Familie.
│    pi@pironman:/var/www/chatconnect│  Befehle: git pull origin main, php artisan optimize:clear
└────────────────────────────────────┘
```

> **💡 Wichtigste Grundregel:**  
> **Git überträgt immer nur den Programmcode (Dateien), niemals die Datenbank oder die `.env`-Datei.**  
> Dadurch gehen beim Einspielen eines Updates (`git pull`) auf dem Raspberry Pi **niemals** bestehende Chats, Fotos oder Benutzer auf dem Pi verloren!

---

## 2. 🍓 Komplette Installation & Einrichtung auf dem Raspberry Pi (`pironman`)

Falls du den Raspberry Pi einmal komplett neu aufsetzen möchtest oder nachschlagen willst, wie alles eingerichtet ist, findest du hier die vollständige Installationsanleitung.

### 2.1 System-Pakete & PHP 8.3+ installieren
Auf dem Raspberry Pi (Raspberry Pi OS / Debian Bookworm 64-Bit) per SSH einloggen:

```bash
# Paketlisten aktualisieren
sudo apt update && sudo apt upgrade -y

# Grundwerkzeuge, Git, Unzip, OpenSCAD (für 3D-Compiler) & Datenbank installieren
sudo apt install -y git curl unzip zip mariadb-server nginx openscad

# PHP und alle von Laravel benötigten Erweiterungen installieren
sudo apt install -y php-fpm php-mysql php-mbstring php-xml php-curl php-zip php-gd php-bcmath php-intl php-sqlite3
```

### 2.2 Composer (PHP-Paketmanager) & Node.js installieren
```bash
# Composer global installieren
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Prüfen, ob PHP und Composer bereit sind
php -v
composer -V
```

### 2.3 MariaDB-Datenbank für ChatConnect anlegen
```bash
sudo mysql -u root
```
Im MySQL-Prompt folgende SQL-Befehle ausführen (Passwort anpassen):
```sql
CREATE DATABASE chatconnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'chatconnect_user'@'localhost' IDENTIFIED BY 'DEIN_SICHERES_DB_PASSWORT';
GRANT ALL PRIVILEGES ON chatconnect.* TO 'chatconnect_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2.4 Projekt von GitHub nach `/var/www/chatconnect` klonen
```bash
cd /var/www
sudo git clone https://github.com/roberthoferzuerich-alt/chatconnect-backend.git chatconnect

# Besitzer sofort auf deinen Benutzer 'pi' und die Webserver-Gruppe 'www-data' setzen
sudo chown -R pi:www-data /var/www/chatconnect
cd /var/www/chatconnect

# PHP-Abhängigkeiten installieren
composer install --no-dev --optimize-autoloader
```

### 2.5 `.env`-Konfiguration auf dem Raspberry Pi einrichten
```bash
cp .env.example .env
php artisan key:generate
nano .env
```
Wichtige Werte in der `.env` auf dem Raspberry Pi:
```ini
APP_NAME=ChatConnect
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rhz.internet-box.ch:8443

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chatconnect
DB_USERNAME=chatconnect_user
DB_PASSWORD=DEIN_SICHERES_DB_PASSWORT

SESSION_DRIVER=database
SESSION_LIFETIME=43200
```

### 2.6 Datenbank-Tabellen & Storage-Link erstellen
```bash
# Erstellt alle Tabellen (users, conversations, messages, calls, stories ...)
php artisan migrate --force

# Verknüpft storage/app/public mit public/storage (für hochgeladene Bilder, Sprachmemos & STLs)
php artisan storage:link
```

### 2.7 Dateiberechtigungen (Permissions) auf dem Raspberry Pi richtig setzen
Dies ist auf Linux-Servern entscheidend:
- **Du (`pi`)** führst `git pull` und `php artisan` aus.
- **Der Webserver (`www-data`)** speichert hochgeladene Fotos, Sprachnachrichten und Logdateien.

Mit diesen 3 Befehlen arbeiten `pi` und `www-data` Hand in Hand, ohne sich gegenseitig zu blockieren:
```bash
# 1. Benutzer 'pi' zur Gruppe 'www-data' hinzufügen
sudo usermod -a -G www-data pi

# 2. Ganzes Projekt gehört Benutzer 'pi' und Gruppe 'www-data'
sudo chown -R pi:www-data /var/www/chatconnect

# 3. Schreibrechte für Gruppe www-data auf storage und bootstrap/cache geben
sudo chmod -R 775 /var/www/chatconnect/storage /var/www/chatconnect/bootstrap/cache
```

### 2.8 Automatischer Start für Story-Cleanup (Cronjob)
Damit abgelaufene 24h-Storys automatisch aufgeräumt werden:
```bash
crontab -e
```
Folgende Zeile ganz unten eintragen:
```cron
* * * * * cd /var/www/chatconnect && php artisan schedule:run >> /dev/null 2>&1
```

---

## 3. 🌿 Ausführliche Git-Schulung: Schritt für Schritt verstehen & anwenden

### 3.1 Wie Git intern denkt (Die 4 Stufen)
Stell dir Git wie den Versand eines Pakets vor:
1. **Working Directory (Arbeitsverzeichnis):** Deine Dateien auf der Festplatte, die du gerade bearbeitest.
2. **Staging Area (`git add`):** Du legst die geänderten Dateien in den offenen Versandkarton.
3. **Local Repository (`git commit`):** Du klebst den Karton zu und schreibst ein Etikett darauf (die Commit-Nachricht). Das Paket liegt noch bei dir zuhause.
4. **Remote Repository (`git push` / `git pull`):** Mit `git push` schickst du das Paket zu GitHub. Mit `git pull` holt der Raspberry Pi das Paket von GitHub ab.

---

### 3.2 Die 7 wichtigsten Git-Befehle verständlich erklärt

| Befehl | Bedeutung auf Deutsch | Wann benutzt du ihn? |
| :--- | :--- | :--- |
| **`git status`** | *„Was ist gerade los?“* | Zeigt dir an, welche Dateien geändert (`modified`), neu (`untracked`) oder schon für den Commit vorgemerkt sind. **Kannst du jederzeit gefahrlos eingeben!** |
| **`git add -A`** | *„Packe alle Änderungen in den Karton“* | Nimmt **alle** geänderten, neuen und gelöschten Dateien in die Vormerkliste (Staging Area) auf. *(Vergisst man `git add -A`, sagt Git beim Commit: `no changes added to commit`!)* |
| **`git commit -m "Text"`** | *„Karton zukleben & beschriften“* | Speichert den aktuellen Stand lokal als festen Meilenstein mit einer kurzen Beschreibung in Anführungszeichen. |
| **`git push origin main`** | *„Hochladen zu GitHub“* | Sendet deine gespeicherten Commits von deinem Windows-PC hinauf zu GitHub (`origin` = GitHub, `main` = Hauptzweig). |
| **`git pull origin main`** | *„Herunterladen von GitHub“* | Lädt auf dem Raspberry Pi die neuesten Commits von GitHub herunter und aktualisiert die Dateien. |
| **`git log -n 5 --oneline`** | *„Zeige die letzten 5 Updates“* | Zeigt dir die letzten 5 Commits mit ihrer kurzen ID (z. B. `60e445f`) und Beschreibung an. |
| **`git diff`** | *„Was genau wurde im Code geändert?“* | Zeigt Zeile für Zeile mit `+` (grün) und `-` (rot), was seit dem letzten Commit verändert wurde. (Beenden mit der Taste `q`). |

---

### 3.3 Dein Standard-Ablauf bei jeder Änderung (Der Goldene Workflow)

#### Schritt A – Auf deinem Windows-PC (im Laragon-Terminal `C:\laragon\www\ChatConnect`):
```powershell
# Optional, falls JavaScript oder CSS geändert wurde:
npm run build

# 1. Status prüfen (optional zur Kontrolle)
git status

# 2. ALLE Änderungen und neuen Dateien vormerken
git add -A

# 3. Änderung mit Beschreibung festschreiben
git commit -m "Kurze Beschreibung der Aenderung"

# 4. Zu GitHub hochladen
git push origin main
```

#### Schritt B – Auf deinem Raspberry Pi (`pi@pironman:/var/www/chatconnect`):
```bash
# 1. Ins Projektverzeichnis wechseln
cd /var/www/chatconnect

# 2. Neuesten Code von GitHub abholen
git pull origin main

# 3. Falls neue Datenbank-Tabellen/Spalten dabei waren
php artisan migrate --force

# 4. Laravel-Cache leeren, damit neue Ansichten/Routen sofort aktiv sind
php artisan optimize:clear
```

---

### 3.4 Typische Git-Fehlermeldungen & wie du sie sofort löst

#### ❌ Fehler 1: `no changes added to commit (use "git add" and/or "git commit -a")`
- **Ursache:** Du hast `git commit -m "..."` eingegeben, ohne vorher `git add -A` auszuführen. Der „Versandkarton“ war noch leer.
- **Lösung:**
  ```bash
  git add -A
  git commit -m "Deine Nachricht"
  git push origin main
  ```

#### ❌ Fehler 2 (auf dem Raspberry Pi): `Fehler: Unzureichende Berechtigung zum Hinzufügen eines Objektes zur Repository-Datenbank .git/objects`
- **Ursache:** Irgendwann wurde ein Befehl mit `sudo` ausgeführt, wodurch einzelne Dateien im versteckten Ordner `.git` dem Benutzer `root` statt `pi` gehören.
- **Lösung auf dem Pi:**
  ```bash
  sudo chown -R pi:www-data /var/www/chatconnect
  git pull origin main
  ```

#### ❌ Fehler 3 (auf dem Raspberry Pi): `error: Your local changes to the following files would be overwritten by merge`
- **Ursache:** Auf dem Raspberry Pi wurde eine Code-Datei direkt verändert, die nun mit dem neuen Stand von GitHub kollidiert.
- **Lösung auf dem Pi (setzt den Programmcode exakt auf den GitHub-Stand; Datenbank & `.env` bleiben unangetastet!):**
  ```bash
  git fetch origin
  git reset --hard origin/main
  sudo chmod -R 775 /var/www/chatconnect/storage /var/www/chatconnect/bootstrap/cache
  php artisan optimize:clear
  ```

---

## 4. ⚡ Ausführliche `php artisan` Schulung: Dein Schweizer Taschenmesser für Laravel

### 4.1 Was ist `php artisan`?
`artisan` ist das Kommandozeilen-Werkzeug von Laravel (eine Datei namens `artisan` direkt im Hauptordner von ChatConnect). Damit steuerst du alles: Benutzer anlegen, Caches leeren, Datenbank-Tabellen aktualisieren oder Wartungsarbeiten durchführen.

> **Tipp:** Mit `php artisan list` siehst du alle verfügbaren Befehle. Mit `php artisan help <befehl>` (z. B. `php artisan help user:manage`) bekommst du eine genaue Erklärung zu jedem Befehl.

---

### 4.2 👥 Benutzerverwaltung über `php artisan` (`user:manage`, `user:create`, `user:update`)

Wir haben für ChatConnect ein eigenes Verwaltungs-Werkzeug eingebaut, mit dem du Benutzer sowohl auf deinem PC als auch per SSH auf dem Raspberry Pi verwalten kannst:

#### 1. Alle registrierten Benutzer als Tabelle anzeigen
```bash
php artisan user:manage --list
```
*Zeigt ID, Name, E-Mail, Telefonnummer, Online-Status und Erstelldatum aller Benutzer.*

#### 2. Interaktiver Menü-Modus (empfohlen, führt dich Schritt für Schritt)
```bash
php artisan user:manage
```
*Zeigt zuerst die Benutzertabelle und fragt dich dann im Dialog, ob du einen neuen Benutzer anlegen (`create`) oder einen bestehenden bearbeiten (`update`) möchtest.*

#### 3. Neuen Benutzer direkt per Einzeiler anlegen
```bash
php artisan user:create anna@beispiel.ch --name="Anna Muster" --phone="+41791234567" --password="GeheimesPasswort" --about="Hallo, ich nutze ChatConnect!"
```
*Erstellt den Benutzer sofort inkl. verifizierter E-Mail und richtet automatisch auch den persönlichen KI-Beifahrer-Chat für diesen Benutzer ein.*

#### 4. Bestehenden Benutzer aktualisieren (Passwort zurücksetzen, Nummer oder Namen ändern)
**Suche über E-Mail-Adresse:**
```bash
php artisan user:update anna@beispiel.ch --password="NeuesPasswort2026" --phone="+41799998877"
```
**Oder gezielt über die Benutzer-ID (`--id`):**
```bash
php artisan user:update --id=3 --name="Leon Hofer" --password="LeonsPasswort"
```

---

### 4.3 🧹 Cache- & Performance-Befehle (Warum und wann?)

Laravel merkt sich übersetzte HTML-Ansichten (Blade-Views), Routen (`web.php` / `api.php`) und Einstellungen (`.env`) im Zwischenspeicher, damit ChatConnect extrem schnell lädt. Nach einem Update musst du diesen Zwischenspeicher leeren:

| Befehl | Was macht er? | Wann brauchst du ihn? |
| :--- | :--- | :--- |
| **`php artisan optimize:clear`** | **Der Alles-Reiniger!** Löscht gleichzeitig View-, Route-, Config- und App-Cache. | **Nach jedem `git pull`** auf dem Raspberry Pi oder nach Änderungen an der `.env`-Datei. |
| **`php artisan view:clear`** | Löscht nur die zwischengespeicherten `.blade.php`-Ansichten. | Wenn du eine Änderung an einer HTML/Blade-Datei hochgeladen hast. |
| **`php artisan route:clear`** | Löscht den Routen-Cache (`routes/web.php` & `routes/api.php`). | Wenn eine neue URL/Route hinzugefügt wurde. |
| **`php artisan config:clear`** | Liest die `.env`-Datei und `config/*.php` frisch ein. | Immer wenn du in der `.env` etwas geändert hast (z. B. DB-Passwort oder App-URL). |

---

### 4.4 🗄️ Datenbank- & Migrations-Befehle

In Laravel werden Datenbank-Tabellen über sogenannte **Migrationen** (`database/migrations/*.php`) verwaltet:

| Befehl | Was macht er? | Wichtig zu wissen |
| :--- | :--- | :--- |
| **`php artisan migrate:status`** | Zeigt an, welche Datenbank-Migrationen schon ausgeführt wurden (`Ran`) und welche noch offen sind (`Pending`). | Völlig gefahrlos zum Prüfen. |
| **`php artisan migrate --force`** | Führt alle **neuen** Migrationen aus (legt neue Tabellen oder Spalten an). | **Löscht keine Daten!** Das `--force` bestätigt auf dem Produktionsserver die Sicherheitsabfrage. |
| **`php artisan tinker`** | Öffnet eine interaktive PHP-Konsole direkt in deiner Live-App. | Beispiel in Tinker: `User::count()` zeigt die Anzahl der Benutzer; mit `exit` verlässt du Tinker wieder. |

---

### 4.5 🛠️ Spezielle ChatConnect- & Wartungs-Befehle

| Befehl | Beschreibung |
| :--- | :--- |
| **`php artisan stories:cleanup`** | Löscht sofort alle abgelaufenen Storys (älter als 24 Stunden) samt ihren Bilddateien vom Server. |
| **`php artisan storage:link`** | Erstellt die Verknüpfung von `public/storage` nach `storage/app/public`, damit hochgeladene Bilder, Sprachnachrichten und `.stl`-Dateien im Browser geladen werden können. |
| **`php artisan down`** | Schaltet ChatConnect kurzzeitig in den Wartungsmodus („Gleich wieder da“). |
| **`php artisan up`** | Beendet den Wartungsmodus und schaltet ChatConnect wieder frei. |
| **`php artisan reverb:start`** | Startet den Echtzeit-WebSocket-Server (falls Reverb genutzt wird). |

---

## 5. 💾 Datenbank-Backup, Synchronisation & Notfall-Wiederherstellung

### 5.1 Datenbank auf dem Raspberry Pi sichern (Backup erstellen)
Vor größeren Server-Arbeiten kannst du auf dem Raspberry Pi in 2 Sekunden ein komplettes Backup aller Benutzer, Chats und Nachrichten erstellen:
```bash
cd /var/www/chatconnect
mysqldump -u root -p chatconnect > backup_chatconnect_$(date +%F).sql
```
*(Erzeugt z. B. die Datei `backup_chatconnect_2026-11-07.sql`.)*

### 5.2 Datenbank-Backup wieder einspielen (Restore)
```bash
mysql -u root -p chatconnect < backup_chatconnect_2026-11-07.sql
```

### 5.3 Hochgeladene Medien sichern (`storage/app/public`)
Alle verschickten Fotos, Sprachnachrichten, Dokumente und 3D-Modelle liegen im Ordner `storage/app/public`. So packst du sie in ein Backup-Archiv:
```bash
tar -czf backup_medien_$(date +%F).tar.gz -C /var/www/chatconnect/storage/app public
```

---

## 6. 📋 Täglicher Admin-Spickzettel (Cheat Sheet zum Ausdrucken)

### 🔹 1. Neues Update von Laragon (Windows) auf den Raspberry Pi bringen
**Auf Windows (Laragon Terminal):**
```powershell
npm run build
git add -A
git commit -m "Update ChatConnect"
git push origin main
```

**Auf dem Raspberry Pi (per SSH):**
```bash
cd /var/www/chatconnect
git pull origin main
php artisan migrate --force
php artisan optimize:clear
```

### 🔹 2. Neuen Familien-Benutzer auf dem Raspberry Pi anlegen oder Passwort ändern
```bash
cd /var/www/chatconnect
php artisan user:manage
```

### 🔹 3. Falls auf dem Raspberry Pi ein Berechtigungsfehler (`Permission denied`) auftritt
```bash
sudo chown -R pi:www-data /var/www/chatconnect
sudo chmod -R 775 /var/www/chatconnect/storage /var/www/chatconnect/bootstrap/cache
```

### 🔹 4. Live-Fehlerprotokoll (Logbuch) auf dem Raspberry Pi ansehen
Falls einmal etwas nicht klappt, siehst du hier sofort die genaue Ursache:
```bash
tail -n 50 /var/www/chatconnect/storage/logs/laravel.log
```
*(Oder live mitlesen mit `tail -f /var/www/chatconnect/storage/logs/laravel.log` – beenden mit `Strg + C`.)*

