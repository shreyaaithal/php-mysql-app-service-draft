<?php

	echo "<h2>Yo.</h2>";
	
	require "config.php";
	
    echo "<h2>$host and $username and $password and $db_name and $sslcert</h2>";

	$conn = mysqli_init();

	echo "<h2>Init complete.</h2>";

    mysqli_ssl_set($conn,NULL,NULL,$sslcert,NULL,NULL);

	echo "<h2>SSL set complete.</h2>";

    if(!mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL))
	{
		echo "<h2>Connection Failed.</h2>";
		echo mysqli_connect_error();
	}
    
	echo "<h2>Connection Established.</h2>";

    $sql = file_get_contents("schema.sql");

    // Run the create table query
    if(mysqli_query($conn, $sql)){
        echo "<h2>Table Created.</h2>";
    }
    else{
        echo "<h2>No table Created.</h2>"; 
    }

    $ProductName = "Pen";
    $Price = "10.5";

    if ($stmt = mysqli_prepare($conn, "INSERT INTO Products (ProductName, Price) VALUES (?, ?)")) {
        mysqli_stmt_bind_param($stmt, 'ssd', $ProductName, $Price);
        $status = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "<h2>Success Insert.</h2>";
    }    

    //Close the connection
    mysqli_close($conn);

?>