<?php require "templates/header.php"; ?>

<?php

if (isset($_POST['submit'])) {
    require "database/config.php";

    //Establish the connection
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
    if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
		die('Failed to connect to MySQL: '.mysqli_connect_error());
	}

    $res = mysqli_query("SHOW TABLES LIKE Products");

    if (mysqli_num_rows($res) == 0) 
    {
        //Create table if it does not exist
        $sql = file_get_contents("database/schema.sql");
        if(!mysqli_query($conn, $sql)){
            die('Table Creation Failed');
        }
    }

    // Insert data from form
    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];

    if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Price) VALUES (?, ?)")) {
        mysqli_stmt_bind_param($stmt, 'sd', $ProductName, $Price);
        $status = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Product \"$ProductName\" has been successfully added.</h2>";
    } 

    //Close the connection
    mysqli_close($conn);

} else {

?>

<h2>Add a Product</h2>

<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="ProductName">Product Name</label>
    <input type="text" name="ProductName" id="ProductName">
    <label for="Price">Price</label>
    <input type="text" name="Price" id="Price">
    <input type="submit" name="submit" value="Submit">
</form>

<?php
      }
?>

<br>
<a href="index.php">Back to Home Page</a>
<br>
<a href="read.php">View Catalog</a> 

<?php require "templates/footer.php"; ?>

