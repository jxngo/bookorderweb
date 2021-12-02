DROP DATABASE IF EXISTS group4710;
CREATE DATABASE group4710;
USE group4710;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    -- AccType can only be client, admin, or staff - case sensitive
    accounttype VARCHAR(10) NOT NULL DEFAULT '',
    email VARCHAR(50) NOT NULL DEFAULT '',
    username VARCHAR(50) NOT NULL DEFAULT '',
    password VARCHAR(255) NOT NULL DEFAULT '',
    firstname VARCHAR(50) NOT NULL DEFAULT '',
    lastname VARCHAR(50) NOT NULL DEFAULT ''
);
-- password is 'password'
INSERT INTO users(accounttype, email, username, password, firstname, lastname) VALUES ('admin', 'admin@bookorder.com', 'root', 'password', 'first', 'last');

