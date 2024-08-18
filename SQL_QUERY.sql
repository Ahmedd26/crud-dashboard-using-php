CREATE DATABASE dashboard_app;
use dashboard_app;

CREATE TABLE users (
    id INT auto_increment PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255)
);

INSERT INTO users (full_name, email, password, profile_picture) VALUES
('John Doe', 'john@test.com', 'password123', 'profile1.jpg'),
('Jane Smith', 'jane@test.com', 'password123', 'profile2.jpg'),
('Alice Johnson', 'alice@test.com', 'password123', 'profile3.jpg'),
('Bob Brown', 'bob@test.com', 'password123', 'profile4.jpg'),
('Charlie Davis', 'charlie@test.com', 'password123', 'profile5.jpg');

SELECT * FROM users;
DELETE FROM users WHERE id > 5;

INSERT INTO users (full_name, email, password, profile_picture) VALUES
('ahmed', 'ahmed@test.com', 'asdfghjk', 'profile1.jpg'),

