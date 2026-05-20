CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

INSERT INTO users (first_name, last_name, status, role) VALUES
('John', 'Doe', 'active', 'admin'),
('Jane', 'Smith', 'active', 'user'),
('Alice', 'Johnson', 'inactive', 'user'),
('Bob', 'Brown', 'active', 'user');