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
--     log
--         id
--         roll
--         wm_id
--         date
--         time
--         dur
--         booktime
    
CREATE TABLE `hmanwm`.`wm` (`id` INT(5) NOT NULL COMMENT 'XXYZZ | X-Hostel Y-Wing Z-Floor' , `hn` VARCHAR(3) NOT NULL COMMENT 'XXY | X-Hostel Y-Wing' , `floor` INT(2) NOT NULL , `working` BOOLEAN NOT NULL DEFAULT TRUE , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `wm` ADD `type` CHAR(1) NOT NULL DEFAULT 'W' AFTER `working`;
CREATE TABLE `hmanwm`.`user` (`roll` VARCHAR(7) NOT NULL , `name` CHAR(255) NOT NULL , `contact` INT(10) NOT NULL , `hn` VARCHAR(3) NOT NULL COMMENT 'XXY | X-Hostel Y-Wing' , `rn` INT(4) NOT NULL , `dept` INT(2) NOT NULL , PRIMARY KEY (`roll`)) ENGINE = InnoDB;
CREATE TABLE `hmanwm`.`log` (`id` INT NOT NULL AUTO_INCREMENT , `roll` VARCHAR(7) NOT NULL , `wm_id` INT(5) NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , `dur` INT(3) NOT NULL COMMENT 'XYY | X-hrs Y-min' , `booktime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
