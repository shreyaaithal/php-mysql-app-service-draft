<?php require "templates/header.php"; ?>

<?php

//echo "<h2>Initializing.</h2>";
require "config.php";

//echo "<h2>Using $host and $username and $password and $db_name and $sslcert</h2>";

//Establishes the connection
$conn = mysqli_init();
//echo "<h2>Init done.</h2>";

mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);

//echo "<h2>SSL set complete.</h2>";

if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}

$res = mysqli_query($conn, 'SELECT * FROM Products');
while ($row = mysqli_fetch_assoc($res)) {
    echo "<th> ".$row["ProductName"]." </th>";
    echo "<td> ".$row["Price"]." </td>";
}


//Close the connection
mysqli_close($conn);

?>

<a href="index.php">Back to Home Page</a>

<?php require "templates/footer.php"; ?>

