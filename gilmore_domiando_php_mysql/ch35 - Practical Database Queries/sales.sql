CREATE TABLE sales (
   id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
   client_id SMALLINT UNSIGNED NOT NULL,
   order_time TIMESTAMP NOT NULL,
   sub_total DECIMAL(8,2) NOT NULL,
   shipping_cost DECIMAL(8,2) NOT NULL,
   total_cost DECIMAL(8,2) NOT NULL,
   PRIMARY KEY(id)
);
