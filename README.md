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
