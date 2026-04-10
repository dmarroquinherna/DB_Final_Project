SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Final_Project
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Final_Project` DEFAULT CHARACTER SET utf8;
USE `Final_Project`;

-- -----------------------------------------------------
-- Table `Final_Project`.`Memberships`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Memberships` (
  `membership_id` INT NOT NULL AUTO_INCREMENT,
  `membership_type` VARCHAR(45) NULL,
  `status` VARCHAR(20) NULL,
  `price` DECIMAL(10,2) NULL,
  PRIMARY KEY (`membership_id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Clients` (
  `client_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email` VARCHAR(100) NULL,
  `street` VARCHAR(100) NULL,
  `city` VARCHAR(45) NULL,
  `state` CHAR(2) NULL,
  `zip` VARCHAR(10) NULL,
  `country` VARCHAR(45) NULL,
  `Memberships_membership_id` INT NOT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_Clients_Memberships_idx` (`Memberships_membership_id` ASC),
  CONSTRAINT `fk_Clients_Memberships`
    FOREIGN KEY (`Memberships_membership_id`)
    REFERENCES `Final_Project`.`Memberships` (`membership_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Employees`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Employees` (
  `employee_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `position` VARCHAR(45) NULL,
  `hire_date` DATE NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Classes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Classes` (
  `class_id` INT NOT NULL AUTO_INCREMENT,
  `class_name` VARCHAR(45) NULL,
  `schedule_time` DATETIME NULL,
  `Employees_employee_id` INT NOT NULL,
  PRIMARY KEY (`class_id`),
  INDEX `fk_Classes_Employees1_idx` (`Employees_employee_id` ASC),
  CONSTRAINT `fk_Classes_Employees1`
    FOREIGN KEY (`Employees_employee_id`)
    REFERENCES `Final_Project`.`Employees` (`employee_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Class_Registrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Class_Registrations` (
  `registration_id` INT NOT NULL AUTO_INCREMENT,
  `Clients_client_id` INT NOT NULL,
  `Classes_class_id` INT NOT NULL,
  PRIMARY KEY (`registration_id`),
  INDEX `fk_Class_Registrations_Clients1_idx` (`Clients_client_id` ASC),
  INDEX `fk_Class_Registrations_Classes1_idx` (`Classes_class_id` ASC),
  CONSTRAINT `fk_Class_Registrations_Clients1`
    FOREIGN KEY (`Clients_client_id`)
    REFERENCES `Final_Project`.`Clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Class_Registrations_Classes1`
    FOREIGN KEY (`Classes_class_id`)
    REFERENCES `Final_Project`.`Classes` (`class_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Invoices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Invoices` (
  `invoice_id` INT NOT NULL AUTO_INCREMENT,
  `payment_date` DATE NULL,
  `total_amount` DECIMAL(10,2) NULL,
  `Clients_client_id` INT NOT NULL,
  PRIMARY KEY (`invoice_id`),
  INDEX `fk_Invoices_Clients1_idx` (`Clients_client_id` ASC),
  CONSTRAINT `fk_Invoices_Clients1`
    FOREIGN KEY (`Clients_client_id`)
    REFERENCES `Final_Project`.`Clients` (`client_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Nutrition_Products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Nutrition_Products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(45) NULL,
  `price` DECIMAL(10,2) NULL,
  `description` VARCHAR(255) NULL,
  `Invoices_invoice_id` INT NOT NULL,
  PRIMARY KEY (`product_id`),
  INDEX `fk_Nutrition_Products_Invoices1_idx` (`Invoices_invoice_id` ASC),
  CONSTRAINT `fk_Nutrition_Products_Invoices1`
    FOREIGN KEY (`Invoices_invoice_id`)
    REFERENCES `Final_Project`.`Invoices` (`invoice_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Final_Project`.`Equipment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Final_Project`.`Equipment` (
  `equipment_id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
  `last_maintenance_date` DATE NULL,
  `Invoices_invoice_id` INT NOT NULL,
  PRIMARY KEY (`equipment_id`),
  INDEX `fk_Equipment_Invoices1_idx` (`Invoices_invoice_id` ASC),
  CONSTRAINT `fk_Equipment_Invoices1`
    FOREIGN KEY (`Invoices_invoice_id`)
    REFERENCES `Final_Project`.`Invoices` (`invoice_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
