CREATE DATABASE qbee;

USE qbee;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    question_text TEXT NOT NULL,
    question_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- CREATE TABLE responses (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     question_id INT,
--     response_text TEXT,
--     response_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (question_id) REFERENCES questions(id)
-- );
