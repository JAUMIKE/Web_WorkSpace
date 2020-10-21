use Mask;

CREATE TABLE if not exists `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `rights` tinyint(3) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`account`, `password`, `rights`) VALUES ( 'admin', 'admin', 1 );


