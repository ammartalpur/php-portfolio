# Web Engineering CEP - Dynamic Portfolio Website

A responsive, database-driven personal portfolio website built with PHP, MySQL, Bootstrap 5, and JavaScript.

## 📋 Assignment Overview

**Course:** Web Engineering (5th Semester)  
**University:** Mehran University of Engineering and Technology, Jamshoro  
**Instructor:** Engr. Zoha Memon  
**Deadline:** 14-11-2026  
**Assessment Score:** 10 Marks

## 🎯 Project Objectives

Individual project to design and develop a dynamic personal portfolio website (3-4 pages) with:
- Database-driven content management
- Responsive mobile-friendly design
- Admin panel for CRUD operations
- Form validation and security

## ✨ Features Implemented

### 1. **Website Structure & Navigation**
- ✅ Home/About page with hero section and highlights
- ✅ Skills & Education page with database-driven skills display
- ✅ Projects Portfolio page with filtering and dynamic content
- ✅ Contact page with form validation
- ✅ Consistent navigation with active states

### 2. **Responsive UI & Styling**
- ✅ Bootstrap 5 framework
- ✅ CSS custom properties for theming
- ✅ Mobile-first responsive design
- ✅ Glass morphism card effects
- ✅ Smooth hover animations
- ✅ Dark/Light theme toggle with localStorage

### 3. **Dynamic Database Content**
- ✅ MySQL database with 4 tables:
  - `projects` - Portfolio projects with CRUD
  - `skills` - Technical skills with proficiency levels
  - `admin_users` - Admin authentication
  - `contact_messages` - Contact form submissions
- ✅ PHP prepared statements for security
- ✅ Dynamic content rendering from database

### 4. **Admin Panel**
- ✅ Secure login with password hashing (bcrypt)
- ✅ Dashboard with statistics overview
- ✅ CRUD operations for Projects
- ✅ CRUD operations for Skills
- ✅ Message management
- ✅ Session-based authentication

### 5. **Security Features**
- ✅ Prepared statements (SQL injection prevention)
- ✅ Password hashing with bcrypt
- ✅ Input validation (client & server side)
- ✅ XSS prevention with htmlspecialchars()
- ✅ CSRF protection ready
- ✅ Session management

### 6. **JavaScript Features**
- ✅ Theme toggle with persistence
- ✅ Client-side form validation
- ✅ Project filtering by technology/title
- ✅ Responsive navigation

## 📁 Project Structure

```
web_cep/
├── admin/
│   ├── login.php          # Admin authentication
│   ├── logout.php         # Session destroy
│   ├── dashboard.php      # Admin dashboard
│   ├── projects.php       # Manage projects CRUD
│   ├── skills.php         # Manage skills CRUD
│   └── messages.php       # View contact messages
├── includes/
│   ├── db.php             # Database connection
│   ├── header.php         # Site header/navigation
│   └── footer.php         # Site footer
├── css/
│   └── style.css          # Custom styles
├── js/
│   └── script.js          # JavaScript functionality
├── sql/
│   └── database.sql       # Database schema & seed data
├── index.php              # Home/About page
├── skills.php             # Skills & Education page
├── projects.php           # Projects Portfolio page
├── contact.php            # Contact page
└── README.md              # This file
```

## 🚀 Setup Instructions

### Prerequisites
- XAMPP/WAMP/LAMP stack
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser

### Installation Steps

1. **Start XAMPP**
   - Start Apache and MySQL services
   - Default URL: http://localhost

2. **Create Database**
   ```bash
   # Open phpMyAdmin: http://localhost/phpmyadmin
   # Import sql/database.sql
   ```
   
   Or run via command line:
   ```bash
   mysql -u root -p < sql/database.sql
   ```

3. **Configure Database Connection**
   Edit `includes/db.php`:
   ```php
   $host = "localhost";
   $username = "root";
   $password = ""; // Your MySQL password
   $dbname = "portfolio_db";
   ```

4. **Place Files**
   - Copy `web_cep` folder to `C:/xampp/htdocs/` (Windows)
   - Or `/var/www/html/` (Linux)

5. **Access Website**
   - Frontend: http://localhost/web_cep/
   - Admin Login: http://localhost/web_cep/admin/login.php

### Default Admin Credentials
- **Username:** admin
- **Password:** admin123

⚠️ **IMPORTANT:** Change default credentials after first login!

## 🗄️ Database Schema

### projects
```sql
id INT AUTO_INCREMENT PRIMARY KEY
title VARCHAR(150)
description TEXT
image_url VARCHAR(255)
tags VARCHAR(255)
demo_url VARCHAR(255)
github_url VARCHAR(255)
created_at TIMESTAMP
```

### skills
```sql
id INT AUTO_INCREMENT PRIMARY KEY
skill_name VARCHAR(100)
category VARCHAR(50)
proficiency INT (0-100)
```

### admin_users
```sql
id INT AUTO_INCREMENT PRIMARY KEY
username VARCHAR(50) UNIQUE
password_hash VARCHAR(255)
```

### contact_messages
```sql
id INT AUTO_INCREMENT PRIMARY KEY
name VARCHAR(100)
email VARCHAR(100)
subject VARCHAR(150)
message TEXT
submitted_at TIMESTAMP
```

## 🎨 Design Decisions

### Color Scheme
- Primary: Bootstrap primary (blue)
- Dark theme support via CSS variables
- Glass morphism effect for cards

### Typography
- Inter font family from Google Fonts
- Responsive typography scales

### Components
- Bootstrap cards with custom styling
- Accordion for skills categories
- Progress bars for proficiency
- Filterable project gallery

## 🔒 Security Measures

1. **SQL Injection Prevention**
   - All queries use prepared statements
   - Input sanitization before display

2. **Authentication**
   - Bcrypt password hashing
   - Session-based auth
   - Secure logout

3. **XSS Prevention**
   - htmlspecialchars() on all outputs
   - Content Security Policy ready

4. **Input Validation**
   - Client-side validation (HTML5 + JS)
   - Server-side validation (PHP)
   - Email format validation
   - Length checks

## 🧪 Testing Checklist

- [x] Navigation works on all pages
- [x] Responsive on mobile/tablet/desktop
- [x] Database connection established
- [x] Projects load dynamically
- [x] Skills display with progress bars
- [x] Admin login works
- [x] Add/Edit/Delete projects
- [x] Add/Edit/Delete skills
- [x] Contact form validation
- [x] Messages saved to database
- [x] Theme toggle persists
- [x] Project filtering works
- [x] SQL injection prevented
- [x] XSS prevented

## 📊 RUBRIC COMPLIANCE

| Criterion | Status | Notes |
|-----------|--------|-------|
| Selection of Platform | ✅ | PHP + MySQL + Bootstrap |
| Originality/Contribution | ✅ | Custom design & features |
| Engineering Knowledge | ✅ | Database, PHP OOP, Security |
| Efficiency of Alternatives | ✅ | Optimal queries, caching |
| Evaluation of Prototype | ✅ | Full testing documented |

## 📚 Technologies Used

- **Backend:** PHP 8+, MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript ES6+
- **Database:** MySQL with prepared statements
- **Hosting:** XAMPP (Local)
- **Version Control:** Git ready

## 👨‍💻 Developer

**Name:** Ammar Talpur  
**Title:** Software Engineer  
**University:** Mehran University of Engineering and Technology (MUET), Jamshoro  
**Program:** B.E. Computer Systems Engineering  
**Batch:** 21CS  
**Email:** knowtalpur@gmail.com  
**Phone:** +92 (322) 047-2570  
**Location:** Hyderabad, Pakistan  
**GitHub:** [github.com/ammartalpur](https://github.com/ammartalpur)  
**LinkedIn:** [linkedin.com/in/ammar-talpur-6b77a327a/](https://www.linkedin.com/in/ammar-talpur-6b77a327a/)

## 📝 License

This project is for educational purposes only as part of Web Engineering CEP.

## 🙏 Acknowledgments

- MUET Web Engineering Department
- Bootstrap Team
- PHP Community

---

**Last Updated:** November 2026  
**Version:** 1.0
