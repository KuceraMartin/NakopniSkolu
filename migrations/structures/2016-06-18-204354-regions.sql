SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;