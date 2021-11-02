<?php
function loadDb($file){
    $conn = mysqli_connect("localhost", "root","") or die(mysql_error());

    $sql = "CREATE DATABASE IF NOT EXISTS sqlDump";
    if ($conn->query($sql) === TRUE) {
    echo"Connection succesful\n";
    }
    else{
        echo"Connection failed\n";
    }
    $sql ="USE sqlDump";
    if ($conn->query($sql) === TRUE) {
        echo"Connected to DB\n";
        }
        else{
            echo"Failed at connecting to DB\n";
        }
        $sql = file_get_contents($file);
        
        if ($conn->multi_query($sql) === TRUE) {
            echo 'Dump "'.$file.'" was succesfully imported\n';
        } else {
            echo "Error creating table: " . $conn->error;
            if (strpos($conn->error, "already exists") == false){
                exit();
            }
    }
}

function deleteQuery($sql,$connection){
    $sql = explode(" ",$sql);
    $placement = array_search("FROM", $sql);
    if ($placement){
        for ($i = 0; $i < $placement; $i++){
            array_shift($sql);
        }
    }
    else{
        echo "Query invalid";
        exit();
    }
    $sql = "DELETE " . implode(" ",$sql);
    $result = $connection->query($sql);
}

function verifyData($file, $query, $connection){
    $newData = array();
    $result = $connection->query($query);
    $firstRun = TRUE;
    $start ="";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($firstRun){
                for ($i = 0; $i < count($row); $i++){
                    $start .= array_keys($row)[$i];
                }
            }
            $firstRun = FALSE;
            for ($i = 0; $i < count($row); $i++){
                array_push($newData, $row[array_keys($row)[$i]]);
            }
        }
    }
    $file = file_get_contents($file);
    $file = str_replace(", ", "", $file);
    $file = str_replace("\n", "", $file);
    $file = str_replace($start, "", $file);
    if (MD5($file) == MD5(implode("", $newData))){
        return TRUE;
    }
}


$file = "sqldump.sql";
loadDb($file);
$conn = mysqli_connect("localhost", "root","","sqlDump") or die(mysql_error());
$sql ="SELECT firstname, lastname, id FROM users";
$sql ="SELECT email, firstname FROM users";
$final = "";
$firstRun = TRUE;
$result = $conn->query($sql); 
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if ($firstRun){
                for ($i = 0; $i < count($row); $i++){
                    $final .= array_keys($row)[$i];
                    if ($i+1 < count($row)){
                        $final .= ", ";
                    }
                }
                $final .="\n";
                $start = $final;
            }
            $firstRun = FALSE;
            for ($i = 0; $i < count($row); $i++){
                $final .= $row[array_keys($row)[$i]];
                if ($i+1 < count($row)){
                    $final .= ", ";
                }
            }
            $final .= "\n";   
        }
    }
    $file = fopen("sqlQuery.csv", "w");
    fwrite($file,$final);
    fclose($file);
    if (verifyData("sqlQuery.csv", $sql, $conn)){
        deleteQuery($sql, $conn);
    }
    else{
        echo "\nData not saved correctly, please try again";
    }
    //echo $final;
?>