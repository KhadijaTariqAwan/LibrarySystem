CREATE DATABASE IF NOT EXISTS khadijalib;
USE khadijalib;

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  category VARCHAR(100),
  isbn VARCHAR(50)
);

CREATE TABLE members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  member_id INT,
  book_id INT,
  action ENUM('borrow', 'return'),
  action_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
