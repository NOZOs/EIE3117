# Create DB
CREATE DATABASE IF NOT EXISTS bookmark_system;
use bookmark_system;

# Create Tables
CREATE TABLE users(
	`username` VARCHAR(16) NOT NULL PRIMARY KEY,
	`password` VARCHAR(40) NOT NULL,
	`email` VARCHAR(100) NOT NULL
);
CREATE TABLE bookmarks (
	`id` INT(5) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(16) NOT NULL,
	`url` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
);
CREATE TABLE foodmenu (
	`id` INT(5) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(16) NOT NULL,
	`foodTitle` VARCHAR(255) NOT NULL,
	`dishDescription` VARCHAR(255) NOT NULL,
	`price` DECIMAL(10,2) NOT NULL,
	PRIMARY KEY(`id`)
);

# Set MySQL Web User
CREATE USER IF NOT EXISTS 'bookmark_web'@'%' IDENTIFIED BY '36XrVk7tMLUkv4dq';
GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'bookmark_web'@'%';
FLUSH PRIVILEGES;