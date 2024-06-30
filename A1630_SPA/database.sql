DROP TABLE `Admin_Users`, `cards`, `Item`, `Orders`, `PromoCode`, `Reviews`, `Shopping`, `Trip`, `Truck`, `Users`;
CREATE TABLE Truck (
    Truck_Id INT AUTO_INCREMENT,
    Truck_Code VARCHAR(20) UNIQUE,
    Availability_Code Boolean,
    PRIMARY KEY (Truck_Id)
);

CREATE TABLE Users (
    User_Id INT AUTO_INCREMENT,
    Name VARCHAR(50) DEFAULT 'N/A',
    Tel_No VARCHAR(20) NOT NULL,
    Email VARCHAR(50) UNIQUE,
    Address VARCHAR(100) NOT NULL,  
    City_Code VARCHAR(10),                          
    Login_Id VARCHAR(50) UNIQUE,
    Passwords VARCHAR(100) NOT NULL,
    Balance DECIMAL(10,2) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    PRIMARY KEY (User_Id)
);

CREATE TABLE Shopping (
    Receipt_Id INT AUTO_INCREMENT,
    Store_Code VARCHAR(300) NOT NULL,
    User_Id INT NOT NULL,
    Total_Price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (Receipt_Id),
    FOREIGN KEY (User_Id) REFERENCES Users(User_Id)
);

CREATE TABLE Item (
    Item_Id INT NOT NULL AUTO_INCREMENT,
    Item_Name VARCHAR(50) NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    Made_In VARCHAR(50),
    Department_Code INT NOT NULL,
    PictureURL VARCHAR(100),
    PRIMARY KEY (Item_Id)
);

CREATE TABLE Trip (
    Trip_Id INT AUTO_INCREMENT,
    Source_Code VARCHAR(300) NOT NULL,
    Destination_Code VARCHAR(300) NOT NULL,
    Distance_KM INT NOT NULL,
    Truck_Code VARCHAR(20) NOT NULL,
    Price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (Trip_Id),
    FOREIGN KEY (Truck_Code) REFERENCES Truck(Truck_Code)
);

CREATE TABLE Orders (
    Order_Id INT AUTO_INCREMENT,
    Date_Issued DATE NOT NULL,
    Date_Received DATE,
    Total_Price DECIMAL(10,2) NOT NULL,
    User_Id INT NOT NULL,
    Receipt_Id INT NOT NULL,
    PRIMARY KEY (Order_Id),
    FOREIGN KEY (User_Id) REFERENCES Users(User_Id),
    FOREIGN KEY (Receipt_Id) REFERENCES Shopping(Receipt_Id)
);

CREATE TABLE Admin_Users (
    Admin_Id INT AUTO_INCREMENT,
    Name VARCHAR(50) DEFAULT 'N/A',         
    Login_Id VARCHAR(50) UNIQUE,
    Passwords VARCHAR(100) NOT NULL,
    salt VARCHAR(100) NOT NULL,
    PRIMARY KEY (Admin_Id)
);

CREATE TABLE PromoCode (
    promocodes VARCHAR(50),
    used Boolean NOT NULL,
    PRIMARY KEY (promocodes)
);

CREATE TABLE Reviews (
    Review_Id INT PRIMARY KEY AUTO_INCREMENT,
    ServiceRating INT NOT NULL,
    Review VARCHAR(500),
    RN INT NOT NULL,
    Item_Id INT,
    User_Id INT NOT NULL,
    FOREIGN KEY (Item_Id) REFERENCES Item(Item_Id),
    FOREIGN KEY (User_Id) REFERENCES Users(User_Id)
);

CREATE TABLE cards (
    card_id INT AUTO_INCREMENT,
    card_number VARCHAR(100) NOT NULL,
    security_code VARCHAR(50) NOT NULL,
    expiry_date VARCHAR(50) NOT NULL,
    balance_take VARCHAR(50) NOT NULL,
    PRIMARY KEY (card_id),
    User_Id INT NOT NULL,
    FOREIGN KEY (User_Id) REFERENCES Users(User_Id)
);

INSERT INTO PromoCode (promocodes, used) VALUES ("TJXP", false);

INSERT INTO Item (Item_Name, Price, Made_In, Department_Code, PictureURL)VALUES("Jordan 1 Pine Green", 500, "China", 1001, "images/aj1_pine_green.jpg");
INSERT INTO Item (Item_Name, Price, Made_In, Department_Code, PictureURL)VALUES("Jordan 1 Travis White", 1500, "America", 1001, "images/aj1_travis_white.jpg");
INSERT INTO Item (Item_Name, Price, Made_In, Department_Code, PictureURL)VALUES("Jordan 4 Pure Money", 940, "China", 1001, "images/aj4_pure_money.jpg");
INSERT INTO Item (Item_Name, Price, Made_In, Department_Code, PictureURL)VALUES("Jordan 6 Travis", 500, "America", 1001, "images/aj6_travis.jpg");
INSERT INTO Item (Item_Name, Price, Made_In, Department_Code, PictureURL)VALUES("Jordan 12 OVO", 2200, "Canada", 1001, "images/aj12_ovo.jpg");
INSERT INTO Item (Item_Name, Price, Made_In, Department_Code, PictureURL)VALUES("Panda Dunks", 100, "China", 1001, "images/panda_dunks.jpg");


INSERT INTO Truck (Truck_Code, Availability_Code) VALUES(555, true);
INSERT INTO Truck (Truck_Code, Availability_Code) VALUES(554, false);
INSERT INTO Truck (Truck_Code, Availability_Code) VALUES(5559, true);
INSERT INTO Truck (Truck_Code, Availability_Code) VALUES(5553, false);

INSERT INTO Admin_Users (Name, Login_Id, Passwords, salt) VALUES ("Anant Jawanda", "admin", "76ccbe46586d7cae986a7d47abc7457f", "czQzCaXxOgMDVB/k");

INSERT INTO Users (Name, Tel_No, Email, Address, City_Code, Login_Id, Passwords, Balance, salt) VALUES ("Simardeep Kullar", "6472943330", "simardeep.kullar@torontomu.ca", "5 Matagami St., Brampton", "L6Y0M9", "s3kullar", "76ccbe46586d7cae986a7d47abc7457f", 0,"czQzCaXxOgMDVB/k");
INSERT INTO Users (Name, Tel_No, Email, Address, City_Code, Login_Id, Passwords, Balance, salt) VALUES ("Harman Dhaliwal", "6472867600", "harman@torontomu.ca", "3019 Churchill Avenue Mississauga", "L4T1R4", "h5dhaliw", "76ccbe46586d7cae986a7d47abc7457f", 0,"czQzCaXxOgMDVB/k");
INSERT INTO Users (Name, Tel_No, Email, Address, City_Code, Login_Id, Passwords, Balance, salt) VALUES ("Jaskeerat Chani", "6472867677", "bigmanj@torontomu.ca", "333 Airport road Mississauga", "L4T1R4", "j249sing", "76ccbe46586d7cae986a7d47abc7457f", 0,"czQzCaXxOgMDVB/k");

INSERT INTO Reviews (ServiceRating, Review, RN, Item_Id, User_Id) VALUES (4, "This is a great product", 5, 1, 1);
INSERT INTO Reviews (ServiceRating, Review, RN, Item_Id, User_Id) VALUES (5, "Very easy to use website!", 4, 2, 3);