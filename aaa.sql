CREATE TABLE Product (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  description TEXT,
  image VARCHAR(255),
  price DECIMAL(10,2),
  created_at DATETIME,
  updated_at DATETIME
);

CREATE TABLE Users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255),
  username VARCHAR(255),
  password VARCHAR(255),
  created_at DATETIME,
  updated_at DATETIME
);
