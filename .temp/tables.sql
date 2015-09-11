DROP TABLE IF EXISTS `adress`;
CREATE TABLE `adress` (
  `ip` text,
  `date` text,
  `uri` text,
  `agent` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` text NOT NULL,
  `name` text NOT NULL,
  `mail` text NOT NULL,
  `date` datetime NOT NULL,
  `ip` text NOT NULL,
  `state` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `mail` text NOT NULL,
  `hash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;