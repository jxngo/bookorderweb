CREATE TABLE `group4710`.`Users` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    -- AccType can only be client, admin, or staff - case sensitive
    `accounttype` VARCHAR(10) NOT NULL DEFAULT 'client',
    `email` VARCHAR(50) NOT NULL DEFAULT '',
    `username` VARCHAR(50) NOT NULL DEFAULT '',
    `password` VARCHAR(255) NOT NULL DEFAULT '',
    `firstname` VARCHAR(50) NOT NULL DEFAULT '',
    `lastname` VARCHAR(50) NOT NULL DEFAULT '',
    PRIMARY KEY ('ID'))
ENGINE = InnoDB;

insert into Users(accounttype,login,password,firstname,lastname) VALUES ('admin','root','password','first','last');