/* SQLINES DEMO *** 2025
Modified		12/07/2025
Project		
Model		
Company		
Author		
Version		
Database		MS SQL 7 
*/


-- Create database ElectroMart;

USE ElectroMart;
-- SQLINES FOR EVALUATION USE ONLY (14 DAYS)
Create table `Product` (
	`ProductID` Integer NOT NULL,
	`ProductName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`Description` Longtext NULL,
	`Price` Decimal(19,4) NOT NULL,
	`StockQuantity` Integer NOT NULL,
	`Brand`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`CreateAt` Datetime(3) NOT NULL,
	`UpdateAt` Datetime(3) NOT NULL,
	`IsActive` Tinyint Unsigned NOT NULL,
	`CategoryID` Integer NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_Product` */ Primary Key  (`ProductID`,`ShopID`)
); 

Create table `Orders` (
	`OrderID` Integer NOT NULL,
	`OrderDate` Datetime(3) NOT NULL,
	`Status` Varchar(20) NOT NULL,
	`ShippingFee` Decimal(19,4) NOT NULL,
	`TotalAmount` Decimal(19,4) NOT NULL,
	`CustomerID` Integer NOT NULL,
/* Name ignored: Constraint `pk_Orders` */ Primary Key  (`OrderID`)
); 

Create table `Customer` (
	`CustomerID` Integer NOT NULL,
	`UserID` Integer NOT NULL,
	`FullName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`Gender`  VARCHAR(5) CHARACTER SET utf8mb4 NULL,
	`BirthDate` Datetime(3) NULL,
	`LoyaltyPoint` Integer NOT NULL,
/* Name ignored: Constraint `pk_Customer` */ Primary Key  (`CustomerID`)
); 

Create table `OrderDetail` (
	`OrderID` Integer NOT NULL,
	`ProductID` Integer NOT NULL,
	`Quantity` Integer NOT NULL,
	`UnitPrice` Decimal(19,4) NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_OrderDetail` */ Primary Key  (`OrderID`,`ProductID`,`ShopID`)
); 

Create table `Shop` (
	`ShopID` Integer NOT NULL,
	`ShopName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`Email` Varchar(100) NOT NULL,
	`PhoneNumber` Varchar(20) NOT NULL,
	`Address` Longtext NOT NULL,
	`Description` Longtext NULL,
	`CreateAt` Datetime(3) NOT NULL,
	`Status` Tinyint Unsigned NOT NULL,
/* Name ignored: Constraint `pk_Shop` */ Primary Key  (`ShopID`)
); 

Create table `Catagory` (
	`CategoryID` Integer NOT NULL,
	`CategoryName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
/* Name ignored: Constraint `pk_Catagory` */ Primary Key  (`CategoryID`)
); 

Create table `FinancialReport` (
	`ReportID` Integer NOT NULL,
	`Month` Integer NOT NULL,
	`Year` Integer NOT NULL,
	`Revenue` Decimal(19,4) NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_FinancialReport` */ Primary Key  (`ReportID`)
); 

Create table `DataAnalysis` (
	`AnalysidID` Integer NOT NULL,
	`Month` Integer NOT NULL,
	`Sales` Decimal(19,4) NOT NULL,
	`PerformanceScore` Double NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_DataAnalysis` */ Primary Key  (`AnalysidID`)
); 

Create table `Cart` (
	`CartID` Integer NOT NULL,
	`LastUpdate` Datetime(3) NOT NULL,
	`Status` Varchar(20) NOT NULL,
	`CustomerID` Integer NOT NULL,
/* Name ignored: Constraint `pk_Cart` */ Primary Key  (`CartID`)
); 

Create table `Promotion` (
	`PromotionID` Integer NOT NULL,
	`PromotionName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`DiscountValue` Decimal(19,4) NOT NULL,
	`StartDate` Datetime(3) NOT NULL,
	`EndDate` Datetime(3) NOT NULL,
/* Name ignored: Constraint `pk_Promotion` */ Primary Key  (`PromotionID`)
); 

Create table `CustomerPomotion` (
	`CustomerID` Integer NOT NULL,
	`PromotionID` Integer NOT NULL,
/* Name ignored: Constraint `pk_CustomerPomotion` */ Primary Key  (`CustomerID`,`PromotionID`)
); 

Create table `BankAccount` (
	`BankAccountID` Integer NOT NULL,
	`ShopID` Integer NOT NULL,
	`BankName` Varchar(100) NOT NULL,
	`AccountNumber` Varchar(50) NOT NULL,
	`AccountHolder` Varchar(100) NOT NULL,
	`IsDefault` Tinyint Unsigned NOT NULL,
	`CreatedAt` Datetime(3) NOT NULL,
	`Status` Varchar(20) NOT NULL,
/* Name ignored: Constraint `pk_BankAccount` */ Primary Key  (`BankAccountID`)
); 

Create table `CartItem` (
	`CartID` Integer NOT NULL,
	`ProductID` Integer NOT NULL,
	`Quantity` Integer NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_CartItem` */ Primary Key  (`CartID`,`ProductID`,`ShopID`)
); 

Create table `Address` (
	`CustomerID` Integer NOT NULL,
	`AddressID` Integer NOT NULL,
	`AddressDetail` Longtext NOT NULL,
	`Street`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`Ward`  VARCHAR(50) CHARACTER SET utf8mb4 NULL,
	`District`  VARCHAR(50) CHARACTER SET utf8mb4 NULL,
	`City`  VARCHAR(50) CHARACTER SET utf8mb4 NULL,
	`Country`  VARCHAR(50) CHARACTER SET utf8mb4 NULL,
	`IsDefault` Tinyint Unsigned NOT NULL,
	`Note` Longtext NULL,
/* Name ignored: Constraint `pk_Address` */ Primary Key  (`AddressID`)
); 

Create table `Users` (
	`UserID` Integer NOT NULL,
	`UserName` Varchar(50) NOT NULL,
	`Password` Varchar(50) NOT NULL,
	`Email` Varchar(100) NOT NULL,
	`Phonenumber` Varchar(20) NOT NULL,
	`Role` Varchar(20) NOT NULL,
	`CreateAt` Datetime(3) NOT NULL,
	`LastLogin` Datetime(3) NULL,
	`IsActive` Tinyint Unsigned NOT NULL,
/* Name ignored: Constraint `pk_Users` */ Primary Key  (`UserID`)
); 

Create table `Payment` (
	`PaymentID` Integer NOT NULL,
	`OrderID` Integer NOT NULL,
	`CustomerID` Integer NOT NULL,
	`PaymentMethod` Varchar(20) NOT NULL,
	`Amount` Decimal(19,4) NOT NULL,
	`PaymentDate` Datetime(3) NOT NULL,
	`Status` Varchar(20) NOT NULL,
	`TransactionCode`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`Note` Longtext NULL,
/* Name ignored: Constraint `pk_Payment` */ Primary Key  (`PaymentID`)
); 

Create table `Review` (
	`ReviewID` Integer NOT NULL,
	`Rating` Integer NOT NULL,
	`Comment` Longtext NOT NULL,
	`CreateAt` Datetime(3) NOT NULL,
	`CustomerID` Integer NOT NULL,
	`ProductID` Integer NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_Review` */ Primary Key  (`ReviewID`)
); 

Create table `ProductImage` (
	`ImageID` Integer NOT NULL,
	`ImageURL` Longtext NOT NULL,
	`IsThumbnail` Tinyint Unsigned NOT NULL,
	`ProductID` Integer NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_ProductImage` */ Primary Key  (`ImageID`)
); 

Create table `ShopPromotion` (
	`ShopPromoID` Integer NOT NULL,
	`PromotionName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`DiscountValue` Decimal(19,4) NOT NULL,
	`StartDate` Datetime(3) NOT NULL,
	`EndDate` Datetime(3) NOT NULL,
	`Status` Varchar(20) NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_ShopPromotion` */ Primary Key  (`ShopPromoID`)
); 

Create table `Notification` (
	`NotiID` Integer NOT NULL,
	`Title`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`Message` Longtext NOT NULL,
	`IsRead` Tinyint Unsigned NOT NULL,
	`CreatedAt` Datetime(3) NOT NULL,
	`UserID` Integer NOT NULL,
/* Name ignored: Constraint `pk_Notification` */ Primary Key  (`NotiID`)
); 

Create table `Shipping` (
	`ShippingID` Integer NOT NULL,
	`TrackingNumber` Varchar(100) NOT NULL,
	`ShippingMethod` Varchar(20) NOT NULL,
	`ShipperName`  VARCHAR(100) CHARACTER SET utf8mb4 NULL,
	`ShippingStatus` Varchar(20) NOT NULL,
	`DeliveryDate` Datetime(3) NOT NULL,
	`OrderID` Integer NOT NULL,
/* Name ignored: Constraint `pk_Shipping` */ Primary Key  (`ShippingID`)
); 

Create table `WishList` (
	`CustomerID` Integer NOT NULL,
	`ProductID` Integer NOT NULL,
	`CreateAt` Datetime(3) NOT NULL,
	`ShopID` Integer NOT NULL,
/* Name ignored: Constraint `pk_WishList` */ Primary Key  (`CustomerID`,`ProductID`,`ShopID`)
); 


Alter table `OrderDetail` add Constraint `Product_OrderDetail` foreign key(`ProductID`,`ShopID`) references `Product` (`ProductID`,`ShopID`); 
 
Alter table `CartItem` add Constraint `Product_CartItem` foreign key(`ProductID`,`ShopID`) references `Product` (`ProductID`,`ShopID`); 
 
Alter table `WishList` add Constraint `Product_WishList` foreign key(`ProductID`,`ShopID`) references `Product` (`ProductID`,`ShopID`); 
 
Alter table `Review` add Constraint `Product_Review` foreign key(`ProductID`,`ShopID`) references `Product` (`ProductID`,`ShopID`); 
 
Alter table `ProductImage` add Constraint `Product_ProductImage` foreign key(`ProductID`,`ShopID`) references `Product` (`ProductID`,`ShopID`); 
 
Alter table `OrderDetail` add Constraint `Orders_OrderDetail` foreign key(`OrderID`) references `Orders` (`OrderID`); 
 
Alter table `Payment` add Constraint `Orders_Payment` foreign key(`OrderID`) references `Orders` (`OrderID`); 
 
Alter table `Shipping` add Constraint `Orders_Shipping` foreign key(`OrderID`) references `Orders` (`OrderID`); 
 
Alter table `CustomerPomotion` add Constraint `Customer_CustomerPomotion` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `Orders` add Constraint `Customer_Orders` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `Cart` add Constraint `Customer_Cart` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `Address` add Constraint `Customer_Address` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `Payment` add Constraint `Customer_Payment` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `WishList` add Constraint `Customer_WishList` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `Review` add Constraint `Customer_Review` foreign key(`CustomerID`) references `Customer` (`CustomerID`); 
 
Alter table `FinancialReport` add Constraint `Shop_FinancialReport` foreign key(`ShopID`) references `Shop` (`ShopID`); 
 
Alter table `DataAnalysis` add Constraint `Shop_DataAnalysis` foreign key(`ShopID`) references `Shop` (`ShopID`); 
 
Alter table `BankAccount` add Constraint `Shop_BankAccount` foreign key(`ShopID`) references `Shop` (`ShopID`); 
 
Alter table `ShopPromotion` add Constraint `Shop_ShopPromotion` foreign key(`ShopID`) references `Shop` (`ShopID`); 
 
Alter table `Product` add Constraint `Product_Shop` foreign key(`ShopID`) references `Shop` (`ShopID`); 
 
Alter table `Product` add Constraint `Category_Product` foreign key(`CategoryID`) references `Catagory` (`CategoryID`); 
 
Alter table `CartItem` add Constraint `Cart_CartItem` foreign key(`CartID`) references `Cart` (`CartID`); 
 
Alter table `CustomerPomotion` add Constraint `Pomotion_CustomerPomotion` foreign key(`PromotionID`) references `Promotion` (`PromotionID`); 
 
Alter table `Customer` add Constraint `User_Customer` foreign key(`UserID`) references `Users` (`UserID`); 
 
Alter table `Notification` add Constraint `User_Notify` foreign key(`UserID`) references `Users` (`UserID`); 
 


/* Set quoted_identifier on */
 

/* Set quoted_identifier off */
 
-- Insert table
INSERT INTO Users (UserID, UserName, Password, Email, Phonenumber, Role, CreateAt, LastLogin, IsActive) VALUES
(1, 'minhnhat', 'pass123', 'nhat@example.com', '0909123456', 'Admin', NOW(), NOW(), 1),
(2, 'lananh', 'pass234', 'anh@example.com', '0912345678', 'Customer', NOW(), NOW(), 1),
(3, 'tuanvu', 'pass345', 'vu@example.com', '0938123456', 'Customer', NOW(), NOW(), 1),
(4, 'hoanglong', 'pass456', 'long@example.com', '0977123456', 'Seller', NOW(), NOW(), 1),
(5, 'kimngan', 'pass567', 'ngan@example.com', '0988123456', 'Customer', NOW(), NOW(), 1),
(6, 'thuhang', 'pass678', 'hang@example.com', '0907123456', 'Customer', NOW(), NOW(), 1),
(7, 'quochuy', 'pass789', 'huy@example.com', '0939123456', 'Seller', NOW(), NOW(), 1),
(8, 'phuonganh', 'pass890', 'phuong@example.com', '0911123456', 'Customer', NOW(), NOW(), 1),
(9, 'vietkhoa', 'pass901', 'khoa@example.com', '0901123456', 'Customer', NOW(), NOW(), 1),
(10, 'ngocthuy', 'pass012', 'thuy@example.com', '0922123456', 'Customer', NOW(), NOW(), 1);

INSERT INTO Customer (CustomerID, UserID, FullName, Gender, BirthDate, LoyaltyPoint) VALUES
(1, 2, 'Lan Anh', 'F', '1995-04-12', 100),
(2, 3, 'Tuan Vu', 'M', '1990-01-20', 200),
(3, 5, 'Kim Ngan', 'F', '1992-07-08', 150),
(4, 6, 'Thu Hang', 'F', '1998-03-18', 80),
(5, 8, 'Phuong Anh', 'F', '1996-11-25', 120),
(6, 9, 'Viet Khoa', 'M', '1991-05-14', 60),
(7, 10, 'Ngoc Thuy', 'F', '1993-09-30', 90),
(8, 3, 'Tuan Vu', 'M', '1990-01-20', 300),
(9, 5, 'Kim Ngan', 'F', '1992-07-08', 50),
(10, 9, 'Viet Khoa', 'M', '1991-05-14', 110);

INSERT INTO Shop (ShopID, ShopName, Email, PhoneNumber, Address, Description, CreateAt, Status) VALUES
(1, 'ElectroShop', 'contact@electroshop.com', '0909000001', '123 Lê Lợi, TP HCM', 'Chuyên đồ điện tử', NOW(), 1),
(2, 'TechStore', 'info@techstore.com', '0909000002', '456 Trần Hưng Đạo, Hà Nội', 'Thiết bị công nghệ', NOW(), 1),
(3, 'HomeAppliances', 'home@appliances.com', '0909000003', '789 Nguyễn Trãi, Đà Nẵng', 'Đồ gia dụng', NOW(), 1),
(4, 'SmartLife', 'smartlife@shop.com', '0909000004', '321 Phạm Văn Đồng, HCM', 'Thiết bị thông minh', NOW(), 1),
(5, 'PhoneHub', 'phonehub@store.com', '0909000005', '654 CMT8, HCM', 'Điện thoại di động', NOW(), 1),
(6, 'GadgetWorld', 'gadget@world.com', '0909000006', '98 Hai Bà Trưng, Hà Nội', 'Phụ kiện công nghệ', NOW(), 1),
(7, 'SoundPlus', 'soundplus@music.com', '0909000007', '12 Lý Thường Kiệt, HN', 'Thiết bị âm thanh', NOW(), 1),
(8, 'CameraPro', 'camera@pro.com', '0909000008', '45 Điện Biên Phủ, HCM', 'Camera và thiết bị an ninh', NOW(), 1),
(9, 'GameZone', 'gamezone@zone.com', '0909000009', '88 Hoàng Diệu, Đà Nẵng', 'Thiết bị gaming', NOW(), 1),
(10, 'SmartHome', 'smarthome@home.com', '0909000010', '100 Bạch Đằng, HN', 'Nhà thông minh', NOW(), 1);

INSERT INTO Catagory (CategoryID, CategoryName) VALUES
(1, 'Điện thoại'),
(2, 'Máy tính'),
(3, 'Phụ kiện'),
(4, 'Đồ gia dụng'),
(5, 'Thiết bị âm thanh'),
(6, 'Camera'),
(7, 'Đồng hồ thông minh'),
(8, 'Thiết bị gaming'),
(9, 'Smart Home'),
(10, 'Thiết bị văn phòng');

INSERT INTO Product (ProductID, ProductName, Description, Price, StockQuantity, Brand, CreateAt, UpdateAt, IsActive, CategoryID, ShopID) VALUES
(1, 'iPhone 15', 'Điện thoại Apple mới nhất', 29990000, 50, 'Apple', NOW(), NOW(), 1, 1, 5),
(2, 'Samsung Galaxy S23', 'Điện thoại Samsung cao cấp', 24990000, 40, 'Samsung', NOW(), NOW(), 1, 1, 5),
(3, 'MacBook Pro 16', 'Laptop cho dân đồ họa', 69990000, 20, 'Apple', NOW(), NOW(), 1, 2, 2),
(4, 'Tai nghe Sony WH-1000XM5', 'Tai nghe chống ồn', 7990000, 35, 'Sony', NOW(), NOW(), 1, 5, 7),
(5, 'Camera IP Xiaomi', 'Camera an ninh gia đình', 1200000, 60, 'Xiaomi', NOW(), NOW(), 1, 6, 8),
(6, 'Smart Watch Garmin', 'Đồng hồ thể thao thông minh', 9500000, 25, 'Garmin', NOW(), NOW(), 1, 7, 4),
(7, 'Loa JBL Charge 5', 'Loa bluetooth công suất lớn', 3200000, 45, 'JBL', NOW(), NOW(), 1, 5, 7),
(8, 'Bàn phím cơ Logitech', 'Phụ kiện gaming', 2500000, 30, 'Logitech', NOW(), NOW(), 1, 3, 9),
(9, 'Ổ cứng SSD 1TB', 'Thiết bị lưu trữ tốc độ cao', 2200000, 70, 'Samsung', NOW(), NOW(), 1, 3, 6),
(10, 'Robot hút bụi Xiaomi', 'Thiết bị thông minh cho gia đình', 6000000, 20, 'Xiaomi', NOW(), NOW(), 1, 9, 10);

INSERT INTO Orders (OrderID, OrderDate, Status, ShippingFee, TotalAmount, CustomerID) VALUES
(1, NOW(), 'Completed', 30000, 30020000, 1),
(2, NOW(), 'Processing', 30000, 25020000, 2),
(3, NOW(), 'Completed', 25000, 70020000, 3),
(4, NOW(), 'Shipped', 20000, 8000000, 4),
(5, NOW(), 'Cancelled', 0, 1200000, 5),
(6, NOW(), 'Completed', 30000, 9500000, 6),
(7, NOW(), 'Completed', 20000, 3200000, 7),
(8, NOW(), 'Processing', 25000, 2500000, 8),
(9, NOW(), 'Completed', 30000, 2200000, 9),
(10, NOW(), 'Completed', 30000, 6000000, 10);

INSERT INTO OrderDetail (OrderID, ProductID, Quantity, UnitPrice, ShopID) VALUES
(1, 1, 1, 29990000, 5),
(2, 2, 1, 24990000, 5),
(3, 3, 1, 69990000, 2),
(4, 4, 1, 7990000, 7),
(5, 5, 1, 1200000, 8),
(6, 6, 1, 9500000, 4),
(7, 7, 1, 3200000, 7),
(8, 8, 1, 2500000, 9),
(9, 9, 1, 2200000, 6),
(10, 10, 1, 6000000, 10);

INSERT INTO Cart (CartID, LastUpdate, Status, CustomerID) VALUES
(1, NOW(), 'Active', 1),
(2, NOW(), 'Active', 2),
(3, NOW(), 'Active', 3),
(4, NOW(), 'Active', 4),
(5, NOW(), 'Inactive', 5),
(6, NOW(), 'Active', 6),
(7, NOW(), 'Inactive', 7),
(8, NOW(), 'Active', 8),
(9, NOW(), 'Active', 9),
(10, NOW(), 'Inactive', 10);

INSERT INTO Payment (PaymentID, OrderID, CustomerID, PaymentMethod, Amount, PaymentDate, Status, TransactionCode, Note) VALUES
(1, 1, 1, 'CreditCard', 30020000, NOW(), 'Success', 'TXN001', 'Thanh toán thẻ'),
(2, 2, 2, 'Momo', 25020000, NOW(), 'Pending', 'TXN002', NULL),
(3, 3, 3, 'BankTransfer', 70020000, NOW(), 'Success', 'TXN003', NULL),
(4, 4, 4, 'CashOnDelivery', 8000000, NOW(), 'Shipped', 'TXN004', 'Thanh toán khi nhận'),
(5, 5, 5, 'CreditCard', 1200000, NOW(), 'Failed', 'TXN005', 'Lỗi thanh toán'),
(6, 6, 6, 'Momo', 9500000, NOW(), 'Success', 'TXN006', NULL),
(7, 7, 7, 'BankTransfer', 3200000, NOW(), 'Success', 'TXN007', NULL),
(8, 8, 8, 'CreditCard', 2500000, NOW(), 'Pending', 'TXN008', NULL),
(9, 9, 9, 'CashOnDelivery', 2200000, NOW(), 'Success', 'TXN009', 'Thanh toán khi nhận'),
(10, 10, 10, 'CreditCard', 6000000, NOW(), 'Success', 'TXN010', NULL);

INSERT INTO Review (ReviewID, Rating, Comment, CreateAt, CustomerID, ProductID, ShopID) VALUES
(1, 5, 'Rất hài lòng với iPhone 15', NOW(), 1, 1, 5),
(2, 4, 'Samsung Galaxy S23 rất đẹp', NOW(), 2, 2, 5),
(3, 5, 'Macbook Pro tuyệt vời', NOW(), 3, 3, 2),
(4, 3, 'Chống ồn tạm ổn', NOW(), 4, 4, 7),
(5, 4, 'Camera IP dễ lắp đặt', NOW(), 5, 5, 8),
(6, 5, 'Đồng hồ Garmin rất chất', NOW(), 6, 6, 4),
(7, 5, 'Loa JBL chất lượng tốt', NOW(), 7, 7, 7),
(8, 4, 'Bàn phím gõ sướng tay', NOW(), 8, 8, 9),
(9, 4, 'Ổ cứng SSD chạy nhanh', NOW(), 9, 9, 6),
(10, 5, 'Robot hút bụi siêu sạch', NOW(), 10, 10, 10);

INSERT INTO `productimage` (`ImageID`, `ImageURL`, `IsThumbnai`, `ProductID`, `ShopID`) VALUES
(1, './public/images/electro_mart/iphone15.jpg', 1, 1, 5),
(2, './public/images/electro_mart/galaxy_s23.jpg', 1, 2, 5),
(3, './public/images/electro_mart/macbookpro16.jpg', 1, 3, 2),
(4, './public/images/electro_mart/sony_wh1000xm5.jpg', 1, 4, 7),
(5, './public/images/electro_mart/camera_ip_xiaomi.jpg', 1, 5, 8),
(6, './public/images/electro_mart/garmin_watch.jpg', 1, 6, 4),
(7, './public/images/electro_mart/jbl_charge5.jpg', 1, 7, 7),
(8, './public/images/electro_mart/logitech_keyboard.jpg', 1, 8, 9),
(9, './public/images/electro_mart/ssd_1tb.jpg', 1, 9, 6),
(10, './public/images/electro_mart/robot_hut_bui_xiaomi.jpg', 1, 10, 10);

INSERT INTO Address (CustomerID, AddressID, AddressDetail, Street, Ward, District, City, Country, IsDefault, Note) VALUES
(1, 1, '123 Lý Thái Tổ', 'Lý Thái Tổ', 'Phường 1', 'Quận 10', 'TP HCM', 'Vietnam', 1, ''),
(2, 2, '456 Nguyễn Huệ', 'Nguyễn Huệ', 'Phường Bến Nghé', 'Quận 1', 'TP HCM', 'Vietnam', 1, ''),
(3, 3, '789 Trần Phú', 'Trần Phú', 'Phường 9', 'Quận 5', 'TP HCM', 'Vietnam', 1, ''),
(4, 4, '321 Lê Lợi', 'Lê Lợi', 'Phường 7', 'Quận 3', 'TP HCM', 'Vietnam', 1, ''),
(5, 5, '654 Nguyễn Văn Linh', 'Nguyễn Văn Linh', 'Phường Tân Phú', 'Quận 7', 'TP HCM', 'Vietnam', 1, ''),
(6, 6, '12 Nguyễn Trãi', 'Nguyễn Trãi', 'Phường 14', 'Quận 5', 'TP HCM', 'Vietnam', 1, ''),
(7, 7, '88 Hai Bà Trưng', 'Hai Bà Trưng', 'Phường 6', 'Quận 3', 'TP HCM', 'Vietnam', 1, ''),
(8, 8, '99 Cách Mạng Tháng Tám', 'Cách Mạng Tháng Tám', 'Phường 5', 'Quận 10', 'TP HCM', 'Vietnam', 1, ''),
(9, 9, '120 Lý Chính Thắng', 'Lý Chính Thắng', 'Phường 8', 'Quận 3', 'TP HCM', 'Vietnam', 1, ''),
(10, 10, '134 Hoàng Diệu', 'Hoàng Diệu', 'Phường 12', 'Quận 4', 'TP HCM', 'Vietnam', 1, '');

INSERT INTO CartItem (CartID, ProductID, Quantity, ShopID) VALUES
(1, 1, 1, 5),
(2, 2, 2, 5),
(3, 3, 1, 2),
(4, 4, 3, 7),
(5, 5, 1, 8),
(6, 6, 1, 4),
(7, 7, 2, 7),
(8, 8, 1, 9),
(9, 9, 1, 6),
(10, 10, 1, 10);

INSERT INTO WishList (CustomerID, ProductID, CreateAt, ShopID) VALUES
(1, 3, NOW(), 2),
(2, 1, NOW(), 5),
(3, 4, NOW(), 7),
(4, 5, NOW(), 8),
(5, 7, NOW(), 7),
(6, 9, NOW(), 6),
(7, 6, NOW(), 4),
(8, 10, NOW(), 10),
(9, 8, NOW(), 9),
(10, 2, NOW(), 5);

INSERT INTO FinancialReport (ReportID, Month, Year, Revenue, ShopID) VALUES
(1, 1, 2025, 100000000, 1),
(2, 2, 2025, 120000000, 2),
(3, 3, 2025, 90000000, 3),
(4, 4, 2025, 110000000, 4),
(5, 5, 2025, 95000000, 5),
(6, 6, 2025, 85000000, 6),
(7, 7, 2025, 87000000, 7),
(8, 8, 2025, 92000000, 8),
(9, 9, 2025, 98000000, 9),
(10, 10, 2025, 101000000, 10);

INSERT INTO DataAnalysis (AnalysidID, Month, Sales, PerformanceScore, ShopID) VALUES
(1, 1, 50000000, 8.5, 1),
(2, 2, 60000000, 9.0, 2),
(3, 3, 45000000, 7.8, 3),
(4, 4, 55000000, 8.3, 4),
(5, 5, 47000000, 7.9, 5),
(6, 6, 43000000, 7.5, 6),
(7, 7, 49000000, 8.0, 7),
(8, 8, 52000000, 8.2, 8),
(9, 9, 51000000, 8.1, 9),
(10, 10, 53000000, 8.4, 10);

INSERT INTO Promotion (PromotionID, PromotionName, DiscountValue, StartDate, EndDate) VALUES
(1, 'Khuyến mãi Tết', 1000000, '2025-01-15', '2025-02-15'),
(2, 'Sale hè', 500000, '2025-06-01', '2025-06-30'),
(3, 'Black Friday', 2000000, '2025-11-25', '2025-11-30'),
(4, 'Cyber Monday', 1500000, '2025-12-01', '2025-12-02'),
(5, 'Mừng sinh nhật', 800000, '2025-07-20', '2025-07-25'),
(6, 'Giảm giá học sinh', 300000, '2025-09-01', '2025-09-30'),
(7, 'Combo hấp dẫn', 1200000, '2025-04-10', '2025-04-20'),
(8, 'Valentine Sale', 400000, '2025-02-10', '2025-02-14'),
(9, 'Mùa tựu trường', 600000, '2025-08-15', '2025-08-31'),
(10, 'Giáng sinh an lành', 1800000, '2025-12-20', '2025-12-31');

INSERT INTO CustomerPomotion (CustomerID, PromotionID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

INSERT INTO ShopPromotion (ShopPromoID, PromotionName, DiscountValue, StartDate, EndDate, Status, ShopID) VALUES
(1, 'Giảm giá 10%', 500000, '2025-01-01', '2025-01-31', 'Active', 1),
(2, 'Free Ship', 300000, '2025-02-01', '2025-02-28', 'Active', 2),
(3, 'Mua 1 tặng 1', 0, '2025-03-01', '2025-03-10', 'Inactive', 3),
(4, 'Ưu đãi sinh viên', 200000, '2025-04-01', '2025-04-30', 'Active', 4),
(5, 'Sale cuối năm', 1500000, '2025-12-01', '2025-12-31', 'Upcoming', 5),
(6, 'Khuyến mãi 20%', 1000000, '2025-06-01', '2025-06-15', 'Active', 6),
(7, 'Voucher giảm 5%', 250000, '2025-07-01', '2025-07-31', 'Active', 7),
(8, 'Flash Sale', 700000, '2025-08-01', '2025-08-05', 'Inactive', 8),
(9, 'Quà tặng kèm', 0, '2025-09-01', '2025-09-15', 'Active', 9),
(10, 'Sale mùa đông', 900000, '2025-11-15', '2025-11-30', 'Active', 10);

INSERT INTO Notification (NotiID, Title, Message, IsRead, CreatedAt, UserID) VALUES
(1, 'Đơn hàng đã giao', 'Đơn hàng #1 đã được giao thành công', 0, NOW(), 2),
(2, 'Khuyến mãi mới', 'Bạn nhận được khuyến mãi 500k', 0, NOW(), 3),
(3, 'Cập nhật tài khoản', 'Thông tin tài khoản của bạn đã thay đổi', 1, NOW(), 5),
(4, 'Đánh giá sản phẩm', 'Hãy để lại đánh giá cho đơn hàng', 0, NOW(), 6),
(5, 'Thông báo bảo trì', 'Hệ thống bảo trì vào 15/07', 1, NOW(), 8),
(6, 'Ưu đãi thành viên', 'Bạn đã được nâng cấp thành viên VIP', 0, NOW(), 9),
(7, 'Giao hàng thất bại', 'Đơn hàng #5 giao không thành công', 1, NOW(), 10),
(8, 'Mã giảm giá mới', 'Sử dụng code SALE20 để giảm giá', 0, NOW(), 3),
(9, 'Khuyến mãi sinh nhật', 'Chúc mừng sinh nhật! Nhận ngay quà tặng', 1, NOW(), 5),
(10, 'Hướng dẫn sử dụng', 'Xem video hướng dẫn chi tiết', 1, NOW(), 6);

INSERT INTO Shipping (ShippingID, TrackingNumber, ShippingMethod, ShipperName, ShippingStatus, DeliveryDate, OrderID) VALUES
(1, 'TRK001', 'Giao nhanh', 'Giao Hàng Nhanh', 'Delivered', NOW(), 1),
(2, 'TRK002', 'Giao tiêu chuẩn', 'Viettel Post', 'In Transit', NOW(), 2),
(3, 'TRK003', 'COD', 'GHTK', 'Delivered', NOW(), 3),
(4, 'TRK004', 'Express', 'VNPost', 'Shipped', NOW(), 4),
(5, 'TRK005', 'Standard', 'J&T', 'Cancelled', NOW(), 5),
(6, 'TRK006', 'Giao nhanh', 'Giao Hàng Nhanh', 'Delivered', NOW(), 6),
(7, 'TRK007', 'Express', 'Lalamove', 'Delivered', NOW(), 7),
(8, 'TRK008', 'Standard', 'GrabExpress', 'In Transit', NOW(), 8),
(9, 'TRK009', 'COD', 'GHTK', 'Delivered', NOW(), 9),
(10, 'TRK010', 'Express', 'AhaMove', 'Delivered', NOW(), 10);

INSERT INTO BankAccount (BankAccountID, ShopID, BankName, AccountNumber, AccountHolder, IsDefault, CreatedAt, Status) VALUES
('1', 1, 'Vietcombank', '123456789', 'ElectroShop', 1, NOW(), 'Active'),
('2', 2, 'ACB', '987654321', 'TechStore', 1, NOW(), 'Active'),
('3', 3, 'BIDV', '456789123', 'HomeAppliances', 1, NOW(), 'Active'),
('4', 4, 'TPBank', '321654987', 'SmartLife', 1, NOW(), 'Active'),
('5', 5, 'VPBank', '789456123', 'PhoneHub', 1, NOW(), 'Active'),
('6', 6, 'MB Bank', '159357456', 'GadgetWorld', 1, NOW(), 'Active'),
('7', 7, 'Sacombank', '753951456', 'SoundPlus', 1, NOW(), 'Active'),
('8', 8, 'HSBC', '147258369', 'CameraPro', 1, NOW(), 'Active'),
('9', 9, 'OCB', '369258147', 'GameZone', 1, NOW(), 'Active'),
('10', 10, 'Eximbank', '258369147', 'SmartHome', 1, NOW(), 'Active');
