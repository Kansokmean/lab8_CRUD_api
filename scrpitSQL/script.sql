CREATE DATABASE students_db;
USE students_db;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    class VARCHAR(50) NOT NULL,
    major VARCHAR(100) NOT NULL
);