CREATE DATABASE IF NOT EXISTS `yeticave` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yeticave`;

CREATE TABLE `categories` (
                            `id` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lots` (
                      `id` int(11) NOT NULL,
                      `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      `title` varchar(255) NOT NULL,
                      `description` text NOT NULL,
                      `image` text NOT NULL,
                      `start_price` decimal(10,0) NOT NULL,
                      `date_finish` timestamp NOT NULL,
                      `step` decimal(10,0) NOT NULL,
                      `author_id` int(11) NOT NULL,
                      `win_id` int(11) DEFAULT NULL,
                      `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rates` (
                       `id` int(11) NOT NULL,
                       `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       `amount` decimal(10,0) NOT NULL,
                       `user_id` int(11) NOT NULL,
                       `lot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
                       `id` int(11) NOT NULL,
                       `date_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                       `email` varchar(255) NOT NULL,
                       `name` varchar(255) NOT NULL,
                       `password` varchar(255) NOT NULL,
                       `avatar` text,
                       `contact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_category` (`name`);

ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_create` (`date_create`),
  ADD KEY `title` (`title`),
  ADD KEY `price` (`start_price`),
  ADD KEY `date_finish` (`date_finish`);
ALTER TABLE `lots` ADD FULLTEXT KEY `description` (`description`);

ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `date_reg` (`date_reg`),
  ADD KEY `name` (`name`);


ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `lots` ADD FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `lots` ADD FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `lots` ADD FOREIGN KEY (`win_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `rates` ADD FOREIGN KEY (`lot_id`) REFERENCES `lots`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `rates` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `yeticave`.`lots` DROP INDEX `description`, ADD FULLTEXT `description` (`description`);
ALTER TABLE `yeticave`.`lots` DROP INDEX `title`, ADD FULLTEXT `title` (`title`);
ALTER TABLE `yeticave`.`lots` DROP INDEX `search`, ADD FULLTEXT `search` (`title`, `description`);