# MoneyMate

**MoneyMate** is a simple yet powerful PHP-based web application for managing user authentication and tracking personal expenses.

---

## 🚀 Features

- ✅ User Registration and Login
- 🔐 Secure Password Hashing using `password_hash()`
- 🔒 Session-Based Authentication
- ⚠️ Error Handling with Friendly Feedback Messages
- 📱 Responsive User Interface styled with Tailwind CSS
- 🧩 Modular Project Structure for Maintainability

---

## 📁 Project Structure

```
.
├── .config/           # Configuration files and session management
├── assets/            # Static assets (images, icons, etc.)
├── auth/              # Core authentication logic (e.g., login, registration)
├── includes/          # Shared PHP includes (e.g., headers, footers)
├── pages/
│   └── auth_pages/    # Frontend pages for login, registration
├── processes/         # Backend logic for sign in, sign up, logout
├── index.php          # Protected landing page (only accessible after login)
└── .gitignore         # Files/directories to exclude from version control
```

---

## 🛠️ Setup Instructions

Follow these steps to get MoneyMate running on your local machine:

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/moneymate.git
cd moneymate
```

### 2. Configure the Database

Open `.config/config.php` and add your MySQL database credentials:

```php
$db_host = 'localhost';
$db_name = 'your_database_name';
$db_user = 'your_username';
$db_pass = 'your_password';
```

### 3. Create the Database Schema

Ensure your MySQL database includes the following `users` table:

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);
```

### 4. Start the PHP Development Server

Depending on your development environment, you can start the server in several ways:

#### 🔹 Using PHP's Built-in Server (Universal)

```bash
php -S localhost:8000
```

#### 🔹 Using XAMPP (Windows/macOS/Linux)

1. Place the project in the `htdocs` directory.
2. Start Apache from the XAMPP control panel.
3. Open your browser and go to:

```
http://localhost/moneymate/index.php
```

#### 🔹 Using Homebrew on macOS

1. Install PHP if it's not already:

```bash
brew install php
```

2. Navigate to your project folder:

```bash
cd moneymate
php -S localhost:8000
```

---

## 🌐 Access the App

Once your server is running, navigate to:

[http://localhost:8000/index.php](http://localhost:8000/index.php)

---

## ⚠️ Important Notes

- **Never commit sensitive credentials** such as database passwords to version control.
- For production environments:

  - Use environment variables for sensitive configuration.
  - Enable HTTPS for secure data transmission.
  - Harden your PHP and web server settings for improved security.

- **Direct pushes to the `main` branch are prohibited.** All changes must go through a **Pull Request (PR)** and pass the required checks before being merged into `main`. All PRs must be approved by the repository owner, **@tristanaja**, before being merged.

---

## 📜 License

This project is intended for **educational purposes only**. Feel free to modify and expand it for your own learning.

---

## 🙌 Contributing

Contributions are welcome! If you'd like to suggest improvements or fix bugs:

1. Create a new branch from `main`.
2. Implement your changes.
3. Open a **Pull Request** (PR).
4. Ensure all automated checks pass before requesting a review.
5. Your PR must be reviewed and approved by **@tristanaja**.

> **Note:** Direct pushes to `main` are disabled to ensure code quality and team collaboration. Always use branches and PRs.

---

## 📧 Contact

Created by \[Tristan] — for any questions, reach out at [tristan.alhabas@gmail.com](mailto:tristan.alhabas@gmail.com).
