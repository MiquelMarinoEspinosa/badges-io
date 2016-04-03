CREATE USER 'badgesUser'@'%%' IDENTIFIED BY 'badgesUser';
GRANT ALL PRIVILEGES ON *.* TO 'badgesUser'@'%%';
FLUSH PRIVILEGES;