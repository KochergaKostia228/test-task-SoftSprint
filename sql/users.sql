CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    status BOOLEAN NOT NULL DEFAULT TRUE,
    role INT NOT NULL DEFAULT 2
);

INSERT INTO users (first_name, last_name, status, role) VALUES
('John', 'Doe', TRUE, 1),
('Jane', 'Smith', TRUE, 2),
('Alice', 'Johnson', FALSE, 2),
('Bob', 'Brown', TRUE, 2);