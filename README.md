# Workopia - Job Listing Application

Workopia is a simple, vanilla PHP application for listing and managing job opportunities. It follows a basic MVC (Model-View-Controller) pattern and provides a foundation for building a more complex job board.

## Features

*   **User Authentication:** Users can register and log in to post and manage job listings.
*   **Job Listings:** Authenticated users can create, edit, and delete job listings.
*   **Search:** Users can search for job listings.
*   **Clean URL Structure:** The application uses a simple router for clean, user-friendly URLs.

## Project Structure

```
/
├── App/
│   ├── controllers/      # Handles application logic
│   ├── views/            # Contains the presentation files
├── config/
│   └── db.php.example    # Example database configuration
├── Framework/
│   ├── middleware/       # Contains application middleware
│   ├── Authorization.php # Handles authorization logic
│   ├── Database.php      # Handles database connection and queries
│   ├── Router.php        # Handles routing
│   ├── Session.php       # Handles session management
│   └── Validation.php    # Handles data validation
├── public/
│   ├── css/              # CSS files
│   ├── images/           # Image files
│   └── index.php         # Entry point of the application
├── vendor/               # Composer dependencies
├── .gitignore
├── composer.json
├── composer.lock
├── helpers.php           # Helper functions
├── README.md
└── routes.php            # Application routes
```

## Getting Started

### Prerequisites

*   PHP 8.0 or higher
*   MySQL
*   Composer

### Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/workopia.git
    cd workopia
    ```

2.  **Install dependencies:**

    ```bash
    composer install
    ```

3.  **Create the database configuration file:**

    Rename the `config/db.php.example` file to `config/db.php` and update it with your database credentials.

    ```php
    <?php

    return [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'workopia',
        'username' => 'your_username',
        'password' => 'your_password'
    ];
    ```

4.  **Create the database:**

    Create a MySQL database named `workopia` (or the name you specified in `config/db.php`).

5.  **Create the `listings` table:**

    ```sql
    CREATE TABLE `listings` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `title` varchar(255) NOT NULL,
      `description` text NOT NULL,
      `salary` varchar(255) DEFAULT NULL,
      `requirements` text,
      `benefits` text,
      `company` varchar(255) DEFAULT NULL,
      `address` varchar(255) DEFAULT NULL,
      `city` varchar(255) DEFAULT NULL,
      `state` varchar(255) DEFAULT NULL,
      `phone` varchar(255) DEFAULT NULL,
      `email` varchar(255) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ```

6.  **Create the `users` table:**

    ```sql
    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `city` varchar(255) DEFAULT NULL,
      `state` varchar(255) DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ```

## Running the Application

You can run the application using the built-in PHP development server:

```bash
php -S localhost:8000 -t public
```

The application will be available at `http://localhost:8000`.