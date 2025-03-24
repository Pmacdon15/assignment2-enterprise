CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(100)
);

INSERT INTO roles (role_name) VALUES ('Student'), ('Instructor');

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles (id)
);

CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(150)
);

INSERT INTO courses (course_name) VALUES ("Math"), ("Programming");

CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,   
    user_id int,
    grade int CHECK (
        grade >= 0
        AND grade <= 100
    ),
    course_id int UNIQUE,
    FOREIGN KEY (course_id) REFERENCES courses (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

