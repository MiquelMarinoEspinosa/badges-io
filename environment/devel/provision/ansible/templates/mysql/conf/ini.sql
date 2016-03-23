CREATE USER 'badgesUser'@'%%' IDENTIFIED BY 'badgesUser';
GRANT ALL PRIVILEGES ON *.* TO 'badgesUser'@'%%';
FLUSH PRIVILEGES;
CREATE DATABASE badgesDB;
USE badgesDB;
CREATE TABLE badges (
  id int,
  name varchar(250)
);