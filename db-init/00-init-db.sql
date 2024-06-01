CREATE DATABASE IF NOT EXISTS fantasydb;
CREATE USER 'fantasydb'@'%' IDENTIFIED BY 'fantasydb';
GRANT ALL PRIVILEGES ON fantasydb.* TO 'fantasydb'@'%';
flush privileges;

