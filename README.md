# MoneyMate

MoneyMate is a PHP-based web application for managing user authentication and expenses.

## Features

- User registration and login
- Secure password hashing
- Session-based authentication
- Error handling with user-friendly messages
- Responsive UI with Tailwind CSS

## Project Structure

```
.
├── .config/           # Configuration and session management
├── assets/            # Static assets (images, etc.)
├── auth/              # Authentication service logic
├── includes/          # Shared PHP includes
├── pages/             # Frontend pages (sign in, sign up, etc.)
├── processes/         # Backend processes (sign in, sign up, logout)
├── index.php          # Main landing page (requires authentication)
└── .gitignore         # Git ignore rules
```

## Setup

1. **Clone the repository**
2. **Configure the database**  
   Edit `.config/config.php` with your MySQL credentials and database name.
3. **Create the database schema**  
   Ensure you have a `users` table with at least the following columns:
   - `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
   - `username` (VARCHAR)
   - `email` (VARCHAR, UNIQUE)
   - `password_hash` (VARCHAR)
4. **Start a local PHP server**  
   ```sh
   php -S localhost:8000
   ```
5. **Visit the app**  
   Open [http://localhost:8000/pages/auth_pages/sign_in.php](http://localhost:8000/pages/auth_pages/sign_in.php) in your browser.

## Notes

- Do **not** commit sensitive information (like database passwords) to version control.
- For production, use environment variables for configuration and enable HTTPS.

## License

This project is for educational purposes.