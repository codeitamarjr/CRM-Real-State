CREATE TABLE `agent` (
  `agent_id` int NOT NULL AUTO_INCREMENT,
  `agent_prs_code` varchar(45) DEFAULT NULL,
  `agent_email` varchar(255) NOT NULL,
  `agent_name` varchar(45) NOT NULL,
  `agent_password` varchar(255) NOT NULL,
  `agent_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `agent_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`agent_id`,`agent_email`),
  KEY `prs_code_idx` (`agent_prs_code`),
  CONSTRAINT `agent_prs_code` FOREIGN KEY (`agent_prs_code`) REFERENCES `prs` (`prs_code`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;