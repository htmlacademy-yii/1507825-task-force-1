CREATE TABLE `user`
(
    `id`              int PRIMARY KEY AUTO_INCREMENT,
    `email`           varchar(255) UNIQUE NOT NULL,
    `first_name`      varchar(255)        NOT NULL,
    `last_name`       varchar(255)        NOT NULL,
    `user_role`       int                 NOT NULL,
    `password`        varchar(255)        NOT NULL,
    `created_at`      datetime            NOT NULL DEFAULT (now()),
    `last_active`     datetime            NOT NULL DEFAULT (now()),
    `rating`          float               NOT NULL DEFAULT 0,
    `biography`       text,
    `avatar`          int,
    `date_of_birth`   datetime            NOT NULL,
    `city`            int,
    `phone`           int,
    `skype`           int,
    `telegram`        int,
    `show_for_client` boolean                      DEFAULT true,
    `show`            boolean                      DEFAULT true
);

CREATE TABLE `user_contact_type`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

CREATE TABLE `user_contact`
(
    `id`    int PRIMARY KEY AUTO_INCREMENT,
    `type`  int          NOT NULL,
    `value` varchar(255) NOT NULL
);

CREATE TABLE `user_role`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) UNIQUE NOT NULL
);

CREATE TABLE `task`
(
    `id`          int PRIMARY KEY AUTO_INCREMENT,
    `title`       varchar(255) NOT NULL,
    `description` text,
    `budget`      float        NOT NULL,
    `date`        date         NOT NULL,
    `latitute`    float,
    `longitute`   float,
    `status`      int          NOT NULL,
    `category`    int          NOT NULL,
    `city`        int,
    `client`      int          NOT NULL,
    `executor`    int,
    `created_at`  datetime     NOT NULL DEFAULT (now())
);

CREATE TABLE `task_status`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) UNIQUE NOT NULL
);

CREATE TABLE `category`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) UNIQUE NOT NULL
);

CREATE TABLE `city`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

CREATE TABLE `user_category`
(
    `id`       int PRIMARY KEY AUTO_INCREMENT,
    `user`     int NOT NULL,
    `category` int NOT NULL
);

CREATE TABLE `answer`
(
    `id`          int PRIMARY KEY AUTO_INCREMENT,
    `user`        int      NOT NULL,
    `description` text,
    `budget`      float    NOT NULL,
    `task`        int      NOT NULL,
    `created_at`  datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `notification`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT,
    `created_at` datetime NOT NULL DEFAULT (now()),
    `executed`   boolean  NOT NULL DEFAULT false,
    `type`       int      NOT NULL,
    `text`       text     NOT NULL,
    `recipient`  int      NOT NULL
);

CREATE TABLE `notification_type`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

CREATE TABLE `user_notification`
(
    `id`    int PRIMARY KEY AUTO_INCREMENT,
    `user`  int     NOT NULL,
    `type`  int     NOT NULL,
    `is_on` boolean NOT NULL DEFAULT false
);

CREATE TABLE `message`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT,
    `user`       int      NOT NULL,
    `task`       int      NOT NULL,
    `text`       text     NOT NULL,
    `created_at` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `file`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `path` varchar(255) NOT NULL
);

CREATE TABLE `task_file`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `task` int NOT NULL,
    `file` int NOT NULL
);

CREATE TABLE `user_file`
(
    `id`   int PRIMARY KEY AUTO_INCREMENT,
    `user` int NOT NULL,
    `file` int NOT NULL
);

CREATE TABLE `feedback`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT,
    `text`       text     NOT NULL,
    `grade`      int      NOT NULL DEFAULT 3,
    `created_at` datetime NOT NULL DEFAULT (now()),
    `task`       int      NOT NULL,
    `user`       int      NOT NULL
);

CREATE TABLE `favorite_user`
(
    `id`    int PRIMARY KEY AUTO_INCREMENT,
    `user`  int NOT NULL,
    `owner` int NOT NULL
);

ALTER TABLE `user_contact`
    ADD FOREIGN KEY (`type`) REFERENCES `user_contact_type` (`id`);

ALTER TABLE `user`
    ADD FOREIGN KEY (`phone`) REFERENCES `user_contact` (`id`);

ALTER TABLE `user`
    ADD FOREIGN KEY (`skype`) REFERENCES `user_contact` (`id`);

ALTER TABLE `user`
    ADD FOREIGN KEY (`telegram`) REFERENCES `user_contact` (`id`);

ALTER TABLE `user`
    ADD FOREIGN KEY (`user_role`) REFERENCES `user_role` (`id`);

ALTER TABLE `task`
    ADD FOREIGN KEY (`client`) REFERENCES `user` (`id`);

ALTER TABLE `task`
    ADD FOREIGN KEY (`executor`) REFERENCES `user` (`id`);

ALTER TABLE `task`
    ADD FOREIGN KEY (`status`) REFERENCES `task_status` (`id`);

ALTER TABLE `task`
    ADD FOREIGN KEY (`category`) REFERENCES `category` (`id`);

ALTER TABLE `task`
    ADD FOREIGN KEY (`city`) REFERENCES `city` (`id`);

ALTER TABLE `user_category`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `user_category`
    ADD FOREIGN KEY (`category`) REFERENCES `category` (`id`);

ALTER TABLE `user`
    ADD FOREIGN KEY (`city`) REFERENCES `city` (`id`);

ALTER TABLE `answer`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `answer`
    ADD FOREIGN KEY (`task`) REFERENCES `task` (`id`);

ALTER TABLE `notification`
    ADD FOREIGN KEY (`type`) REFERENCES `notification_type` (`id`);

ALTER TABLE `notification`
    ADD FOREIGN KEY (`recipient`) REFERENCES `user` (`id`);

ALTER TABLE `user_notification`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `user_notification`
    ADD FOREIGN KEY (`type`) REFERENCES `notification_type` (`id`);

ALTER TABLE `message`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `message`
    ADD FOREIGN KEY (`task`) REFERENCES `task` (`id`);

ALTER TABLE `user`
    ADD FOREIGN KEY (`avatar`) REFERENCES `file` (`id`);

ALTER TABLE `task_file`
    ADD FOREIGN KEY (`task`) REFERENCES `task` (`id`);

ALTER TABLE `task_file`
    ADD FOREIGN KEY (`file`) REFERENCES `file` (`id`);

ALTER TABLE `user_file`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `user_file`
    ADD FOREIGN KEY (`file`) REFERENCES `file` (`id`);

ALTER TABLE `feedback`
    ADD FOREIGN KEY (`task`) REFERENCES `task` (`id`);

ALTER TABLE `feedback`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `favorite_user`
    ADD FOREIGN KEY (`user`) REFERENCES `user` (`id`);

ALTER TABLE `favorite_user`
    ADD FOREIGN KEY (`owner`) REFERENCES `user` (`id`);
