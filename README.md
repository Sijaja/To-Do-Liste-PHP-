# Task Manager (PHP + Session Storage)

This is a simple **to-do list / task manager** built with **PHP**, **CSS**, and **HTML**.  
It stores tasks in the PHP session (so tasks are lost when the session ends).  
This version does **not** use a database, it's meant as a lightweight starting point.

---

## Features
- Add tasks with:
  - Title (task text)
  - Category
  - Priority (Low, Medium, High)
- Mark tasks as done
- Delete tasks
- Tasks are styled with a responsive layout and a clean design
- Background image + color for a modern look

---

## Files
- `index.php` main PHP file that renders the app and handles task actions
- `styles.css` styling for the page (layout, colors, background)
- `n487.png` AI-generated background image used in `styles.css`

---

## How to Run
1. Upload the files (`index.php`, `styles.css`, `n487.png`) to your web server.
2. Ensure `index.php` is in the root folder (`public_html/`) so it loads at `https://yourdomain.com/`.
3. The CSS and image should be in the same folder (unless you update the paths in `styles.css`).
4. Open the website in your browser and start adding tasks!

---

## Notes
- This version uses **PHP session storage** only so the tasks will disappear after session timeout or server reset.
- For a more permanent solution, check out the next version with **MySQL database support**.
