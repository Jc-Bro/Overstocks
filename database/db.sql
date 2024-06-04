drop database if exists u535044803_db_overstocks;
create database u535044803_db_overstocks;
use u535044803_db_overstocks;

drop table if exists User;
CREATE TABLE User (
                      id_user INT AUTO_INCREMENT PRIMARY KEY,
                      nameOfUser VARCHAR(20),
                      firstNameOfUser VARCHAR(20),
                      mailOfUser VARCHAR(255),
                      passwordHash VARCHAR(255),
                      phoneOfUser VARCHAR(10),
                      addressOfUser VARCHAR(255),
                      townOfUser VARCHAR(100),
                      postalCodeOfUser VARCHAR(10),
                      typeOfUser ENUM('particulier', 'professionnel')
);


-- Table Seller
drop table if exists Seller;
CREATE TABLE Seller (
                        id_seller INT AUTO_INCREMENT PRIMARY KEY,
                        id_user INT,
                        siret INT,
                        FOREIGN KEY (id_user) REFERENCES User(id_user)
);

-- Table Subscription
drop table if exists Subscription;
CREATE TABLE Subscription (
                              id_subscription INT AUTO_INCREMENT PRIMARY KEY,
                              styleOfSubscription ENUM('OverBasics', 'OverPrime', 'UltraPrime'),
                              costOfSubscription INT,
                              commissionOfSubscription DECIMAL(10, 2),
                              numberOfSales INT
);

-- Table Cart
drop table if exists Cart;
CREATE TABLE Cart (
                      id_cart INT AUTO_INCREMENT PRIMARY KEY,
                      id_user INT,
                      costOfPayment DECIMAL(10, 2),
                      contentOfCart TEXT,
                      FOREIGN KEY (id_user) REFERENCES User(id_user)
);

-- Table Product
DROP TABLE IF EXISTS Product;
CREATE TABLE Product (
                         id_product INT AUTO_INCREMENT PRIMARY KEY,
                         productName VARCHAR(255) NOT NULL,
                         productImage BLOB NOT NULL,
                         productDescription TEXT NOT NULL,
                         productCategory ENUM('mobilier', 'éléctronique', 'matières premières', 'textile', 'mécanique', 'autres') NOT NULL,
                         productStock INT DEFAULT 0,
                         productSize VARCHAR(50),
                         productDimensions VARCHAR(50)
);

-- Table ProductFromSeller
drop table if exists ProductFromSeller;
CREATE TABLE ProductFromSeller (
                                   id_product INT,
                                   id_seller INT,
                                   cost DECIMAL(10, 2),
                                   PRIMARY KEY (id_product, id_seller),
                                   FOREIGN KEY (id_product) REFERENCES Product(id_product),
                                   FOREIGN KEY (id_seller) REFERENCES Seller(id_seller)
);

-- Table Payment
drop table if exists Payment;
CREATE TABLE Payment (
                         id_payment INT AUTO_INCREMENT PRIMARY KEY,
                         id_user INT,
                         meansOfPayments ENUM('carte bancaire', 'paypal'),
                         FOREIGN KEY (id_user) REFERENCES User(id_user)
);

-- Association Seller to Subscription (one-to-many)
ALTER TABLE Seller
    ADD COLUMN id_subscription INT,
    ADD FOREIGN KEY (id_subscription) REFERENCES Subscription(id_subscription);

-- Association Cart to ProductFromSeller (many-to-many)
drop table if exists CartProduct;
CREATE TABLE CartProduct (
                             id_cart INT,
                             id_product INT,
                             id_seller INT,
                             PRIMARY KEY (id_cart, id_product, id_seller),
                             FOREIGN KEY (id_cart) REFERENCES Cart(id_cart),
                             FOREIGN KEY (id_product) REFERENCES Product(id_product),
                             FOREIGN KEY (id_seller) REFERENCES Seller(id_seller)
);

-- Table de tests
CREATE TABLE Test (
    id_test INT
);

SELECT * FROM User;
SELECT * FROM Product
