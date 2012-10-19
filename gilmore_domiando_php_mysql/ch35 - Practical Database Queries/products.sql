CREATE TABLE products (
   id INT NOT NULL AUTO_INCREMENT,
   product_id VARCHAR(8) NOT NULL,
   name VARCHAR(25) NOT NULL,
   price DECIMAL(5,2) NOT NULL,
   description MEDIUMTEXT NOT NULL,
   PRIMARY KEY(id)
);
