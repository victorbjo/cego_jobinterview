<?php

include "DbFunctions.php";

if ($argc != 2){
    echo "Program requires excactly 1 argument";
    exit();
}
$password = "";
$user = "root";
$host = "localhost";
$file = "sqldump.sql";
loadDb($file, $host, $user, $password );
$conn = mysqli_connect($host, $user, $password,"sqlDump") or die(mysql_error());
$sql = $argv[1];
saveData($conn, $sql);
verifyData("sqlQuery.csv", $sql, $conn);//Verify data will close connection and exit program if data is not correctly written
deleteQuery($sql, $conn);
$conn->close();
?>