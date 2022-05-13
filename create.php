<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

if (isset($_POST['submit'])) {
    require "config.php";

    //Establishes the connection
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
    mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
    if (mysqli_connect_errno($conn)) {
        die('Could not connect: ' . mysqli_error($conn));
    }
    echo "<h2>Connection Established.</h2>";

    $sql = file_get_contents("database/schemas.sql");

    // Run the create table query
    mysqli_query($conn, $sql);

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

}
?>

<?php require "templates/header.php"; ?>

<h2>Add a Product</h2>

<form method="post" action = "<?php $_PHP_SELF ?>">>
    <label for="ProductName">Product Name</label>
    <input type="text" name="ProductName" id="ProductName">
    <label for="Price">Price</label>
    <input type="text" name="Price" id="Price">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to Home Page</a>

<?php require "templates/footer.php"; ?>
