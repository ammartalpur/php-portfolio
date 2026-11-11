CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- 1. Table for Portfolio Projects
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) DEFAULT 'assets/img/default-project.jpg',
    tags VARCHAR(255) NOT NULL,
    demo_url VARCHAR(255) DEFAULT '#',
    github_url VARCHAR(255) DEFAULT '#',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table for Skills & Education
CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL, -- e.g., Frontend, Backend, Database, Leadership
    proficiency INT DEFAULT 85 -- Percentage value 0-100
);

-- 3. Table for Admin Credentials (CRUD access)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

-- 4. Table for Contact Form Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Initial Projects Data from your portfolio
INSERT INTO projects (title, description, tags, demo_url, github_url) VALUES
('Socialogram', 'Socialogram, a full-stack social media web application built using modern web technologies with a strong focus on performance, scalability, and clean UI by using the power of Next.Js.', 'Next.js, TailwindCSS, Supabase, Zod/Cloudinary', 'https://next-social-gamma.vercel.app/', 'https://github.com/ammartalpur/next-social'),
('Roozgar Job Portal', 'Roozgar is a modern job portal built with React.js, designed to seamlessly connect job seekers with recruiters.', 'TypeScript, Supabase, Next.js', 'https://roozgar-jobportal.vercel.app/', 'https://github.com/ammartalpur/roozgar-jobportal'),
('Digital Voting System', 'Ditigal Voting System created in C++ with web based GUI and Facial Veification.', 'Javascript, HTML/CSS/EJS, C++', '#', 'https://github.com/ammartalpur/digital_voting_system'),
('Sportz - Websocket Project', 'Sportz is a modern real-time sports tracking platform built to manage matches, live commentary, and instant updates for connected clients using WebSockets.', 'Next.js, Node(Express.js), PostgreSQL, Drizzle ORM, WebSockets, Zod, Arcjet', '#', 'https://github.com/ammartalpur/sportz-websockets'),
('Software House OS', 'A comprehensive, role-based Project and Task Management operating system designed specifically for software development agencies. This system serves as a custom-tailored alternative to Jira or Trello, enforcing a strict, professional pipeline from project creation to Quality Assurance (QA) delivery.', 'Next.js 15, Tailwind CSS, PostgreSQL, Prisma, Clerk', '#', 'https://github.com/ammartalpur/software-house-os'),
('ProKitchen POS System', 'A high-performance, real-time Point of Sale (POS) and Kitchen Display System (KDS) designed for modern restaurant environments. Built with a focus on operational speed, data integrity, and real-time synchronization between the front-of-house and back-of-house.', 'Next.js 15, Tailwind CSS, PostgreSQL, Websockets, Clerk, Cloudinary', '#', 'https://github.com/ammartalpur/point-of-sale');

-- Seed Skills Data
INSERT INTO skills (skill_name, category, proficiency) VALUES
('React', 'Frontend', 95),
('Next.js', 'Frontend', 95),
('TypeScript', 'Languages', 90),
('Node.js', 'Backend', 85),
('GraphQL', 'Backend', 80),
('PostgreSQL', 'Database', 88),
('MongoDB', 'Database', 75),
('Redis', 'Database', 70),
('Docker', 'DevOps', 80),
('AWS', 'Cloud', 75),
('Vercel', 'DevOps', 85),
('Tailwind CSS', 'Frontend', 95),
('Prisma', 'Backend', 85),
('Jest', 'Testing', 80),
('Cypress', 'Testing', 75),
('Figma', 'Design', 80),
('Git', 'DevOps', 90),
('GitHub Actions', 'DevOps', 75);

-- Seed Default Admin User (Password: admin123 hashed with BCRYPT)
INSERT INTO admin_users (username, password_hash) VALUES
('admin', '$2b$12$TduAcPrlS9JnsWZ94j6N2OAglxgXL1y0/7CsSDAT/pm/XTwCgWd4e');
