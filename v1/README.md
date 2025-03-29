# Enterprise Assignment 2 - V1 API Documentation

## Overview
This API provides endpoints for user authentication and grade management. The API uses cookie-based authentication, so there's no need to manually include auth tokens in requests.

## Base URL
All endpoints are relative to: `http://localhost/assignment2-enterprise/`

## Authentication

### Register New User
Create a new user account with specified role.

**Endpoint:** `POST /register.php`

**Request Body:**
```json
{
    "email": "your.email@example.com",
    "password": "yourSecurePassword",
    "role_id": 1
}
```

**Role IDs:**
- 1: Student
- 2: Instructor 

**Response:**
- Success: 200 OK
- Error: 400 Bad Request

### User Login
Authenticate existing user and create session.

**Endpoint:** `POST /login.php`

**Request Body:**
```json
{
    "email": "your.email@example.com",
    "password": "yourSecurePassword"
}
```

**Response:**
- Success: 200 OK (Sets authentication cookie)
- Error: 401 Unauthorized

## Grade Management

### Add/Update Grade
Add or update a grade for a specific student and course.

**Endpoint:** `POST /grading.php`

**Request Body:**
```json
{
    "user_id": 1,
    "course_id": 2,
    "grade": 90
}
```

**Notes:**
- Grade must be between 0 and 100
- Both user_id and course_id must exist in the system

### Delete Grade
Remove a grade entry for a specific student and course.

**Endpoint:** `DELETE /grading.php`

**Request Body:**
```json
{
    "user_id": 1,
    "course_id": 2
}
```

## Error Handling
All endpoints return appropriate HTTP status codes:
- 200: Success
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 500: Server Error

## Security Notes
- All passwords are hashed before storage