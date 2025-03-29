# Enterprise Assignment 2 - V2 API Documentation

## Overview
This API provides endpoints for user authentication and grade management using JWT (JSON Web Token) based authentication. The V2 API improves security by implementing token-based authentication instead of cookies.

## Base URL
All endpoints are relative to: `http://localhost/assignment2-enterprise/v2/`

## Authentication

### Sign Up
Create a new user account with specified role.

**Endpoint:** `POST /signup.php`

**Request Body:**
```json
{
    "username": "your.username",
    "password": "yourSecurePassword",
    "role": "student"
}
```

**Role Options:**
- `student`: Regular student user
- `instructor`: Teacher/instructor user

**Response:**
- Success: 200 OK with message
- Error: 400 Bad Request

### Login
Authenticate existing user and get JWT token.

**Endpoint:** `POST /login.php`

**Request Body:**
```json
{
    "username": "your.username",
    "password": "yourSecurePassword"
}
```

**Response:**
- Success: 200 OK with JWT token
- Error: 401 Unauthorized

## Protected Endpoints

All protected endpoints require a valid JWT token in the Authorization header:
```
Authorization: Bearer <your_jwt_token>
```

### Grade Management

#### Add/Update Grade
Add or update a grade for a specific student and course.

**Endpoint:** `POST /grading.php`

**Request Body:**
```json
{
    "student_id": 1,
    "course_id": 2,
    "grade": 90
}
```

**Notes:**
- Requires instructor role
- Grade must be between 0 and 100
- Both student_id and course_id must exist in the system
- Instructor must be assigned to the course

#### Delete Grade
Remove a grade entry for a specific student and course.

**Endpoint:** `DELETE /grading.php`

**Request Body:**
```json
{
    "student_id": 1,
    "course_id": 2
}
```

**Notes:**
- Requires instructor role
- Instructor must be assigned to the course
- Will return 404 if grade entry doesn't exist

## Error Handling
All endpoints return appropriate HTTP status codes and error messages:
- 200: Success
- 400: Bad Request (invalid input)
- 401: Unauthorized (invalid/missing token)
- 403: Forbidden (insufficient permissions)
- 404: Not Found
- 500: Server Error

## Security Features
- Password hashing using bcrypt
- JWT-based authentication
- Role-based access control
- Token expiration (1 hour)
- Input validation and sanitization
- Prepared SQL statements for DB operations

## Database Schema
```sql
users(uid, username, password, role)
courses(cid, course_name, instructor_uid)
enrollments(eid, student_uid, cid, grade)
```

## Testing
Use the included Postman collection in `/postman/v2-postman_collection.json` for API testing.

## Sample Data
Run `/tools/init-database-with-sample-data.php` to populate the database with test data:
- 3 instructors (instructor1, instructor2, instructor3)
- 3 students (student1, student2, student3)
- 3 courses