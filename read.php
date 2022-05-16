<?php require "templates/header.php"; ?>

<?php

require "config.php";


//Establish the connection
$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);
if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL)){
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}

//Query and print data
echo "<table> <tr> <th> Product Name </th> <th> Price </th> </tr>";
$res = mysqli_query($conn, 'SELECT * FROM Products');
while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr> <td> ".$row["ProductName"]." </td>";
    echo "<td> ".$row["Price"]." </td> </tr>";
}
echo "</table>";

//Close the connection
mysqli_close($conn);

?>

<br>
<br>
<a href="index.php">Back to Home Page</a>

<?php require "templates/footer.php"; ?>

