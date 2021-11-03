<?php

include "DbFunctions.php";
writeError();

function writeError(){
$file = "sqldump.sql";
loadDb($file);
$conn = mysqli_connect("localhost", "root","","sqlDump") or die(mysql_error());
$sql = "SELECT firstname, lastname FROM users";
saveData($conn, $sql);
$file = fopen("sqlQuery.csv", "w");
$file .= "."; 
if (verifyData("sqlQuery.csv", $sql, $conn)){
    deleteQuery($sql, $conn);
}
$conn->close();
}
?>