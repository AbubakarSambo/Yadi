<?php
$servername = "localhost";
$username = "admin";
$password = "adminpassword";
$dbname = "yadi_backend";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table customer
$sql = "CREATE TABLE IF NOT EXISTS Customer (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
phone VARCHAR(50),
address VARCHAR(100),
passcode VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Customer created successfully \n";
} else {
    echo "Error creating table: " . $conn->error;
}

// sql to create table admin
$sql = "CREATE TABLE IF NOT EXISTS Admin (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
phone VARCHAR(50),
secuirity_pin int,
dob long,
passphrase VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable Admin created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}

// sql to create table Fabric
$sql = "CREATE TABLE IF NOT EXISTS Fabric (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50),
type int,
category int,
make VARCHAR(50),
color int,
dimension VARCHAR(50),
make_country VARCHAR(50),
price double,
in_stock int,
image int,
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable Fabric created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}


$sql = "CREATE TABLE IF NOT EXISTS FabricCategory (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
category VARCHAR(100),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable FabricCategory created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS FabricColor (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
color VARCHAR(100),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable FabricColor created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS FabricType (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
type VARCHAR(100),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable FabricType created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS FabricImage (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
location VARCHAR(100),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable FabricImage created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS Order_ (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
customerid int,
fabricid int,
quantity int,
price decimal,
billing_address VARCHAR(100),
delivery_address VARCHAR(100),
delivery_date TIMESTAMP,
status VARCHAR(20),
processedby int,
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
	echo "\nTable Order created successfully\n";
} else {
	echo "Error creating table: " . $conn->error;
}


$conn->close();
?>