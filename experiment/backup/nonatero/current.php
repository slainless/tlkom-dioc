<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
    require $p_svropt;
    require $p_cdash;
    require $p_cnona;
        
    require_once $p_inc . "database/fetch_setting.php";
    require_once $p_inc . "login/fungsi.php";
    
    $per_page=50;
    
    if (isset($_GET["page"])) {
    $page = $_GET["page"];
    }
    else {
    $page=1;
    }
    
    if ($stmt = $que_nona->prepare("SELECT TANGGAL AS TANGGAL, COUNT(TROUBLE_NO) AS JUMLAH FROM " . $t_nona . " GROUP BY TANGGAL")) {
            
            $stmt->execute();   // Execute the prepared query.
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $date = $row["TANGGAL"];
                $ggn = $row["JUMLAH"];

                $update = date_format(date_create($row["TANGGAL"]),"d M Y");
            }

            $stmt->free_result();
            $stmt->close();
        }

    sec_session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $_SESSION['username']; ?> | Database Nonatero </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../../include/styles/reset.css" />

        <link rel="stylesheet" href="../styles/result.css" />
        <link rel="stylesheet" href="../styles/responsive-result.css" />
        <link rel="stylesheet" href="../styles/menu-result.css" />
        
        <link rel="stylesheet" href="../styles/font.css" />

        <link rel="icon" type="image/png" href="../../favicon.ico" sizes="32x32" />

        <script src="../lib/jquery-3.1.1.min.js"></script>
        <script src="../lib/jquery.stickytableheaders.min.js"></script>
      </head>
    <body>
    <div id="header">
        <div class="header-main">
            <h2>Table Current</h2>
            <h1>Nonatero</h1>
            <h2><?php echo $update; ?></h2>
        </div>
        <div class="header-option">
        </div>
    </div>
    <div id="content">
        <form method=POST name="query" >
            <table>
            <thead>
                <tr id="t-header">
                    <td>NO</td>
                    <td>WITEL</td>
                    <td>KANDATEL</td>
                    <td>CMDF</td>
                    <td>RK</td>
                    <td>CPROD</td>
                    <td>ND_TELP</td>
                    <td>ND_INT</td>
                    <td>PAKET_INT</td>
                    <td>PAKET_IPTV</td>
                    <td>GAUL_B0</td>
                    <td>GAUL_B1</td>
                    <td>GAUL_B2</td>
                    <td>GAUL30</td>
                    <td>GAUL30_BACK</td>
                    <td>LAPUL</td>
                    <td>TROUBLE_NO</td>
                    <td>TROUBLE_OPENTIME</td>
                    <td>HEADLINE</td>
                    <td>KELUHAN_DESC</td>
                    <td>STATUS</td>
                    <td>JAM</td>
                    <td>HARI</td>
                    <td>EMOSI_PLG</td>
                    <td>PRODUK_GGN</td>
                    <td>TIPE_TIKET</td>
                    <td>SMS_OPEN</td>
                    <td>SMS_BACKEND</td>
                    <td>SMS_RESOLVED</td>
                    <td>EMAIL_OPEN</td>
                    <td>EMAIL_BACKEND</td>
                    <td>EMAIL_RESOLVED</td>
                    <td>TROUBLE_CLOSED_GROUP</td>
                    <td>LOKER_DISPATCH</td>
                    <td>JML_LAPUL</td>
                    <td>CHANNEL</td>
                    <td>TANGGAL</td>
                </tr>
            </thead>
<?php

// Page will start from 0 and Multiple by Per Page
$start_from = ($page-1) * $per_page;

            if ($stmt = $que_nona->prepare("SELECT * 
            FROM nonatero LIMIT ?, ?")) {

            $stmt->bind_param("ii", $start_from, $per_page); 
            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            
            $no = $per_page * ($page-1);
            
            while($row = $result->fetch_assoc()) {
                $no = $no + 1;
                echo "
                <tbody>
                <tr>
                    <td>" . $no . "</td>
                    <td>" . $row["WITEL"] . "</td>
                    <td>" . $row["KANDATEL"] . "</td>
                    <td>" . $row["CMDF"] . "</td>
                    <td>" . $row["RK"] . "</td>
                    <td>" . $row["CPROD"] . "</td>
                    <td>" . $row["ND_TELP"] . "</td>
                    <td>" . $row["ND_INT"] . "</td>
                    <td>" . $row["PAKET_INT"] . "</td>
                    <td>" . $row["PAKET_IPTV"] . "</td>
                    <td>" . $row["GAUL_B0"] . "</td>
                    <td>" . $row["GAUL_B1"] . "</td>
                    <td>" . $row["GAUL_B2"] . "</td>
                    <td>" . $row["GAUL30"] . "</td>
                    <td>" . $row["GAUL30_BACK"] . "</td>
                    <td>" . $row["LAPUL"] . "</td>
                    <td>" . $row["TROUBLE_NO"] . "</td>
                    <td>" . $row["TROUBLE_OPENTIME"] . "</td>
                    <td>" . $row["HEADLINE"] . "</td>
                    <td>" . $row["KELUHAN_DESC"] . "</td>
                    <td>" . $row["STATUS"] . "</td>
                    <td>" . $row["JAM"] . "</td>
                    <td>" . $row["HARI"] . "</td>
                    <td>" . $row["EMOSI_PLG"] . "</td>
                    <td>" . $row["PRODUK_GGN"] . "</td>
                    <td>" . $row["TIPE_TIKET"] . "</td>
                    <td>" . $row["SMS_OPEN"] . "</td>
                    <td>" . $row["SMS_BACKEND"] . "</td>
                    <td>" . $row["SMS_RESOLVED"] . "</td>
                    <td>" . $row["EMAIL_OPEN"] . "</td>
                    <td>" . $row["EMAIL_BACKEND"] . "</td>
                    <td>" . $row["EMAIL_RESOLVED"] . "</td>
                    <td>" . $row["TROUBLE_CLOSED_GROUP"] . "</td>
                    <td>" . $row["LOKER_DISPATCH"] . "</td>
                    <td>" . $row["JML_LAPUL"] . "</td>
                    <td>" . $row["CHANNEL"] . "</td>
                    <td>" . $row["TANGGAL"] . "</td>
                </tr>
                </tbody>
                ";
                
              }
            
            
            
            $stmt->close();
            }
?>
            </table>
<?php
            if ($stmt = $que_nona->prepare("SELECT 
            COUNT(TROUBLE_NO) as number FROM nonatero")) {
            // Bind "$user_id" to parameter.
            $stmt->execute();   // Execute the prepared query.

            $stmt->bind_result($number);
            while($stmt->fetch()) {
              $total_records = $number;
            } }
            $stmt->close();
            
            echo "$total_records";
            
            $total_pages = ceil($total_records / $per_page);
?>
            <center>
            <input type='submit' formaction='?page=1' value='First'/>
<?php
            for ($i=1; $i<=$total_pages; $i++) {
                echo "<input type='submit' formaction='?page=".$i."' value='".$i."' /> ";
            };
?>
            <input type='submit' formaction='?page=<? echo $total_pages; ?>' value='Last' />
            </center>
        </form>
    </div>
    <input type="checkbox" name="check" class="altbar-cbox" id="toggle">
    <label for="toggle" class="altbar-toggle"><span>+</span></label>
    <div class="altbar">
                <div class="altbar-menu">
                    <ul>
                            <li><a href="../">STATISTIK</a></li>
                            <li class="dummy"></li>
                            <li><a href="../point/">POINT</a></li>
                            <li class="selected"><a href="#">NONATERO</a></li>
                            <li><a href="../rock/">ROCK</a></li>
                            <li class="dummy"></li>
                            <li><a href="../server/">SERVER</a></li>
                            <li><a href="../../include/login/logout.php">LOGOUT</a></li>
                    </ul>
                </div>
            </div>
    <div id="footer">
    </div>
    <script>
        $("table").stickyTableHeaders();
    </script>
    </body>
</html>

<?php
    mysqli_close($que_nona);
?>
