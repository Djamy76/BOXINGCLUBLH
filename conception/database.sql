CREATE DATABASE IF NOT EXISTS boxingclublh CHARACTER SET utf8mb4;

USE boxingclublh;

CREATE USER IF NOT EXISTS 'boxing_admin'@'localhost' IDENTIFIED BY 'boxingclublh';

GRANT ALL PRIVILEGES ON boxingclublh.* TO 'boxing_admin'@'localhost';

CREATE TABLE IF NOT EXISTS users(
   id_user INT AUTO_INCREMENT,
   role VARCHAR(50),
   firstname VARCHAR(50),
   lastname VARCHAR(50),
   birthdate DATE,
   street_number VARCHAR(5),
   street VARCHAR(150),
   postcode INT,
   city VARCHAR(50),
   email VARCHAR(50),
   phone_number VARCHAR(15),
   password VARCHAR(50),
   profil_picture MEDIUMBLOB,
   medical_certificate MEDIUMBLOB,
   PRIMARY KEY(id_user)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS shops(
   id_shop INT AUTO_INCREMENT,
   product VARCHAR(255),
   designation TEXT,
   size VARCHAR(10),
   price INT,
   PRIMARY KEY(id_shop)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS images(
   Id_image INT AUTO_INCREMENT,
   product_image MEDIUMBLOB,
   id_shop INT NOT NULL,
   PRIMARY KEY(Id_image),
   UNIQUE(id_shop),
   FOREIGN KEY(id_shop) REFERENCES shops(id_shop)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS legal_representatives(
   Id_legal_representative INT AUTO_INCREMENT,
   name_legal_repres VARCHAR(50),
   phone_legal_repres VARCHAR(15),
   id_user INT NOT NULL,
   PRIMARY KEY(Id_legal_representative),
   UNIQUE(id_user),
   FOREIGN KEY(id_user) REFERENCES users(id_user)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders(
   Id_order INT AUTO_INCREMENT,
   quantity SMALLINT,
   total_price INT,
   status VARCHAR(50),
   Total_order INT,
   order_date DATE,
   order_number INT,
   invoice_date DATE,
   invoice_number INT,
   id_user INT NOT NULL,
   PRIMARY KEY(Id_order),
   FOREIGN KEY(id_user) REFERENCES users(id_user)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS competitions(
   Id_competition INT AUTO_INCREMENT,
   competition VARCHAR(50),
   competition_category VARCHAR(50),
   sexe VARCHAR(50),
   date_ DATE,
   time_ TIME,
   PRIMARY KEY(Id_competition)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Try_classes(
   Id_Try_class INT AUTO_INCREMENT,
   class VARCHAR(50),
   class_category VARCHAR(50),
   date_ DATE,
   time_ TIME,
   PRIMARY KEY(Id_Try_class)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS competitionRegister(
   id_user INT,
   Id_competition INT,
   PRIMARY KEY(id_user, Id_competition),
   FOREIGN KEY(id_user) REFERENCES users(id_user),
   FOREIGN KEY(Id_competition) REFERENCES competitions(Id_competition)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recover(
   id_shop INT,
   id_shop_1 INT,
   Id_order INT,
   PRIMARY KEY(id_shop, id_shop_1, Id_order),
   FOREIGN KEY(id_shop) REFERENCES shops(id_shop),
   FOREIGN KEY(id_shop_1) REFERENCES shops(id_shop),
   FOREIGN KEY(Id_order) REFERENCES orders(Id_order)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tryRegister(
   id_user INT,
   Id_Try_class INT,
   PRIMARY KEY(id_user, Id_Try_class),
   FOREIGN KEY(id_user) REFERENCES users(id_user),
   FOREIGN KEY(Id_Try_class) REFERENCES Try_classes(Id_Try_class)
) ENGINE=InnoDB;

FLUSH PRIVILEGES;