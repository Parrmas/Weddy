-- Create the database
CREATE DATABASE admin_panel;

-- Switch to the database
USE admin_panel;

-- Create the table for admin users
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create the table for types
CREATE TABLE types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    count INTEGER(50) NOT NULL,
    price INTEGER(50) NOT NULL,
    note TEXT
);

-- Create the table for shifts
CREATE TABLE shifts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shift_name VARCHAR(50) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL
);

-- Create the table for services
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(50) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL
);

-- Create the table for general settings
CREATE TABLE general_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_title VARCHAR(100) NOT NULL,
    logo VARCHAR(100) NOT NULL,
    email_settings TEXT NOT NULL
);

-- Create the table for bookings
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_1_name VARCHAR(50) NOT NULL,
    person_2_name VARCHAR(50) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    no_of_table INTEGER(50) NOT NULL,
    no_of_reserved_table INTEGER(50) NOT NULL,
    type_id INTEGER(50) NOT NULL,
    shift_id INTEGER(50) NOT NULL
);

CREATE TABLE booking_dishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INTEGER(50) NOT NULL,
    dish_id INTEGER(50) NOT NULL
);

CREATE TABLE booking_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INTEGER(50) NOT NULL,
    service_id INTEGER(50) NOT NULL
);
