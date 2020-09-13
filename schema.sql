CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(350) NOT NULL,
    email CHAR(50) NOT NULL UNIQUE,
    password CHAR(255) NOT NULL,
    address VARCHAR(500),
    birth_date DATETIME,
    rating FLOAT(1,1) NOT NULL,
    description VARCHAR(1000),
    phone CHAR(11),
    skype CHAR(35),
    another_messenger CHAR(35),
    image_link CHAR(150),
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title CHAR(50) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    category_id INT(11) NOT NULL,
    budget INT(11) NOT NULL,
    location_id INT(11) NOT NULL,
    status_id INT(11) NOT NULL,
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_finish DATETIME NOT NULL
);

CREATE TABLE tasks_statuses (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name CHAR(50) NOT NULL
);

CREATE TABLE tasks_files (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    task_id INT(11),
    file_link CHAR(250)
);

CREATE TABLE tasks_categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name CHAR(20) NOT NULL UNIQUE
);

CREATE TABLE users_tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    task_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL
);

CREATE TABLE specializations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name CHAR(250) NOT NULL UNIQUE
);

CREATE TABLE users_specializations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    specialization_id INT(11),
    user_id INT(11)
);

CREATE TABLE notifications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name CHAR(50)
);

CREATE TABLE users_notifications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    notification_id INT(11),
    user_id INT(11)
);

CREATE TABLE locations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(350) NOT NULL,
    lat DOUBLE(8, 7),
    lng DOUBLE(8, 7)
);

CREATE TABLE reviews (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(500),
    user_id INT(11) NOT NULL,
    task_id INT(11) NOT NULL
);

CREATE TABLE dialogs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sender_id INT(11) NOT NULL,
    receiver_id INT(11) NOT NULL,
    task_id INT(11) NOT NULL
);

ALTER TABLE tasks ADD FOREIGN KEY (category_id) REFERENCES tasks_categories(id);
ALTER TABLE tasks ADD FOREIGN KEY (location_id) REFERENCES locations(id);
ALTER TABLE tasks ADD FOREIGN KEY (status_id) REFERENCES tasks_statuses(id);
ALTER TABLE tasks_files ADD FOREIGN KEY (task_id) REFERENCES tasks(id);
ALTER TABLE users_tasks ADD FOREIGN KEY (task_id) REFERENCES tasks(id);
ALTER TABLE users_tasks ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE users_specializations ADD FOREIGN KEY (specialization_id) REFERENCES specializations(id);
ALTER TABLE users_specializations ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE users_notifications ADD FOREIGN KEY (notification_id) REFERENCES notifications(id);
ALTER TABLE users_notifications ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE reviews ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE reviews ADD FOREIGN KEY (task_id) REFERENCES tasks(id);
ALTER TABLE dialogs ADD FOREIGN KEY (sender_id) REFERENCES users(id);
ALTER TABLE dialogs ADD FOREIGN KEY (receiver_id) REFERENCES users(id);
ALTER TABLE dialogs ADD FOREIGN KEY (task_id) REFERENCES tasks(id);
