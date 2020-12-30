# API

* [User](#User)
    * [Register](#Register)
    * [Login](#Login)
    * [Logout](#Logout)

## User

### Register

*Request:*

```
POST /api/register
```
```JSON
{
  "username": "example@domain.com",
  "password": "secret-password",
  "name": "John",
  "surname": "Kovalsky",
  "avatar": "__FILE__"
}
```

*Response on SUCCESS:*

```
200 OK
```
```JSON
{
  "id": "6",
  "username": "example@domain.com",
  "name": "John",
  "surname": "Kovalsky",
  "avatar": "6_exampledomaincom.png"
}
```

*Response on FAILURE:*

```
404 Not Found
```

Errors:
* no username
* no password
* username must be email
* user already exists

e.g.
```JSON
{
  "error": "user already exists"
}
```

### Login

```
POST /api/login
```
```JSON
{
  "username": "example@domain.com",
  "password": "secret-password"
}
```

Use GET to retrieve current user

```
GET /api/login
```

*Response on SUCCESS:*

```
200 OK
```
```JSON
{
  "username": "example@domain.com",
  "roles": [],
  "details": [],
}
```

*Response on FAILURE:*

```
404 Not Found
```

Errors:
* login failed

e.g.
```JSON
{
  "error": "login failed"
}
```

### Logout

```
GET | POST /api/logout
```

*Response on SUCCESS:*

```
200 OK
```

*Response on FAILURE:*

```
404 Not Found
```
