CREATE TABLE `property` (
  `property_code` int NOT NULL AUTO_INCREMENT,
  `property_type` varchar(45) DEFAULT NULL,
  `property_units` varchar(45) DEFAULT NULL,
  `property_name` varchar(45) DEFAULT NULL,
  `property_address` varchar(255) DEFAULT NULL,
  `property_prs_code` varchar(45) DEFAULT NULL,
  `property_email_hostname` varchar(45) DEFAULT NULL,
  `property_email_username` varchar(45) DEFAULT NULL,
  `property_email_password` varchar(45) DEFAULT NULL,
  `property_calendly` varchar(255) DEFAULT NULL,
  `automail_new` tinyint DEFAULT NULL,
  `automail_approved` tinyint DEFAULT NULL,
  `automail_denied` tinyint DEFAULT NULL,
  `getting_email_time` int DEFAULT NULL,
  PRIMARY KEY (`property_code`),
  KEY `property_prs_code_idx` (`property_prs_code`),
  CONSTRAINT `property_prs_code` FOREIGN KEY (`property_prs_code`) REFERENCES `prs` (`prs_code`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;