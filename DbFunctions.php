<?php
function loadDb($file){
    //Creates DB if not already existing
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
    //Runs queries from sqldump in new DB
    $sql = file_get_contents($file);
    if ($conn -> multi_query($sql)) {
        echo "\nLoading SQL DUMP\n";
        do {
          // if there are more result-sets, the print a divider for ui purposes.
          if ($conn -> more_results()) {
            printf("-------------\n");
          }
           //Prepare next result set
        } while ($conn -> next_result());
        echo "Finished loading SQL dump\n";
        $conn->close();
      }
      else{
        $error = $conn->error;
        $conn->close();
        echo "Error loading SQL dump: " . $error."\n";
        if (strpos($error, "already exists") == false){
            exit();
        }
      }
}

function deleteQuery($sql,$connection){
    $sql = explode(" ",$sql);
    $placement = array_search("FROM", $sql);
    //Saves everything after and including FROM keyword in user query
    if ($placement){
        for ($i = 0; $i < $placement; $i++){
            array_shift($sql);
        }
    }
    else{
        echo "Query invalid";
        $connection->close();
        exit();
    }
    //Custom query made for deleting every affected row
    $sql = "DELETE " . implode(" ",$sql);
    if ($connection->query($sql)){
        echo "Data deleted successfully \n";
    }
    else{
        echo "Data not deleted succesfully";
        $connection->close();
        exit();
    }
}

function verifyData($file, $query, $connection){
    $newData = array();
    $result = $connection->query($query);
    $firstRun = TRUE;
    $start ="";
    if ($result->num_rows > 0) { // The user defined query is run again
        while($row = $result->fetch_assoc()) {
            if ($firstRun){ // Saves the array keys. This is needed for easy removal of them in the saved file
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
    // Removing all CSV seperators and the arraykeys
    $file = file_get_contents($file);
    $file = str_replace(", ", "", $file); 
    $file = str_replace("\n", "", $file);
    $file = str_replace($start, "", $file);
    // New query checksum compared to checksum of raw data from file
    if (MD5($file) == MD5(implode("", $newData))){
        echo "Data verified \n";
        return TRUE;
    }
    else{
        echo "Data integrety not maintained. Please try again\n";
        $connection->close();
        exit();
    }
}

function saveData($connection, $sql){
    $final = "";
    $firstRun = TRUE;
    $result = $connection->query($sql); 
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if ($firstRun){// Saves the array keys. The array keys are put in start of the CSV file as "titles".
                for ($i = 0; $i < count($row); $i++){
                    $final .= array_keys($row)[$i];
                    if ($i+1 < count($row)){
                        $final .= ", ";
                    }
                }
                $final .="\n";
            }
            $firstRun = FALSE;
            for ($i = 0; $i < count($row); $i++){
                //Adding the new data entry to $final var, to be saved later
                $final .= $row[array_keys($row)[$i]];
                //Comma seperating the data entries, but not on the last entry of a given row
                if ($i+1 < count($row)){
                    $final .= ", ";
                }
            }
            //Adds linebreak after last entry on any given row
            $final .= "\n";   
        }
    }
    $file = fopen("sqlQuery.csv", "w");
    fwrite($file,$final);
    fclose($file);
    echo "Data saved\n";
}
?>