CREATE TABLE IF NOT EXISTS `firebase_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agent` varchar(200),
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
);

CREATE TABLE IF NOT EXISTS `notification_list` (
  `id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `sent_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO  `notification_list` (  `id` ,  `title` ) 
SELECT  `id` ,  `post_title` 
FROM  `wp_posts` 
WHERE  `post_status` =  'publish';