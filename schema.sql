CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

/*
Исполнители и заказчики
 */
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    password CHAR(32) NOT NULL,
    birth_date DATETIME,
    description TEXT,
    phone CHAR(11),
    email VARCHAR(50) NOT NULL UNIQUE,
    image_link VARCHAR(150),
    city_id INT(11) NOT NULL,
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*
Задания, публикуемые заказчиком
 */
CREATE TABLE tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    category_id INT(11) NOT NULL,
    budget INT(11) NOT NULL,
    city_id INT(11) DEFAULT 0 NOT NULL,
    address_comment VARCHAR(150),
    status_id TINYINT(1) NOT NULL DEFAULT 1,
    owner_id INT(11) NOT NULL,
    executor_id INT(11) NOT NULL DEFAULT 0,
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*
Статусы задания
 */
CREATE TABLE tasks_statuses (
    id TINYINT(1) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

/*
Файлы задания
 */
CREATE TABLE tasks_files (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    task_id INT(11),
    file_link TEXT
);

/*
Категории
 */
CREATE TABLE categories (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45) NOT NULL UNIQUE
);

/*
Отклики на задание
 */
CREATE TABLE tasks_responses (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL,
    budget INT(11) NOT NULL,
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    task_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL
);

/*
Файлы исполнителя (портфолио)
 */
CREATE TABLE users_files (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    file_link TEXT NOT NULL
);

/*
Специализации исполнителя
*/
CREATE TABLE users_specializations (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    category_id INT(11),
    user_id INT(11)
);

/*
Типы уведомлений
 */
CREATE TABLE notifications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45)
);

/*
Подписки пользователя на уведомления
 */
CREATE TABLE users_notifications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    notification_id INT(11),
    user_id INT(11)
);

/*
Отправленные уведомления на действия в системе
 */
CREATE TABLE users_notifications_log (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    notification_id INT(11),
    task_id INT(11),
    user_id INT(11),
    date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*
Города
 */
CREATE TABLE cities (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(350) NOT NULL,
    lat DOUBLE(8, 7),
    lng DOUBLE(8, 7)
);

/*
Выбранный город
 */
CREATE TABLE users_cities (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    city_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    cookies TEXT NOT NULL
);

/*
Отзывы на задания
 */
CREATE TABLE reviews (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(500),
    rating TINYINT(1) NOT NULL,
    user_id INT(11) NOT NULL,
    task_id INT(11) NOT NULL
);

/*
Диалоги заказчика и исполнителя по поводу задачи
 */
CREATE TABLE dialogs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    text VARCHAR(300) NOT NULL,
    sender_id INT(11) NOT NULL,
    receiver_id INT(11) NOT NULL,
    task_id INT(11) NOT NULL
);

/*
Индексы
 */
ALTER TABLE users ADD FOREIGN KEY (city_id) REFERENCES cities(id);

ALTER TABLE tasks ADD FOREIGN KEY (category_id) REFERENCES categories(id);
ALTER TABLE tasks ADD FOREIGN KEY (city_id) REFERENCES cities(id);
ALTER TABLE tasks ADD FOREIGN KEY (status_id) REFERENCES tasks_statuses(id);
ALTER TABLE tasks ADD FOREIGN KEY (owner_id) REFERENCES users(id);
ALTER TABLE tasks ADD FOREIGN KEY (executor_id) REFERENCES users(id);

ALTER TABLE tasks_files ADD FOREIGN KEY (task_id) REFERENCES tasks(id);

ALTER TABLE users_files ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE users_specializations ADD FOREIGN KEY (category_id) REFERENCES categories(id);
ALTER TABLE users_specializations ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE users_notifications ADD FOREIGN KEY (notification_id) REFERENCES notifications(id);
ALTER TABLE users_notifications ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE users_notifications_log ADD FOREIGN KEY (notification_id) REFERENCES notifications(id);
ALTER TABLE users_notifications_log ADD FOREIGN KEY (task_id) REFERENCES tasks(id);
ALTER TABLE users_notifications_log ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE users_cities ADD FOREIGN KEY (city_id) REFERENCES cities(id);
ALTER TABLE users_cities ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE reviews ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE reviews ADD FOREIGN KEY (task_id) REFERENCES tasks(id);

ALTER TABLE dialogs ADD FOREIGN KEY (sender_id) REFERENCES users(id);
ALTER TABLE dialogs ADD FOREIGN KEY (receiver_id) REFERENCES users(id);
ALTER TABLE dialogs ADD FOREIGN KEY (task_id) REFERENCES tasks(id);
