CREATE  TABLE `social`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) );

INSERT INTO `social`.`users` (`name`) VALUES ('John'),('Bob'),('Paul') ;
