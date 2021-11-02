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
    $array = array();
    $sql = explode(" ",$sql);
    $placement = array_search("WHERE", $sql);
    if ($placement){
        echo "WHERE found";
    }
    else{}
    array_shift($sql);
    $sql = "DELETE FROM users" . implode(" ", $sql);
    //$sql = 'UPDATE users SET firstname = "", lastname=""';
    //$sql ="SELECT MD5(CONCAT(email)) as MD5_checksum FROM users";
    $sql ="SELECT email, firstname FROM users";
    echo $sql;
    
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        array_push($array, $row['email']);
        array_push($array, $row['firstname']);
        //echo $row['email'];
        }
    }
    echo $array[0];
    echo $array[1];
    echo "\n\n\n".MD5(implode("", $array))."\n";
    //echo "\n".MD5("dui@aliquetsem.orgconsectetuer.adipiscing.elit@Duissit.co.uket.arcu.imperdiet@euduiCum.caSuspendisse.tristique@enimCurabiturmassa.netvel.turpis@condimentum.comelementum.lorem@arcuVestibulumante.comtortor.dictum.eu@cursus.edusemper.dui.lectus@dui.comsollicitudin.a.malesuada@nibh.eduvitae@vel.comdapibus.ligula@fringillaporttitor.co.ukDonec.tempus@arcuVestibulumut.orgridiculus.mus@aptenttacitisociosqu.eduNunc@porttitorerosnec.netipsum.Donec@variusNam.comeuismod@sedturpis.orgSuspendisse.commodo.tincidunt@eget.orgmagna.malesuada.vel@mi.orgnec.urna.suscipit@fringilla.educonsectetuer.ipsum.nunc@urnaNullamlobortis.co.uknon.magna@quis.comarcu.Vivamus@temporestac.orgridiculus@variuset.comid.ante@metus.netante@porttitorvulputate.co.ukCras.convallis@etmagna.eduAliquam@neceuismod.orgDonec@urna.netdui.nec@Duissitamet.neturna.Nunc.quis@vitae.commauris.sagittis.placerat@elementum.orgac@estconguea.eduAliquam.nec@ridiculusmusProin.co.ukdictum.eu.placerat@nislMaecenas.netut@enimdiamvel.orgnunc.sit@semperegestasurna.caSed.eget.lacus@aaliquet.comac@lacusUtnec.orgconsectetuer@at.co.ukelit.Curabitur@nonquam.co.uktincidunt.tempus.risus@doloregestas.co.ukNulla.eu.neque@vulputate.eduper.conubia@aliquetlobortisnisi.edutellus@Pellentesquehabitant.orgornare.Fusce@feugiat.co.ukconsectetuer@ultricesVivamus.cavitae.erat.Vivamus@elitEtiamlaoreet.eduamet.diam@magna.cased.est.Nunc@atvelit.netNunc.ut@etrisus.co.ukNulla.aliquet@placerat.orgcommodo.auctor.velit@nonquamPellentesque.comorci.lacus@sedhendrerita.orgadipiscing@aliquamenimnec.netarcu.Sed.et@congueelit.orgorci@Donec.eduquis.massa@nisiMaurisnulla.co.ukest.mollis.non@sagittissemper.orget.pede.Nunc@lorem.nethabitant@nislNulla.comIn.at@sit.co.ukMaecenas@estNuncullamcorper.co.ukin.sodales@nequeNullamut.netNulla@adipiscingfringilla.eduvestibulum.Mauris@sitamet.eduNulla.tempor.augue@temporaugue.orgmassa.Quisque.porttitor@lacus.edunibh.sit.amet@ligulaNullamenim.eduac.turpis@euismodac.co.ukante.ipsum@Integeraliquamadipiscing.co.ukelit.pharetra.ut@nondui.netbibendum@varius.orgest.Nunc@ultriciesadipiscing.edulectus.rutrum@quisaccumsanconvallis.casenectus.et@est.orgfacilisi.Sed.neque@ultriciesornareelit.co.uka@gravidamauris.comeget.laoreet.posuere@tincidunt.orgeget.tincidunt.dui@nequesedsem.netmontes.nascetur.ridiculus@Donec.eduquis@egetipsumDonec.co.ukporttitor@adipiscingelitEtiam.netnulla.Donec@cubiliaCuraeDonec.camauris.blandit@arcu.netaliquet@consectetueradipiscing.orgiaculis.aliquet@mollisInteger.edulorem.tristique.aliquet@urnasuscipit.comerat@velit.co.ukelementum.sem@scelerisque.eduscelerisque.lorem.ipsum@necleoMorbi.orgiaculis@Nullamfeugiatplacerat.netaccumsan.laoreet.ipsum@mauris.comfermentum.convallis.ligula@aliquet.caorci.tincidunt.adipiscing@pretiumetrutrum.comtellus@bibendumullamcorper.eduSed@vehiculaetrutrum.netlacus@milorem.caCurabitur.massa.Vestibulum@eueros.co.ukeu@elit.orgut.cursus.luctus@utipsumac.org");
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
    //echo $final;
?>