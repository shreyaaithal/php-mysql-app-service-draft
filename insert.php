<?php require "templates/header.php"; ?>

<?php

if (isset($_POST['submit'])) {
    echo "<h2>Initializing.</h2>";
    require "config.php";

    echo "<h2>Using $host and $username and $password and $db_name and $sslcert</h2>";

    //Establishes the connection
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
    mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
    if (mysqli_connect_errno($conn)) {
        echo "<h2>Connection Failed.</h2>";
    }
    echo "<h2>Connection Established.</h2>";

    $sql = file_get_contents("database/schemas.sql");

    // Run the create table query
    if(mysqli_query($conn, $sql)){
        echo "<h2>Table Created.</h2>";
    }
    else{
        die('Could not create'); 
    }

    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];

    if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Price) VALUES (?, ?)")) {
        mysqli_stmt_bind_param($stmt, 'ssd', $product_name, $product_price);
        $status = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Success Insert.</h2>";
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

