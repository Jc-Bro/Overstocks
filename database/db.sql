drop database if exists db_overstocks;
create database db_overstocks;
use db_overstocks;

drop table if exists user;
create table user (
    id_user int auto_increment primary key,
    nameOfUser varchar(100),
    firstNameOfUser varchar(100),
    emailOfUser varchar(100) UNIQUE,
    passwordHash varchar(255),
    phoneOfUser varchar(20),
    addressOfUser varchar(255),
    townOfUser varchar(100),
    postalCodeOfUser varchar(10),
    typeOfUser enum('professionnel', 'particulier'),
    siretOfUser varchar(14)  -- Ne sera rempli que pour les professionnels
);

drop table if exists product;
create table product (
    id_product int auto_increment primary key,
    pictureOfProduct varchar(255),  -- Chemin du fichier ou URL de l'image
    nameOfProduct varchar(100),
    descriptionOfProduct varchar(255),
    categoryOfProduct enum('matière première', 'mobilier', 'electronique', 'textile', 'mécanique'),
    stockOfProduct INT,
    sizeOfProduct enum('S', 'M', 'L', 'XL'),  -- Seulement pour les textiles
    dimensionOfProcut varchar(50)  -- Format "longueur x largeur x hauteur"
);

drop table if exists subscription;
create table subscription (
    id_subscription int auto_increment primary key,
    styleOfSubscription enum('overprime', 'overprime plus'),
    costOfSubscription decimal(5,2),  -- Prix en euros
    commissionOfSubscription decimal(5,2),
    max_product int
);

drop table if exists hamper;
create table hamper (
    id int auto_increment primary key,
    user_id int,
    product_id int,
    quantity int,
    foreign key (user_id) references user(id_user),
    foreign key (product_id) references product(id_product)
);

drop table if exists payment;
create table payment (
    id int auto_increment primary key,
    user_id int,
    moyen varchar(50),
    montant decimal(10,2),
    foreign key (user_id) references user(id_user)
);

-- Relation entre user et product --
alter table product add column user_id int;
alter table product add foreign key (user_id) references user(id_user);

-- relation entre user et subscription --
alter table user add column subscription_id int;
alter table user add foreign key (subscription_id) references subscription(id_subscription);


select * from user
