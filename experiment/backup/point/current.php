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
 
 
include_once "koneksi_db.php";
include_once($_SERVER["DOCUMENT_ROOT"] . "/regional7/include/login/fungsi.php");

sec_session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Database - POINT</title>
        <link rel="stylesheet" href="styles/main.css" />
        
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

  
    </head>
    <body>
    
    <form method=POST name="query" >
                    <table border='1'>
                  <tr>
                    <td>NO</td>
                    <td>TROUBLE_NO</td>
                    <td>CMDF</td>
                    <td>JENIS</td>
                    <td>STO</td>
                    <td>TOTAL POIN</td>
              <!--      <td>P_ORDER DEWA</td>
                    <td>P_MY INDIHOME</td>
                    <td>P_RIHANA</td>
                    <td>P_GAUL30 BACK</td>
                    <td>P_SLG</td>
                    <td>P_GGU TUA</td>
                    <td>P_PLASA</td>
                    <td>P_HARD COMPLAIN</td>
                    <td>P_LAPUL</td> -->
                    <td>GAUL30 BACK</td>
                    <td>HARI</td>
                    <td>JAM</td>
                    <td>CHANNEL</td>
                    <td>HARD COMPLAIN?</td>
                    <td>LAPUL</td>
                    <td>SLG</td>
                    <td>GGU</td>
                    <td>MY INDIHOME?</td>
                    <td>SLG?</td>
                    <td>ORDER DEWA?</td>
                    <td>RIHANA?</td>
                    <td>PLASA?</td>
                    <td>TIPE TIKET</td>																																			
                  </tr>
<?php

$start_from = ($page-1) * $per_page;
            
            if ($stmt = $mysqli_history_nona->prepare("SELECT * 
  FROM point_flg_acc ORDER BY TOTAL_P ASC LIMIT ?, ?")) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param("ii", $start_from, $per_page); 
            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            
            $no = $per_page * ($page-1);
            
            while($row = $result->fetch_assoc()) {
                $no = $no + 1;
                
                $jenis = substr($row["CMDF_RL"], 0, 2);
                if ($jenis == "GP")
                {
                  $echoj = "FTTH";
                }
                else
                {
                  if ($jenis == NULL)
                   {
                    $echoj = "";
                   }
                  else
                  {
                  $echoj = "NON-FTTH";
                  }
                }
                
                $sto = substr($row["CMDF_RL"], -3, 3);
                
                if($jenis == "GP" || $jenis == "MS")
                {
                  if($sto == "702" || $sto == "707")
                  {
                    $echos = "";
                  }
                  else
                  {
                    $echos = substr($row["CMDF_RL"], 2, 3);
                  }
                }
                else if($jenis != "GP" || $jenis != "MS")
                {
                  $echos = substr($row["CMDF_RL"], 0, 3);
                }
                else
                {
                  $echos = "";
                }
                
                
                echo "
                  <tr>
                    <td>" . $no . "</td>
                    <td>" . $row["TROUBLE_NO"] . "</td>
                    <td>" . $row["CMDF_RL"] . "</td>
                    <td>" . $echoj . "</td>
                    <td>" . $echos . "</td>
                    <td>" . $row["TOTAL_P"] . "</td>
                    <td>" . $row["GAUL30_BACK"] . "</td>
                    <td>" . $row["HARI"] . "</td>
                    <td>" . $row["JAM"] . "</td>
                    <td>" . $row["CHANNEL"] . "</td>
                    <td>" . $row["HARDCOM"] . "</td>
                    <td>" . $row["LAPUL"] . "</td>
                    <td>" . $row["SLG"] . "</td>
                    <td>" . $row["GGU"] . "</td>
                    <td>" . $row["INDI_F"] . "</td>
                    <td>" . $row["SLG_F"] . "</td>
                    <td>" . $row["ODW_F"] . "</td>
                    <td>" . $row["RHN_F"] . "</td>
                    <td>" . $row["PLS_F"] . "</td>
                    <td>" . $row["TIPE_CUST"] . "</td>
                  </tr>
                ";
                
              }
            
            
            
            $stmt->close();
            }

            echo "</table>";
            
            if ($stmt = $mysqli_history_nona->prepare("SELECT 
            COUNT(TROUBLE_NO) as number FROM point_flg_acc")) {
            // Bind "$user_id" to parameter.
            $stmt->execute();   // Execute the prepared query.

            $stmt->bind_result($number);
            while($stmt->fetch()) {
              $total_records = $number;
            } 

              $stmt->close();
            }
  
            echo "</table>";
            
            echo "$total_records";
            

            
            
            $total_pages = ceil($total_records / $per_page);

echo "<center><input type='submit' formaction='?page=1' value='First'/> ";

for ($i=1; $i<=$total_pages; $i++) {
echo "<input type='submit' formaction='?page=".$i."' value='".$i."' /> ";
};
echo "<input type='submit' formaction='?page=" . $total_pages . "' value='Last' /></center> ";


mysqli_close($mysqli);
mysqli_close($mysqli_history_rock);
mysqli_close($mysqli_history_nona);
mysqli_close($mysqli_point);
?>
</form>
    </body>
</html>
