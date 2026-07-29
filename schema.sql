-- EcoHunt database schema
-- Import with: C:\xampp\mysql\bin\mysql.exe -u root < schema.sql

CREATE DATABASE IF NOT EXISTS ecohunt_db;
USE ecohunt_db;

CREATE TABLE IF NOT EXISTS users (
    userid VARCHAR(20) NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    url_address VARCHAR(50) NOT NULL
);
