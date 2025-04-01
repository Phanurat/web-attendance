-- สร้างฐานข้อมูล
CREATE DATABASE IF NOT EXISTS attendance_system;

-- สร้างตาราง users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- สร้างตาราง attendance
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    time_in TIME NULL,
    time_out TIME NULL,
    FOREIGN KEY (employee_id) REFERENCES users(id)
);
