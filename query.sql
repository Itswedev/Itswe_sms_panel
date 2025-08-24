-- #Komal - 24-08-2025

CREATE TABLE `hash_config` (
  `hash_id` int(11) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `hash_value` varchar(200) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
