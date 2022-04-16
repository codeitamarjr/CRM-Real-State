CREATE TABLE `prs` (
  `prs_code` varchar(45) NOT NULL,
  `prs_client` varchar(45) DEFAULT NULL,
  `prs_name` varchar(45) NOT NULL,
  `prs_email` varchar(255) DEFAULT NULL,
  `prs_full_address` varchar(255) DEFAULT NULL,
  `prs_phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`prs_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;