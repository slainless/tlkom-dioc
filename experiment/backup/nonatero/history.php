<?php
/**
 * Copyright (C) 2013 peredur.net
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
 $per_page=50;
 
 if (isset($_GET["page"])) {
$page = $_GET["page"];
}
else {
$page=1;
}
 
 
include_once($_SERVER["DOCUMENT_ROOT"] . "/regional7/koneksi_db.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/regional7/include/login/fungsi.php");

sec_session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Database - Nonatero</title>
        <link rel="stylesheet" href="styles/main.css" />
        
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
  $.datepicker.setDefaults({
  dateFormat: "yy/mm/dd",
  changeMonth: true,
  changeYear: true,
  buttonText: "Calendar"
});
    $( "#datepicker1" ).datepicker();
    $( "#datepicker2" ).datepicker();
  } );
  </script>
  
    </head>
    <body>
    
    <form method=POST name="query" >
    <div class="tanggal" >

    tanggal 1 : <input type='text' name='d1' id='datepicker1' value='<?php if(isset($_POST['d1'], $_POST['d2'])) { echo $_POST['d1']; } ?>'/><br>
    tanggal 2 : <input type='text' name='d2' id='datepicker2' value='<?php if(isset($_POST['d1'], $_POST['d2'])) { echo $_POST['d2']; } ?>'/><br>
    
    <input type="submit" />
    </div>
                    <table border='1'>
                  <tr>
                    <td>NO</td><td>WITEL</td><td>KANDATEL</td><td>CMDF</td><td>RK</td><td>CPROD</td><td>ND_TELP</td><td>ND_INT</td><td>PAKET_INT</td><td>PAKET_IPTV</td><td>GAUL_B0</td><td>GAUL_B1</td><td>GAUL_B2</td><td>GAUL30</td><td>GAUL30_BACK</td><td>LAPUL</td><td>TROUBLE_NO</td><td>TROUBLE_OPENTIME</td><td>HEADLINE</td><td>KELUHAN_DESC</td><td>STATUS</td><td>JAM</td><td>HARI</td><td>EMOSI_PLG</td><td>PRODUK_GGN</td><td>TIPE_TIKET</td><td>SMS_OPEN</td><td>SMS_BACKEND</td><td>SMS_RESOLVED</td><td>EMAIL_OPEN</td><td>EMAIL_BACKEND</td><td>EMAIL_RESOLVED</td><td>TROUBLE_CLOSED_GROUP</td><td>LOKER_DISPATCH</td><td>JML_LAPUL</td><td>CHANNEL</td><td>TANGGAL</td>																																				
                  </tr>
<?php
            if(isset($_POST['d1'], $_POST['d2']))
{
  $dtrans = array("/" => "-");
  
  $d1 = $_POST['d1'];
  $d2 = $_POST['d2'];
  
  $d1t = strtr("$d1", $dtrans) . " 00:00:00";
  $d2t = strtr("$d2", $dtrans) . " 23:59:59";
  
  echo "$d1t" . " ";
  echo "$d2t";

// Page will start from 0 and Multiple by Per Page
$start_from = ($page-1) * $per_page;

            if ($stmt = $mysqli_history_nona->prepare("SELECT * 
  FROM history
 WHERE TANGGAL>=?
   AND TANGGAL<=? LIMIT ?, ?")) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param("ssii", $d1t, $d2t, $start_from, $per_page); 
            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            
            $no = $per_page * ($page-1);
            
            while($row = $result->fetch_assoc()) {
                $no = $no + 1;
                echo "
                  <tr>
                    <td>" . $no . "</td><td>" . $row["WITEL"] . "</td><td>" . $row["KANDATEL"] . "</td><td>" . $row["CMDF"] . "</td><td>" . $row["RK"] . "</td><td>" . $row["CPROD"] . "</td><td>" . $row["ND_TELP"] . "</td><td>" . $row["ND_INT"] . "</td><td>" . $row["PAKET_INT"] . "</td><td>" . $row["PAKET_IPTV"] . "</td><td>" . $row["GAUL_B0"] . "</td><td>" . $row["GAUL_B1"] . "</td><td>" . $row["GAUL_B2"] . "</td><td>" . $row["GAUL30"] . "</td><td>" . $row["GAUL30_BACK"] . "</td><td>" . $row["LAPUL"] . "</td><td>" . $row["TROUBLE_NO"] . "</td><td>" . $row["TROUBLE_OPENTIME"] . "</td><td>" . $row["HEADLINE"] . "</td><td>" . $row["KELUHAN_DESC"] . "</td><td>" . $row["STATUS"] . "</td><td>" . $row["JAM"] . "</td><td>" . $row["HARI"] . "</td><td>" . $row["EMOSI_PLG"] . "</td><td>" . $row["PRODUK_GGN"] . "</td><td>" . $row["TIPE_TIKET"] . "</td><td>" . $row["SMS_OPEN"] . "</td><td>" . $row["SMS_BACKEND"] . "</td><td>" . $row["SMS_RESOLVED"] . "</td><td>" . $row["EMAIL_OPEN"] . "</td><td>" . $row["EMAIL_BACKEND"] . "</td><td>" . $row["EMAIL_RESOLVED"] . "</td><td>" . $row["TROUBLE_CLOSED_GROUP"] . "</td><td>" . $row["LOKER_DISPATCH"] . "</td><td>" . $row["JML_LAPUL"] . "</td><td>" . $row["CHANNEL"] . "</td><td>" . $row["TANGGAL"] . "</td>
                  </tr>
                ";
                
              }
            
            
            
            $stmt->close();
            }

            echo "</table>";
            
            if ($stmt = $mysqli_history_nona->prepare("SELECT 
            COUNT(TROUBLE_NO) as number FROM history
 WHERE TANGGAL>=?
   AND TANGGAL<=?")) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param("ss", $d1t, $d2t); 
            $stmt->execute();   // Execute the prepared query.

            $stmt->bind_result($number);
            while($stmt->fetch()) {
              $total_records = $number;
            } }
            $stmt->close();
            
            echo "$total_records";
            
            
            $total_pages = ceil($total_records / $per_page);

echo "<center><input type='submit' formaction='?page=1' value='First'/> ";

for ($i=1; $i<=$total_pages; $i++) {
echo "<input type='submit' formaction='?page=".$i."' value='".$i."' /> ";
};
echo "<input type='submit' formaction='?page=" . $total_pages . "' value='Last' /></center> ";
}

mysqli_close($mysqli);
mysqli_close($mysqli_history_rock);
mysqli_close($mysqli_history_nona);
?>
</form>
    </body>
</html>
