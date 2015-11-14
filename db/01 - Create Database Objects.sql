CREATE DATABASE IF NOT EXISTS weatherb_465
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

USE weatherb_465;

CREATE TABLE IF NOT EXISTS User (
	ID BIGINT NOT NULL AUTO_INCREMENT,
    First_Name VARCHAR(100) NOT NULL,
    Last_Name VARCHAR(100) NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    `Password` CHAR(255) NOT NULL,
	Temperature_Unit VARCHAR(1) NOT NULL DEFAULT 'F',
	Time_Format VARCHAR(2) NOT NULL DEFAULT '12',
	Home_Screen VARCHAR(50) NOT NULL DEFAULT 'Today'
    Created_On DATETIME NULL,
    Modified_On DATETIME NULL,
    PRIMARY KEY (ID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Feel (
	ID BIGINT NOT NULL AUTO_INCREMENT,
    User_ID BIGINT NOT NULL,
    Min_Temperature_C INT NULL,
    Max_Temperature_C INT NULL,
    Min_Temperature_F INT NULL,
    Max_Temperature_F INT NULL,
    Description VARCHAR(50) NULL,
    Bring_Wear VARCHAR(255) NULL,
    Created_On DATETIME NULL,
    Modified_On DATETIME NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (User_ID) REFERENCES User (ID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Schedule (
	ID BIGINT NOT NULL AUTO_INCREMENT,
    User_ID BIGINT NOT NULL,
	Monday TINYINT(1) NOT NULL DEFAULT 0,
	Tuesday TINYINT(1) NOT NULL DEFAULT 0,
	Wednesday TINYINT(1) NOT NULL DEFAULT 0,
	Thursday TINYINT(1) NOT NULL DEFAULT 0,
	Friday TINYINT(1) NOT NULL DEFAULT 0,
	Saturday TINYINT(1) NOT NULL DEFAULT 0,
	Sunday TINYINT(1) NOT NULL DEFAULT 0,
    Start_Time TIME NULL,
    End_Time TIME NULL,
    Created_On DATETIME NULL,
    Modified_On DATETIME NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (User_ID) REFERENCES User (ID)
) ENGINE=InnoDB;
