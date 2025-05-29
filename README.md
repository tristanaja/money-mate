# MoneyMate

**MoneyMate** is a PHP web application for user authentication and personal expense tracking. Built with modularity and security in mind, it uses environment variables for configuration and follows best practices for password management.

---

## ✨ Features

- User Registration & Login
- Secure Password Hashing (`password_hash`)
- Session-Based Authentication
- Error Handling with User Feedback
- Modular, Maintainable Codebase
- Responsive UI with Tailwind CSS
- Expense Management (Add/Edit/Delete)
- Budget Planning & Saving Goals

---

## 📁 Project Structure

```
.
├── .config/           # Configuration (uses .env for secrets)
├── assets/            # Static assets (images, icons, etc.)
├── auth/              # Authentication logic (Auth_Services, etc.)
├── includes/          # Shared PHP includes (headers, footers)
├── pages/
│   └── auth_pages/    # Sign in, sign up, etc.
├── processes/         # Backend logic for authentication actions
├── index.php          # Protected landing page (requires login)
└── .gitignore         # Files/directories to exclude from git
```

> **Note:** The initial page when accessing the application is `index.php`, which is the authenticated landing page.

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/moneymate.git
cd moneymate
```

### 2. Install Dependencies

This project uses [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) for environment variables. Install dependencies with Composer:

```bash
composer install
```

### 3. Configure Environment Variables

Copy the example environment file and edit it:

```bash
cp .env.example .env
```

Edit `.env` to set your database credentials:

```
DB_HOST=localhost
DB_NAME=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

> **Note:** Never commit your `.env` file. It is already in `.gitignore`.

### 4. Create the Database Schema

Ensure your MySQL database includes the following tables:

```sql
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE expenses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    description VARCHAR(255),
    amount DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);

CREATE TABLE budgets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    amount DECIMAL(12, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE saving_goals (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    amount DECIMAL(12, 2) NOT NULL,
    target_month TINYINT UNSIGNED NOT NULL,
    target_year SMALLINT UNSIGNED NOT NULL,
    status ENUM('ACHIEVED', 'NOT ACHIEVED', 'BONUS', 'ON PROGRESS') DEFAULT 'NOT ACHIEVED',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 5. Start the PHP Development Server

```bash
php -S localhost:8000
```

---

## 🌐 Access the App

Visit [http://localhost:8000/path-to-index.php](http://localhost:8000/path-to-index.php) to log in or register.

---

## ⚠️ Important Notes

- **Never commit sensitive credentials** (like `.env`) to version control.
- For production:

  - Use environment variables for all secrets.
  - Enable HTTPS.
  - Harden PHP and web server settings.

---

## 📜 License

This project is intended for **educational purposes only**. Feel free to modify and expand it for your own learning.

---

## 🙌 Contributing

Contributions are welcome! To suggest improvements or fix bugs:

1. Create a new branch from `main`.
2. Implement your changes.
3. Open a **Pull Request** (PR).
4. Ensure all automated checks pass before requesting a review.
5. Your PR must be reviewed and approved by **@tristanaja**.

> **Note:** Direct pushes to `main` are disabled. Always use branches and PRs.

---

## 📧 Contact

Created by \[Tristan] — for questions, reach out at [tristan.alhabas@gmail.com](mailto:tristan.alhabas@gmail.com).
