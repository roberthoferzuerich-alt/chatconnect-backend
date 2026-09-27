# 🌐 ChatConnect - Backend API (Laravel)

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-^8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Sanctum](https://img.shields.io/badge/Auth-Laravel_Sanctum-FF2D20?style=for-the-badge)](https://laravel.com/docs/sanctum)
[![Reverb](https://img.shields.io/badge/WebSockets-Laravel_Reverb-FF2D20?style=for-the-badge)](https://laravel.com/docs/reverb)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

**ChatConnect Backend** ist eine leistungsstarke, sichere REST-API und WebSocket-Backend-Anwendung für die **ChatConnect** Mobile App. Das Backend wurde mit **Laravel 13** auf **PHP 8.3** entwickelt und ist für die Ausführung auf einem eigenen **Raspberry Pi** oder Docker-Server optimiert.

---

## ⚡ Hauptfunktionen

- 🔑 **API-Authentifizierung & Profilverwaltung**:
  - Token-basierte Authentifizierung mit **Laravel Sanctum**.
  - Registrierung, Login, Profilabfragen & Avatar-Upload.

- 📡 **Echtzeit-WebSockets (Broadcasting)**:
  - Integration von **Laravel Reverb** für die sofortige Übertragung von Nachrichten, Gelesen-Status & Call-Signalen.

- 💬 **Konversations- & Nachrichten-Management**:
  - Erstellen von 1-zu-1 Dialogen & Gruppenchats.
  - Senden & Empfangen von Text- und Medien-Nachrichten.
  - Gelesen-Status (Read Receipts) & globale Entwurf-Verwaltung.
  - **Nachrichten löschen**: Inklusive serverseitiger Autorisierungsprüfung und automatischer physischer Dateibereinigung bei Medien-Nachrichten.

- 📸 **Story- & Status-System (mit 24h-Automatisierung)**:
  - Upload und Bereitstellung von temporären Storys.
  - Tracking von Story-Views.
  - **Automatischer Speicher-Cleanup**: Abgelaufene Story-Bilder werden nach 24 Stunden per Artisan Scheduled Task (`php artisan stories:cleanup`) automatisch von der Festplatte gelöscht.

- 🍓 **Raspberry Pi Live-Deployment**:
  - Schritt-für-Schritt Workflow für Nginx, PHP-FPM, Supervisor & Cronjob auf dem Raspberry Pi.

---

## 🛠️ Tech Stack & Anforderungen

- **PHP**: `>= 8.3`
- **Framework**: Laravel `13.x`
- **Auth**: Laravel Sanctum
- **WebSockets / Events**: Laravel Reverb
- **Datenbank**: MySQL / MariaDB / SQLite
- **Server**: Nginx / Apache, Supervisor, Cron
- **Containerization**: Docker & Docker Compose

---

## 📡 API-Endpunkte Übereinstimmung

Alle Routen sind unter dem Präfix `/api/v1` erreichbar:

### 🔑 Authentifizierung (`/api/v1/auth`)
| Methode | Endpunkt | Beschreibung | Auth |
| :--- | :--- | :--- | :---: |
| `POST` | `/api/v1/auth/register` | Neuen Benutzer registrieren | ❌ |
| `POST` | `/api/v1/auth/login` | Einloggen & Sanctum Token erhalten | ❌ |
| `GET` | `/api/v1/auth/me` | Profil des angemeldeten Benutzers abrufen | ✅ |
| `POST` | `/api/v1/auth/profile/avatar` | Profilbild hochladen | ✅ |
| `POST` | `/api/v1/auth/logout` | Sitzung beenden / Token ungültig machen | ✅ |

### 💬 Konversationen & Nachrichten (`/api/v1`)
| Methode | Endpunkt | Beschreibung | Auth |
| :--- | :--- | :--- | :---: |
| `GET` | `/api/v1/users` | Benutzerliste abrufen | ✅ |
| `GET` | `/api/v1/conversations` | Alle aktiven Konversationen des Nutzers | ✅ |
| `POST` | `/api/v1/conversations` | Neue 1-zu-1 Konversation starten | ✅ |
| `POST` | `/api/v1/conversations/group` | Neue Gruppe erstellen | ✅ |
| `GET` | `/api/v1/conversations/{id}/messages` | Nachrichten-Verlauf laden | ✅ |
| `POST` | `/api/v1/conversations/{id}/messages` | Neue Nachricht senden | ✅ |
| `POST` | `/api/v1/conversations/{id}/read` | Konversation als gelesen markieren | ✅ |
| `POST` | `/api/v1/messages/mark-all-read` | Alle ungelesenen Nachrichten als gelesen markieren | ✅ |
| `DELETE` | `/api/v1/conversations/{id}/messages/{msgId}` | Nachricht löschen (inkl. Mediendatei) | ✅ |

### 📸 Storys / Status (`/api/v1/stories`)
| Methode | Endpunkt | Beschreibung | Auth |
| :--- | :--- | :--- | :---: |
| `GET` | `/api/v1/stories` | Alle aktiven Storys (letzte 24h) abrufen | ✅ |
| `POST` | `/api/v1/stories` | Neue Story hochladen | ✅ |
| `DELETE` | `/api/v1/stories/{story}` | Eigene Story manuell löschen | ✅ |
| `POST` | `/api/v1/stories/{story}/view` | Story-Aufruf / View registrieren | ✅ |

---

## ⚙️ Lokale Installation & Entwicklung

1. **Repository klonen**:
   ```bash
   git clone https://github.com/roberthoferzuerich-alt/chatconnect-backend.git
   cd chatconnect-backend
   ```

2. **PHP-Abhängigkeiten installieren**:
   ```bash
   composer install
   ```

3. **Umgebungsvariablen konfigurieren**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Passe `.env` mit deinen Datenbank- und Reverb-Zugangsdaten an.*

4. **Datenbank-Migrationen ausführen**:
   ```bash
   php artisan migrate
   ```

5. **Entwicklungsserver & WebSockets starten**:
   ```bash
   # Server starten
   php artisan serve

   # Reverb WebSocket-Server starten
   php artisan reverb:start
   ```

---

## 🍓 Raspberry Pi Deployment & Update-Workflow

### 1. Code-Update vom GitHub Repository
Verbinde dich per SSH mit deinem Raspberry Pi und führe aus:
```bash
cd /var/www/chatconnect
sudo git pull origin main
php artisan migrate --force
php artisan optimize:clear
```

### 2. Automatischer Speicher-Cleanup (Cronjob)
Damit abgelaufene Story-Bilder automatisch gelöscht werden, stelle sicher, dass der Laravel-Cronjob auf dem Raspberry Pi aktiv ist:

1. Crontab-Editor öffnen:
   ```bash
   sudo crontab -e
   ```
2. Folgende Zeile einfügen:
   ```cron
   * * * * * cd /var/www/chatconnect && php artisan schedule:run >> /dev/null 2>&1
   ```
3. Speichern und schließen. Nun führt der Raspberry Pi stündlich `php artisan stories:cleanup` aus.

---

## 🐳 Docker Setup

Falls du das Backend in einer Docker-Umgebung betreiben möchtest:

```bash
# Docker Container im Hintergrund starten
docker-compose up -d --build
```

---

## 🔗 Flutter Frontend-Repository

Das passende Flutter Mobile Frontend findest du hier:  
👉 **[ChatConnect App Repository](https://github.com/roberthoferzuerich-alt/chatconnect-app.git)**

---

## 📄 Lizenz

Dieses Projekt steht unter der **MIT Lizenz**.
