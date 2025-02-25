
CREATE DATABASE IF NOT EXISTS `YOUR_DATABASE_NAME`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- DATABASE TABLE :: `stores`
-- It contains the data about the stores on which our app has installed.
-- store_name :: name of store 
-- token :: access token of store, used for making API calls to the shopify for that perticular store 
-- disflag :: disable flag, used for showing the status of store, {0 : active|not disabled, 1 : inactive|disabled}

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `store_name` varchar(250) DEFAULT NULL,
  `token` varchar(250) DEFAULT NULL,
  `disflag` int(1) DEFAULT 0,
  `createdon` timestamp NULL DEFAULT current_timestamp(),
  `updatedon` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `stores` 
  ADD `host` VARCHAR(100) 
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci 
  NULL DEFAULT NULL 
  AFTER `store_name`;