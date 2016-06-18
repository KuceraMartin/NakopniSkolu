SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `school_id` int(11) NOT NULL,
  `funded` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(55) NOT NULL,
  `email` varchar(200) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(60) NOT NULL,
  `phone` varchar(55) NOT NULL,
  `website` varchar(55) NOT NULL,
  `region_id` int(11) NOT NULL,
  `address` varchar(55) NOT NULL,
  `city` varchar(55) NOT NULL,
  `zip` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `projects`
ADD PRIMARY KEY (`id`),
ADD KEY `school_id` (`school_id`);

ALTER TABLE `reservations`
ADD PRIMARY KEY (`id`),
ADD KEY `project_id` (`project_id`);

ALTER TABLE `schools`
ADD PRIMARY KEY (`id`);

ALTER TABLE `subscriptions`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `projects`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `reservations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `schools`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `subscriptions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `projects`
ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`);

ALTER TABLE `reservations`
ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);
