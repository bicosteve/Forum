# 🗣️ Forum

## 📖 Description

**Forum** is a lightweight community forum application where users can engage in meaningful discussions by creating and interacting with posts. It supports full CRUD operations for threads and comments, as well as user account management features such as login, registration, and password reset.

### Key Features:

- ✅ User registration and login
- 🧵 Create, view, update, and delete threads (posts)
- 💬 Comment on threads
- 🔒 Password reset request and secure password updating

---

## 🛠️ Technologies Used

- **PHP** — Backend scripting language for server-side logic
- **MySQL** — Relational database for storing users, posts, and comments

---

## 📁 Project Folder Structure

forum/
├── db/
│ ├── db.php # Database connection logic
│ └── sql.sql # SQL schema (users, posts, comments, etc.)
│
├── public/
│ ├── css/
│ │ └── styles.css # Application styling
│ │
│ ├── functions/
│ │ ├── commentfunc.php # Comment-related functions
│ │ ├── loginfunc.php # Login-related logic
│ │ ├── registerfunc.php # User registration logic
│ │ └── threadfunc.php # Thread/post management functions
│ │
│ ├── comment.php # Handle commenting on posts
│ ├── delete.php # Delete posts or comments
│ ├── index.php # Home page showing threads
│ ├── login.php # Login page
│ ├── logout.php # Logout logic
│ ├── new_password.php # Set a new password (after reset)
│ ├── post.php # Create a new post
│ ├── register.php # User registration page
│ ├── reset-password.php # Password reset request form
│ └── thread.php # View a single thread/post and its comments

---

## ⚙️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/forum.git
cd forum
```

### 2. Configure the database

```bash
    mysql -u your_user -p your_database < db/sql.sql
```

### 3. Run the application

```bash
    php -S localhost:8000 -t public
```

### 4. 🔐 Security Features

    Input sanitization using PHP functions

    SQL injection protection via prepared statements

    Session-based authentication

    Secure password reset workflow

---
