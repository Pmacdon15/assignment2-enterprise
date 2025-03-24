# Assignment 2 for Enterprise
## Register
### Post Route
```localhost/assignment2-enterprise/register.php```
#### Body
```json
{
    "email":"YourEmailHere",
    "password":"YourPassWordHere",
    "role_id": 1
}
```
## Login
### Post Route
```localhost/assignment2-enterprise/login.php```
#### Body
```json
{
    "email":"YourEmailHere",
    "password":"YourPassWordHere"  
}
```
## Grading
### Post Route
```localhost/assignment2-enterprise/grading.php```
#### Body
```json
{
    "user_id": 1,
    "course_id": 2,
    "grade": 90    
}
```
### Delete Route
```localhost/assignment2-enterprise/grading.php```
#### Body
```json
{
    "user_id": 1,
    "course_id": 2    
}
```