INSERT INTO `users` (`id`, `date_reg`, `email`, `name`, `password`, `avatar`, `contact`)
VALUES (NULL, CURRENT_TIMESTAMP, 'admin@mail.ru', 'admin', '123456', NULL, '8-123-456-78-99'),
       (NULL, CURRENT_TIMESTAMP, 'user@mail.ru', 'testuser', '123456789', NULL, '8-950-13-45-78');

INSERT INTO `categories` (`id`, `name`)
VALUES (NULL, 'Доски и лыжи'),
       (NULL, 'Крепления'),
       (NULL, 'Ботинки'),
       (NULL, 'Одежда'),
       (NULL, 'Инструменты'),
       (NULL, 'Разное');

INSERT INTO `lots` (`id`, `date_create`, `title`, `description`, `image`, `start_price`, `date_finish`, `step`, `author_id`, `win_id`, `category_id`)
VALUES (NULL, CURRENT_TIMESTAMP, '2014 Rossignol District Snowboard', NULL, 'img/lot-1.jpg', '10999', '2019-02-17 00:00:00', '100', '1', NULL, '1');

INSERT INTO `lots` (`id`, `date_create`, `title`, `description`, `image`, `start_price`, `date_finish`, `step`, `author_id`, `win_id`, `category_id`)
VALUES (NULL, CURRENT_TIMESTAMP, 'DC Ply Mens 2016/2017 Snowboard', NULL, 'img/lot-2.jpg', '159999', '2019-02-19 00:00:00', '1000', '2', NULL, '1');

INSERT INTO `lots` (`id`, `date_create`, `title`, `description`, `image`, `start_price`, `date_finish`, `step`, `author_id`, `win_id`, `category_id`)
VALUES (NULL, CURRENT_TIMESTAMP, 'Крепления Union Contact Pro 2015 года размер L/XL', NULL, 'img/lot-3.jpg', '8000', '2019-02-19 00:00:00', '500', '1', NULL, '2');

INSERT INTO `lots` (`id`, `date_create`, `title`, `description`, `image`, `start_price`, `date_finish`, `step`, `author_id`, `win_id`, `category_id`)
VALUES (NULL, CURRENT_TIMESTAMP, 'Ботинки для сноуборда DC Mutiny Charocal', NULL, 'img/lot-4.jpg', '10999', '2019-02-20 00:00:00', '500', '2', NULL, '3');

INSERT INTO `lots` (`id`, `date_create`, `title`, `description`, `image`, `start_price`, `date_finish`, `step`, `author_id`, `win_id`, `category_id`)
VALUES (NULL, CURRENT_TIMESTAMP, 'Куртка для сноуборда DC Mutiny Charocal', NULL, 'img/lot-5.jpg', '7500', '2019-02-15 00:00:00', '100', '2', NULL, '4');

INSERT INTO `lots` (`id`, `date_create`, `title`, `description`, `image`, `start_price`, `date_finish`, `step`, `author_id`, `win_id`, `category_id`)
VALUES (NULL, CURRENT_TIMESTAMP, 'Маска Oakley Canopy', NULL, 'img/lot-6.jpg', '5400', '2019-02-16 00:00:00', '100', '1', NULL, '6');

INSERT INTO `rates` (`id`, `date_add`, `amount`, `user_id`, `lot_id`) VALUES (NULL, CURRENT_TIMESTAMP, '12000', '1', '1');

INSERT INTO `rates` (`id`, `date_add`, `amount`, `user_id`, `lot_id`) VALUES (NULL, CURRENT_TIMESTAMP, '12500', '2', '1');


# получить все категории;
SELECT name FROM categories;

# получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;
SELECT date_create, title, image, start_price, categories.name
FROM lots JOIN categories ON categories.id = lots.category_id;

# показать лот по его id. Получите также название категории, к которой принадлежит лот;
SELECT title, image, start_price, categories.name
FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = 2;

# обновить название лота по его идентификатору;
UPDATE lots SET title = '2014 Rossignol District Snowboard' WHERE id = 1;

# получить список самых свежих ставок для лота по его идентификатору;
SELECT * FROM rates WHERE lot_id = 1 ORDER BY date_add DESC;