<?php

include "DbFunctions.php";

if ($argc != 2){
    echo "Program requires excactly 1 argument";
    exit();
}
$file = "sqldump.sql";
loadDb($file);
$conn = mysqli_connect("localhost", "root","","sqlDump") or die(mysql_error());
$sql = $argv[1];
saveData($conn, $sql);
if (verifyData("sqlQuery.csv", $sql, $conn)){
    deleteQuery($sql, $conn);
}
$conn->close();
?>