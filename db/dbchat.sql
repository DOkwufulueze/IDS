CREATE DATABASE IF NOT EXISTS chat;

USE chat;

CREATE TABLE IF NOT EXISTS admin(
	username varchar(20),
	password varchar(100),
	constraint adm primary key(username)
);
# Populating admin
INSERT INTO admin(username, password) VALUES("ceejay",md5("hot"));

CREATE TABLE IF NOT EXISTS `users` (
  `id` int() NOT NULL AUTO_INCREMENT,
  `username` varchar(200) CHARACTER SET utf8 NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `picture` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `messages` (
  `id` int() NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `message_time` DATETIME,
  `recipient` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS users(
	id int auto_increment ,
	username varchar(20),
	password varchar(100),
	pin char(10),
	name varchar(300),
	sex char(6),
	email varchar(120),
	phone varchar(15),
	address varchar(200),
	image varchar(200),
	constraint un primary key(id,username,pin)
);

CREATE TABLE IF NOT EXISTS secret_numbers(
	id int auto_increment,
	pins char(10),
	status char(10),
	user varchar(200),
	constraint pns primary key(id,pins)
);
