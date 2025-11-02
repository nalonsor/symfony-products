# Symfony Products Application

This is a simple application to manage products, built with the Symfony framework.

## Prerequisites

Before you begin, ensure you have the following installed:

*   [PHP](https://www.php.net/downloads.php) (version 8.1 or higher)
*   [Composer](https://getcomposer.org/)
*   [Symfony CLI](https://symfony.com/download) (recommended)
*   [MySQL](https://www.mysql.com/downloads/) (or MariaDB)

## Getting Started

Follow these steps to get your development environment set up and running.

### 1. Clone the Repository

First, clone the repository to your local machine:

```bash
git clone https://github.com/nalonsor/symfony-products.git
cd symfony-products
```

### 2. Install Dependencies

Install the required PHP packages using Composer:

```bash
composer install
```

### 3. Configure the Environment

The application uses a `.env` file for environment configuration. You'll need to set up your database connection.

1.  Create a local environment file by copying the example:
    ```bash
    copy .env .env.local
    ```

2.  Open `.env.local` and update the `DATABASE_URL` variable with your database credentials. For example:
    ```
    # .env.local
    DATABASE_URL="mysql://admin:secret@127.0.0.1:3306/products?serverVersion=8.4.3&charset=utf8mb4"
    ```
    Make sure the user, password, and database name (`products`) are correct for your local setup.

### 4. Set Up the Database

Once your environment is configured, create the database and run the migrations to set up the necessary tables.

1.  **Create the database:**
    ```bash
    php bin/console doctrine:database:create
    ```

2.  **Run database migrations:**
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

### 5. Run the Application

You can run the application using the built-in Symfony web server, which is the recommended method for development.

```bash
symfony server:start
```

The application will be available at the URL provided by the command, usually `https://127.0.0.1:8000`.

Alternatively, you can use PHP's built-in web server (not recommended for Symfony applications):
```bash
php -S localhost:8000 -t public
```

---
*This README was generated based on the project structure.*
