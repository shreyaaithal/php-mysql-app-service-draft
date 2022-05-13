<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "database/config.php";

    //Establishes the connection
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
    mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL);
    /*if (mysqli_connect_errno($conn)) {
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    }
    printf("Connection Established.\n");*/

    $sql = file_get_contents("database/schemas.sql");

    // Run the create table query
    mysqli_query($conn, $sql);

    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];

    if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Price) VALUES (?, ?)")) {
        mysqli_stmt_bind_param($stmt, 'ssd', $product_name, $product_price);
        $status = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //Close the connection
    mysqli_close($conn);

}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $status) { ?>
    <blockquote>Product: <?php echo $_POST['ProductName']; ?> has been successfully added.</blockquote>
<?php } ?>

<h2>Add a Product</h2>

<form method="post">
    <label for="ProductName">Product Name</label>
    <input type="text" name="ProductName" id="ProductName">
    <label for="Price">Price</label>
    <input type="text" name="Price" id="Price">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to Home Page</a>

<?php require "templates/footer.php"; ?>
