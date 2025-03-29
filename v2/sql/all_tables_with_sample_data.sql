DROP TABLE IF EXISTS ec_school_oa_enrollments;
DROP TABLE IF EXISTS ec_school_oa_courses;
DROP TABLE IF EXISTS ec_school_oa_users;

CREATE TABLE ec_school_oa_users (
    uid INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('student', 'instructor')
);

CREATE TABLE ec_school_oa_courses (
    cid INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(255),
    instructor_uid INT,
    FOREIGN KEY (instructor_uid) REFERENCES ec_school_oa_users(uid)
);

CREATE TABLE ec_school_oa_enrollments (
    eid INT PRIMARY KEY AUTO_INCREMENT,
    student_uid INT,
    cid INT,
    grade INT,
    FOREIGN KEY (student_uid) REFERENCES ec_school_oa_users(uid),
    FOREIGN KEY (cid) REFERENCES ec_school_oa_courses(cid),
    CHECK (grade >= 0 AND grade <= 100)
);
