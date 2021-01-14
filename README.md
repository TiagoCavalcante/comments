# comments
A comment system with backend made in PHP and frontend made in Mithril

## Before init
Before init you need to:
*  execute the commands bellow in the MySQL:
  ```sql
  CREATE DATABASE comments CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
  USE comments;
  CREATE TABLE comments (
  	id INT AUTO_INCREMENT,
  	name VARCHAR(32),
  	text VARCHAR(512),
  	PRIMARY KEY(id),
  	UNIQUE(text)
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  ```
* in the directory `backend`:
  * create the file `env.php` with the following `env`s:
    * name (it will always be `mysql`)
    * host
    * port
    * user
    * password
    * database
    * CORS
    If you use the default password, the defalut user, and exec the MySQL in your computer, the file will be like this:
    ```php
    <?php
    	putenv('name=mysql');
    	putenv('host=localhost');
    	putenv('port=3306');
    	putenv('user=root');
    	putenv('password=');
    	putenv('database=comments');
    	putenv('CORS=http://localhost');
    ?>
    ```
	install dependencies: `composer install`
* in the directory `frontend`:
  * create the file `env.js` with the const `SERVER`, if you are executing the MySQL in your comuter it'll be like this:
  ```js
  const SERVER = 'http://localhost:3333/comments';
  ```

## Initializing
Now you can execute the backend with the command below:
```
php -S localhost:3333 index.php
```
(this command must be executed in the directory `backend`)
The frontend can be executed with Apache or PHP, I prefer PHP, for it the command is:
```
php -S localhost:80
```
(this command must be executed in the directory `frontend`)