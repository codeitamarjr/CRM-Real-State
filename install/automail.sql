CREATE TABLE `automail` (
  `automail_id` int NOT NULL AUTO_INCREMENT,
  `automail_title` varchar(255) DEFAULT NULL,
  `automail_message` longtext,
  `prs_code` varchar(45) DEFAULT NULL,
  `automail_autosender` varchar(45) DEFAULT NULL,
  `automail_website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`automail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;