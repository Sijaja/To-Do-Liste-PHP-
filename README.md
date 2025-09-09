# Aufgaben Planer V0.3 (Task Manager)

A modern, responsive task management web application built with **PHP**, **MySQL**, and **CSS**. Features user authentication, task categorization, priority levels, and filtering capabilities.

![Task Manager](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

---

## Features

### User Authentication
- **User Registration** with username, email, and secure password hashing
- **Login System** with session management
- **Secure Logout** functionality
- Input validation and error handling

### Task Management
- **Add Tasks** with description, category, and priority
- **Mark as Complete** - toggle task completion status
- **Delete Tasks** permanently
- **Task Filtering** by status, category, or priority
- **Responsive Design** that works on all devices

### Organization
- **Categories**: Arbeit (Work), Privat (Personal), Schule (School)
- **Priority Levels**: Hoch (High), Mittel (Medium), Niedrig (Low)
- **Status Tracking**: Open vs. Completed tasks
- **Advanced Filtering**: View tasks by any combination of attributes

---

## File Structure

```
task-manager/
├── index.php          # Main dashboard (requires authentication)
├── login.php          # User login page
├── signup.php         # User registration page
├── styles.css         # Complete styling and responsive design
├── config.php         # Database configuration (only an example is included)
└── README.md          # This file
```

---

## Installation

### Prerequisites
- **Web Server** (Apache/Nginx)
- **PHP 7.4+** with MySQLi extension
- **MySQL 5.7+** or **MariaDB**

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/task-manager.git
   cd task-manager
   ```

2. **Create the database**
   ```sql
   CREATE DATABASE task_manager;
   USE task_manager;

   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_name VARCHAR(50) UNIQUE NOT NULL,
       email VARCHAR(100),
       password_hash VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE tasks (
       id INT AUTO_INCREMENT PRIMARY KEY,
       text TEXT NOT NULL,
       category ENUM('Arbeit', 'Privat', 'Schule') NOT NULL,
       priority ENUM('hoch', 'mittel', 'niedrig') NOT NULL,
       done TINYINT(1) DEFAULT 0,
       user_id INT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
   );
   ```

3. **Create config.php**
   ```php
   <?php
   $servername = "localhost";
   $username = "your_db_username";
   $password = "your_db_password";
   $dbname = "task_manager";

   $conn = new mysqli($servername, $username, $password, $dbname);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

4. **Upload files** to your web server
5. **Set proper permissions** for PHP files
6. **Access** your application at `https://yourdomain.com/login.php`

---

## Design Features

- **Modern Glass-morphism UI** with backdrop blur effects
- **Responsive Grid Layout** that adapts to all screen sizes
- **Custom Background** with repeating pattern
- **Smooth Animations** and hover effects
- **Color-coded Priority System**
- **Clean Typography** with Segoe UI font family

---

## Security Features

- **Password Hashing** using PHP's `password_hash()` function
- **SQL Injection Protection** with prepared statements
- **XSS Prevention** with `htmlspecialchars()`
- **Session Management** for user authentication
- **Input Validation** on both client and server side

---

## Usage

1. **Register** a new account at `/signup.php`
2. **Login** with your credentials at `/login.php`
3. **Add tasks** using the form on the main dashboard
4. **Filter tasks** by category, priority, or completion status
5. **Mark tasks complete** or **delete** them as needed
6. **Logout** securely when finished

---

## Customization

### Adding New Categories
Edit the `<select>` options in `index.php` and update the database enum:
```sql
ALTER TABLE tasks MODIFY COLUMN category ENUM('Arbeit', 'Privat', 'Schule', 'YourNewCategory');
```

### Changing Colors
Modify the CSS variables in `styles.css`:
```css
:root {
    --primary-color: rgb(81, 126, 126);
    --accent-color: rgb(29, 124, 124);
}
```

---

## Known Issues

- Email field is optional but included in signup form
- German language interface (easily translatable)
- Requires manual database setup

---

## License

This project is open source and available under the [MIT License](LICENSE).

---

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## Support

If you encounter any issues or have questions, please open an issue on GitHub.

---

**Version**: 0.3  
**Last Updated**: September 2025