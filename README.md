# comments
Comment system with back end made in PHP and front end made in Mithril

## Before init
Before init you need to execute the commands bellow in the MySQL:
```sql
CREATE DATABASE comments CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
USE comments;
CREATE TABLE comments (
	id int AUTO_INCREMENT,
	name VARCHAR(32),
	text VARCHAR(512),
	PRIMARY KEY(id),
	UNIQUE(text)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
And in the directory `backend` create the file `ENV.php` with the constants below:
```
HOST
USER
PASSWORD
DATABASE
TABLE
CORS
```
If you use the default password, the defalut user, and exec the MySQL in your computer, the file will be like this:
```php
<?php
	const HOST = 'localhost';
	const USER = 'root';
	const PASSWORD = '';
	const DATABASE = 'comments';
	const TABLE = 'comments';
	const CORS = 'http://localhost';
?>
```
And in the directory `frontend`, create the file `ENV.js` with the const `SERVER`, if you are executing the MySQL in your comuter it'll be like this:
```js
const SERVER = 'http://localhost:3333/comments';
```
## Initializing
Now you can execute the back-end with the command below:
```
php -S localhost:3333 index.php
```
(this command must be executed in the directory `backend`)
The front-end can be executed with Apache or PHP, I prefer PHP, for it the command is:
```
php -S localhost:80
```
(this command must be executed in the directory `frontend`)