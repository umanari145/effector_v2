-- init.sql
CREATE DATABASE kourin;
CREATE USER 'kourin_user'@'%' IDENTIFIED BY 'kourin_pass';
GRANT ALL PRIVILEGES ON kourin.* TO 'kourin_user'@'%';
FLUSH PRIVILEGES;
