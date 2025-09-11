# Aufgaben Planer V0.4 (Advanced Task Manager)

A modern, feature-rich task management web application built with **PHP**, **MySQL**, **jQuery**, and **CSS**. Features comprehensive user management, task archiving, profile tracking, and an intuitive responsive interface.

![Task Manager](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

---

## New Features in V0.4

### Enhanced User Profiles
- **Profile Dashboard** with user photo and member information
- **Member Since** tracking - shows registration date
- **Last Login** tracking - automatically updates on logout
- **Professional Profile UI** with avatar display

### Advanced Archive System
- **Soft Delete** - deleted tasks move to archive instead of permanent deletion
- **Task Recovery** - restore tasks from archive back to active list
- **Permanent Delete** - option to permanently remove archived tasks
- **Archive View** - dedicated interface to manage deleted tasks

### Modern Interface
- **Top Navigation Banner** with profile info and quick actions
- **Toggle Views** - switch between tasks and archive with smooth transitions
- **Improved Responsive Design** - better mobile and desktop experience
- **Enhanced Button Styling** - multiple button types for different actions

---

## Core Features

### Complete Authentication System
- **User Registration** with username, email, and secure password hashing
- **Login System** with session management and error handling
- **Password Recovery** option (resetpw.php - not included in current files)
- **Secure Logout** with last login timestamp update

### Advanced Task Management
- **Create Tasks** with description, category, and priority levels
- **Mark Complete** - toggle task completion status
- **Soft Delete** - move tasks to archive for later recovery
- **Smart Filtering** by status, category, or priority
- **Task Statistics** and user activity tracking

### Organization & Filtering
- **Categories**: Arbeit (Work), Privat (Personal), Schule (School)
- **Priority Levels**: Hoch (High), Mittel (Medium), Niedrig (Low)
- **Status Filtering**: All, Open, Completed tasks
- **Archive Management**: View and manage deleted tasks

---

## File Structure

```
aufgaben-planer-v04/
├── index.php          # Main dashboard with tasks and archive
├── login.php          # User authentication
├── signup.php         # User registration
├── resetpw.php        # Password recovery (referenced)
├── styles.css         # Complete responsive styling
├── img/
│   └── ap_profile.png  # Default profile picture
├── config.php         # Database configuration (create separately)
└── README.md          # This documentation
```
## Usage Guide

### Getting Started
1. **Register** at `/signup.php` with username and email
2. **Login** at `/login.php` with your credentials
3. **Dashboard** loads with your profile info and empty task list

### Managing Tasks
- **Add Tasks**: Use the form to create tasks with category and priority
- **Complete Tasks**: Click "Erledigt" to mark tasks as done
- **Delete Tasks**: Click "Löschen" to move tasks to archive

### Using the Archive
- **View Archive**: Click "Archiv" button in top navigation
- **Restore Tasks**: Click "Restore" to move tasks back to active list
- **Permanent Delete**: Click "Löschen" in archive for permanent removal

### Profile Features
- **Member Info**: View registration date and last login
- **Profile Picture**: Default avatar with future customization options
- **Activity Tracking**: System tracks your login patterns

---

## Design Highlights

- **Glass-morphism UI** with backdrop blur effects
- **Dual-view System** - toggle between tasks and archive
- **Professional Profile Banner** with user information
- **Responsive Button Design** - different styles for different actions
- **Smooth Transitions** using jQuery animations
- **Mobile-optimized** layout with viewport meta tags

---

## Security Features

- **Password Hashing** with PHP's `password_hash()` function
- **SQL Injection Protection** using prepared statements
- **XSS Prevention** with `htmlspecialchars()` on all outputs
- **Session Security** with proper session management
- **Input Validation** on both frontend and backend

---

## Technical Details

### JavaScript Features
- **jQuery Integration** for smooth UI interactions
- **View Toggling** between main tasks and archive
- **Responsive Design** with mobile-first approach

### PHP Features
- **Object-Oriented Database** interactions with MySQLi
- **Session Management** for user authentication
- **Data Sanitization** for security
- **Prepared Statements** for database queries

### CSS Features
- **CSS Grid & Flexbox** for responsive layouts
- **CSS Variables** for consistent theming
- **Advanced Animations** with transforms and transitions
- **Mobile Responsive** design patterns

---

## Known Issues & Future Features

### Current Limitations
- Profile picture upload not yet implemented
- Password reset functionality referenced but not included
- Settings and About pages planned but not implemented

### Planned Features
- Custom profile picture uploads
- Email notifications
- Task due dates and reminders
- Export functionality
- Dark mode theme

---

## Browser Support

- **Chrome** 80+ (recommended)
- **Firefox** 75+
- **Safari** 13+
- **Edge** 80+
- **Internet Explorer** not supported

---

## License

This project is open source and available under the [MIT License](LICENSE).

---

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/NewFeature`)
3. Commit changes (`git commit -m 'Add NewFeature'`)
4. Push to branch (`git push origin feature/NewFeature`)
5. Open a Pull Request

---

## 📞 Support & Contact

- 🐛 **Bug Reports**: Open an issue on GitHub
- 💡 **Feature Requests**: Create a feature request issue
- 📧 **General Questions**: Contact via GitHub discussions

---

**Version**: 0.4  
**Last Updated**: September 2025  
**Status**: Active Development
