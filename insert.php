<?php require "templates/header.php"; ?>

<?php

if (isset($_POST['submit'])) {
    //echo "<h2>Initializing.</h2>";
    require "config.php";

    //echo "<h2>Using $host and $username and $password and $db_name and $sslcert</h2>";

    //Establishes the connection
    $conn = mysqli_init();
    //echo "<h2>Init done.</h2>";

    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);

	//echo "<h2>SSL set complete.</h2>";

    if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
	{
		die('Failed to connect to MySQL: '.mysqli_connect_error());
	}

    $sql = file_get_contents("schema.sql");

    // Run the create table query
    if(!mysqli_query($conn, $sql)){
        die('No Table Created');
    }

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

<a href="index.php">Back to Home Page</a>

<?php
      }
?>

<?php require "templates/footer.php"; ?>

