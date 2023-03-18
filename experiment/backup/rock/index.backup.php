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
        <title>Database - ROCK</title>
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
                    <td>no</td><td>regional</td><td>witel</td><td>kandatel</td><td>cmdf</td><td>rk</td><td>cprod</td><td>nd_telp</td><td>nd_int</td><td>paket_int</td><td>paket_iptv</td><td>gaul_b0</td><td>gaul_b1</td><td>gaul_b2</td><td>gaul30</td><td>gaul30_back</td><td>lapul</td><td>trouble_no</td><td>trouble_opentime</td><td>headline</td><td>keluhan_desc</td><td>status</td><td>jam</td><td>hari</td><td>emosi_plg</td><td>produk_ggn</td><td>type_cust</td><td>close</td><td>close_time</td><td>symptom</td><td>ukur_time</td><td>status_inet</td><td>upload</td><td>download</td><td>clid</td><td>snr_up</td><td>snr_down</td><td>olt_rx</td><td>onu_rx</td><td>status_redaman</td><td>stb_id</td><td>last_view</td><td>last_program</td><td>stb_ip</td><td>ukur_time_tv</td><td>channel_ggn</td><td>loker</td><td>ip_ne</td><td>node_id</td><td>status_onu</td><td>line_profile</td><td>new_flag</td><td>alpro</td><td>last_start</td><td>is_ukur_awal</td><td>ukur_time_awal</td><td>status_inet_awal</td><td>upload_awal</td><td>download_awal</td><td>clid_awal</td><td>snr_up_awal</td><td>snr_down_awal</td><td>olt_rx_awal</td><td>onu_rx_awal</td><td>status_redaman_awal</td><td>last_start_awal</td><td>ip_ne_awal</td><td>node_id_awal</td><td>status_onu_awal</td><td>line_profile_awal</td><td>sto</td><td>workzone</td><td>tanggal</td>
																																				
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

            if ($stmt = $mysqli_history_rock->prepare("SELECT * 
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
                    <td>" . $no . "</td><td>" . $row["regional"] . "</td><td>" . $row["witel"] . "</td><td>" . $row["kandatel"] . "</td><td>" . $row["cmdf"] . "</td><td>" . $row["rk"] . "</td><td>" . $row["cprod"] . "</td><td>" . $row["nd_telp"] . "</td><td>" . $row["nd_int"] . "</td><td>" . $row["paket_int"] . "</td><td>" . $row["paket_iptv"] . "</td><td>" . $row["gaul_b0"] . "</td><td>" . $row["gaul_b1"] . "</td><td>" . $row["gaul_b2"] . "</td><td>" . $row["gaul30"] . "</td><td>" . $row["gaul30_back"] . "</td><td>" . $row["lapul"] . "</td><td>" . $row["trouble_no"] . "</td><td>" . $row["trouble_opentime"] . "</td><td>" . $row["headline"] . "</td><td>" . $row["keluhan_desc"] . "</td><td>" . $row["status"] . "</td><td>" . $row["jam"] . "</td><td>" . $row["hari"] . "</td><td>" . $row["emosi_plg"] . "</td><td>" . $row["produk_ggn"] . "</td><td>" . $row["type_cust"] . "</td><td>" . $row["close"] . "</td><td>" . $row["close_time"] . "</td><td>" . $row["symptom"] . "</td><td>" . $row["ukur_time"] . "</td><td>" . $row["status_inet"] . "</td><td>" . $row["upload"] . "</td><td>" . $row["download"] . "</td><td>" . $row["clid"] . "</td><td>" . $row["snr_up"] . "</td><td>" . $row["snr_down"] . "</td><td>" . $row["olt_rx"] . "</td><td>" . $row["onu_rx"] . "</td><td>" . $row["status_redaman"] . "</td><td>" . $row["stb_id"] . "</td><td>" . $row["last_view"] . "</td><td>" . $row["last_program"] . "</td><td>" . $row["stb_ip"] . "</td><td>" . $row["ukur_time_tv"] . "</td><td>" . $row["channel_ggn"] . "</td><td>" . $row["loker"] . "</td><td>" . $row["ip_ne"] . "</td><td>" . $row["node_id"] . "</td><td>" . $row["status_onu"] . "</td><td>" . $row["line_profile"] . "</td><td>" . $row["new_flag"] . "</td><td>" . $row["alpro"] . "</td><td>" . $row["last_start"] . "</td><td>" . $row["is_ukur_awal"] . "</td><td>" . $row["ukur_time_awal"] . "</td><td>" . $row["status_inet_awal"] . "</td><td>" . $row["upload_awal"] . "</td><td>" . $row["download_awal"] . "</td><td>" . $row["clid_awal"] . "</td><td>" . $row["snr_up_awal"] . "</td><td>" . $row["snr_down_awal"] . "</td><td>" . $row["olt_rx_awal"] . "</td><td>" . $row["onu_rx_awal"] . "</td><td>" . $row["status_redaman_awal"] . "</td><td>" . $row["last_start_awal"] . "</td><td>" . $row["ip_ne_awal"] . "</td><td>" . $row["node_id_awal"] . "</td><td>" . $row["status_onu_awal"] . "</td><td>" . $row["line_profile_awal"] . "</td><td>" . $row["sto"] . "</td><td>" . $row["workzone"] . "</td><td>" . $row["tanggal"] . "</td>

                  </tr>
                ";
                
              }
            
            
            
            $stmt->close();
            }

            echo "</table>";
            
            if ($stmt = $mysqli_history_rock->prepare("SELECT 
            COUNT(trouble_no) as number FROM history
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
