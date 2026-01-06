# Work OS - Personal Management Dashboard

Work OS is a comprehensive Laravel-based application designed to manage personal and professional workflows. It includes robust modules for security credentials, infrastructure monitoring, and daily productivity tools, all wrapped in a premium Metronic-style interface.

## 🚀 Features

### 🔐 Security Layer

-   **Credentials Manager**: Securely store logins and secrets. Passwords and notes are automatically encrypted in the database using Laravel's encryption.
-   **Activity Logs**: Track important user actions and system events for audit purposes.

### 🌐 Infrastructure Layer

-   **Server Management**: Keep track of your VPS/Dedicated servers (IP, Port, OS, Status). Securely store SSH private keys.
-   **Domain Monitoring**: Monitor SSL expiry and domain status (Healthy/Down/Warning).
-   **Backups**: Log and track server backup records (File name, Size, Status).

### ⚡ Productivity Layer (Daily Tools)

-   **Tasks (Kanban)**: Manage daily tasks with priorities (Low/Medium/High) and status (Todo/In Progress/Review/Done).
-   **Code Snippets**: Store useful code blocks (PHP, JS, Bash, etc.) with syntax highlighting and tagging.
-   **Subscriptions**: Track recurring expenses (SaaS, Server bills) with billing cycles and due dates.

## 🛠️ Installation

Follow these steps to set up the project locally:

### 1. Clone the Repository

```bash
git clone https://github.com/AbdoelMadjid/work-os.git
cd work-os
```

### 2. Install Dependencies

**PHP Dependencies:**

```bash
composer install
```

**Node.js Dependencies:**

```bash
npm install
```

### 3. Environment Setup

Copy the example environment file and configure your database credentials:

```bash
cp .env.example .env
```

Open `.env` and set your database connection details (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Run Migrations

Create the necessary database tables:

```bash
php artisan migrate
```

### 6. Build Assets

Compile the frontend assets using Vite:

```bash
npm run build
```

### 7. Run the Application

Start the local development server:

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 📖 Application Workflow

### Authentication

-   Register a new account or login with existing credentials.
-   The dashboard is protected and requires authentication.

### Managing Credentials

1. Navigate to **Security > Credentials**.
2. Click **Add New** to store a new login.
3. Use the **Copy** button to quickly copy passwords to your clipboard.

### Monitoring Infrastructure

1. **Servers**: Add your server details in **Infrastructure > Servers**. Store SSH keys securely.
2. **Monitors**: Add domains to monitor in **Infrastructure > Domain Monitors**.
3. **Backups**: Log manual or automated backup results in **Infrastructure > Backups**.

### Daily Productivity

1. **Tasks**: Use the **Productivity > Tasks** section to manage your daily to-do list.
2. **Snippets**: Save reusable code in **Productivity > Snippets**.
3. **Subscriptions**: Keep track of your monthly/yearly bills in **Productivity > Subscriptions**.

## 💻 Tech Stack

-   **Framework**: Laravel 12
-   **UI Theme**: Metronic (Custom Blade Components)
-   **Frontend**: Blade, Alpine.js (Lightweight), Bootstrap (via Metronic)
-   **Database**: MySQL/MariaDB

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
