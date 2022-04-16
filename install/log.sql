CREATE TABLE `log` (
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `property_code` int NOT NULL,
  `status` tinyint NOT NULL,
  `source` varchar(45) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;