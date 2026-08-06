-- hmanwm
--     wm
--         id
--         hn
--         floor
--         working
--         type

--     user
--         roll
--         name
--         contact
--         hn
--         rn
--         dept 
--         credits
--         pass
--     log
--         id
--         roll
--         wm_id
--         date
--         time
--         booktime
    
CREATE TABLE `hmanwm`.`wm` (`id` INT(5) NOT NULL COMMENT 'XXYZZ | X-Hostel Y-Wing Z-Floor' , `hn` VARCHAR(3) NOT NULL COMMENT 'XXY | X-Hostel Y-Wing' , `floor` INT(2) NOT NULL , `working` BOOLEAN NOT NULL DEFAULT TRUE , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `wm` ADD `type` CHAR(1) NOT NULL DEFAULT 'W' AFTER `working`;
ALTER TABLE `user` ADD `credits` INT(1) NOT N0ULL DEFAULT '2' AFTER `dept`;
CREATE TABLE `hmanwm`.`user` (`roll` VARCHAR(7) NOT NULL , `name` CHAR(255) NOT NULL , `contact` INT(10) NOT NULL , `hn` VARCHAR(3) NOT NULL COMMENT 'XXY | X-Hostel Y-Wing' , `rn` INT(4) NOT NULL , `dept` INT(2) NOT NULL , PRIMARY KEY (`roll`)) ENGINE = InnoDB;
CREATE TABLE `hmanwm`.`log` (`id` INT NOT NULL AUTO_INCREMENT , `roll` VARCHAR(7) NOT NULL , `wm_id` INT(5) NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , `dur` INT(3) NOT NULL COMMENT 'XYY | X-hrs Y-min' , `booktime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `log` DROP `dur`;
ALTER TABLE `user` ADD `pass` VARCHAR(255) NOT NULL AFTER `credits`;
ALTER TABLE `log` ADD `name` VARCHAR(255) NOT NULL AFTER `booktime`;
ALTER TABLE `log` CHANGE `time` `time` DATETIME NOT NULL;
ALTER TABLE `log` DROP `date`;
ALTER TABLE `wm` CHANGE `id` `id` INT(6) NOT NULL COMMENT 'XXYZZT | X-Hostel Y-Wing Z-Floor T - Type (1 - Washer, 2 - Dryer)';
ALTER TABLE `wm` DROP `hn`;
ALTER TABLE `wm` DROP `floor`;
ALTER TABLE `wm` DROP `type`;
ALTER TABLE `log` CHANGE `wm_id` `wm_id` INT(6) NOT NULL;
ALTER TABLE `log` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `name`;
ALTER TABLE `log` CHANGE `name` `iden` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Name (ZZZZ) : ZZZZ : Room Number';








INSERT INTO `wm` (`wm_id`, `working`) VALUES ('161021', '1'), ('161041', '0'), ('161061', '1'), ('161081', '1'), ('161101', '1'), ('161022', '1');