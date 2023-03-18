<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $p_incl."login/function.php";

    require $webframe."webf_function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "point";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "Point | Current";

    sec_session_start();

    if(login_check($query)):

    require "plasa_proses.php";
    require "dewa_proses.php";
    require "rihana_proses.php";
    
    $per_page=50;

    if(!isset($cf)) {
        $cf = false;
    }

    if(!isset($_GET["page"])) {
        $page=1;
    }
    else {
        $page = $_GET["page"];
    }

    $start_from = ($page-1) * $per_page;

    if ($stmt = $query->prepare("SELECT STO 
    FROM ".$t_point." GROUP BY STO"))
    {

        $stmt->execute();
        
        $sto_list = $stmt->get_result();
        $stmt->close();

        $op_sto = array();

        $op_sto[0][0] = "0";
        $op_sto[0][1] = "# STO";
        $op_sto[0][2] = "1";

        $x = 1;
        while($row = $sto_list->fetch_assoc()) {
            $op_sto[$x][0] = $x;
            if($row["STO"] != ''){
                $op_sto[$x][1] = $row["STO"];
                $op_sto[$x][2] = $row["STO"];
            }
            else {
                $op_sto[$x][1] = "NO STO";
                $op_sto[$x][2] = "";
            }
            $x++;
        }
    }

    if ($stmt = $query->prepare("SELECT CMDF 
    FROM ".$t_nona_sto." GROUP BY CMDF"))
    {

        $stmt->execute();
        
        $cmdf_list = $stmt->get_result();
        $stmt->close();

        $cmdf_sto = array();

        $cmdf_sto[0][0] = "0";
        $cmdf_sto[0][1] = "0";

        $x = 1;
        while($row = $cmdf_list->fetch_assoc()) {
            if($row["CMDF"] != ''){
                $cmdf_sto[$x][0] = $x;
                $cmdf_sto[$x][1] = $row["CMDF"];

                $x++;
            }
        }       
    }

    if ($stmt = $query->prepare("SELECT GAUL30_BACK 
    FROM ".$t_nona." GROUP BY GAUL30_BACK"))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $op_gaul30 = array();

        $op_gaul30[0][0] = "0";
        $op_gaul30[0][1] = "# GAUL";
        $op_gaul30[0][2] = "1";

        $x = 1;
        while($row = $result->fetch_assoc()) {
            $op_gaul30[$x][0] = $x;
            $op_gaul30[$x][1] = "GAUL: ".$row["GAUL30_BACK"];
            $op_gaul30[$x][2] = $row["GAUL30_BACK"];

            $x++;
        }
    }

    $op_plg = array(
        array(0,"# Tipe PLG",1),
        array(1,"Silver","SILVER"),
        array(2,"Titanium","TITANIUM/GOLD"),
        array(3,"Platinum","PLATINUM"),
        array(4,"Business","BUSINESS"),
        array(5,"Enterprise","ENTERPRISE")
    );

    $op_alpro = array(
        array(0,"# Jenis Alpro",1),
        array(1,"FTTH","FTTH"),
        array(2,"NON-FTTH","NON-FTTH")
    );

    $op_channel = array(
        array(0,"# Channel",1),
        array(1,"147","147"),
        array(2,"C4 DES","C4 DES"),
        array(3,"Media Sosial","MEDIA SOSIAL"),
        array(4,"My Indihome","MY INDIHOME"),
        array(5,"Plasa","PLASA"),
        array(6,"TAM DBS","TAM DBS"),
    );

    $op_hari = array(
        array(0,"# Hari",1),
        array(1,"< 1 HARI",0),
        array(2,"1 - 2 HARI",2),
        array(3,"2 - 3 HARI",3),
        array(4,"4 - 7 HARI",7),
        array(5,"8 - 15 HARI",15),
        array(6,"16 - 30 HARI",30),
        array(7,"> 30 HARI",31),
    );

    $op_hc = array(
        array(0,"# Hardcomplain",1),
        array(1,"Hardcomplain: No",0),
        array(2,"Hardcomplain: Yes",1),
    );

    $op_indi = array(
        array(0,"# My Indihome",1),
        array(1,"My Indihome: No",0),
        array(2,"My Indihome: Yes",1),
    );

    $op_dewa = array(
        array(0,"# Order Dewa",1),
        array(1,"Order Dewa: No",0),
        array(2,"Order Dewa: Yes",1),
    );

    $op_plasa = array(
        array(0,"# Plasa",1),
        array(1,"Plasa: No",0),
        array(2,"Plasa: Yes",1),
    );

    $op_rihana = array(
        array(0,"# Rihana",1),
        array(1,"Rihana: No",0),
        array(2,"Rihana: Yes",1),
    );
    $op_g3p = array(
        array(0,"# GGN 3P",1),
        array(1,"GGN 3P: No",0),
        array(2,"GGN 3P: Yes",1),
    );

    if(isset($_GET["indi"], $_GET["plg"], $_GET["sto"], $_GET["dewa"], $_GET["alpro"], $_GET["channel"], $_GET["plasa"], $_GET["hari"], $_GET["hc"], $_GET["rihana"], $_GET["g3p"], $_GET["gaul"]) && empty($_GET["search"])){
        if($_GET["indi"] == 0){
            $indi = 1;
        }
        else {
            if(empty(arlookup($_GET["indi"], $op_indi, 1))){
                $indi = 1;
            }
            else {
                $indi = "INDI_F = '".$op_indi[arlookup($_GET["indi"], $op_indi, 1)][2]."'";
            }
        }

        if($_GET["plg"] == 0){
            $plg = 1;
        }
        else {
            if(empty(arlookup($_GET["plg"], $op_plg, 1))){
                $plg = 1;
            }
            else {
                $plg = "TIPE_CUST = '".$op_plg[arlookup($_GET["plg"], $op_plg, 1)][2]."'";
            }
        }

        if($_GET["sto"] == 0){
            $sto = 1;
        }
        else {
            if(empty(arlookup($_GET["sto"], $op_sto, 1))){
                $sto = 1;
            }
            else {
                $sto = "STO = '".$op_sto[arlookup($_GET["sto"], $op_sto, 1)][2]."'";
            }
        }

        if($_GET["dewa"] == 0){
            $dewa = 1;
        }
        else {
            if(empty(arlookup($_GET["dewa"], $op_dewa, 1))){
                $dewa = 1;
            }
            else {
                $dewa = "ODW_F = '".$op_dewa[arlookup($_GET["dewa"], $op_dewa, 1)][2]."'";
            }
        }

        if($_GET["alpro"] == 0){
            $alpro = 1;
        }
        else {
            if(empty(arlookup($_GET["alpro"], $op_alpro, 1))){
                $alpro = 1;
            }
            else {
                $alpro = "JENIS = '".$op_alpro[arlookup($_GET["alpro"], $op_alpro, 1)][2]."'";
            }
        }

        if($_GET["channel"] == 0){
            $channel = 1;
        }
        else {
            if(empty(arlookup($_GET["channel"], $op_channel, 1))){
                $channel = 1;
            }
            else {
                $channel = "CHANNEL = '".$op_channel[arlookup($_GET["channel"], $op_channel, 1)][2]."'";
            }
        }

        if($_GET["plasa"] == 0){
            $plasa = 1;
        }
        else {
            if(empty(arlookup($_GET["plasa"], $op_plasa, 1))){
                $plasa = 1;
            }
            else {
                $plasa = "PLS_F = '".$op_plasa[arlookup($_GET["plasa"], $op_plasa, 1)][2]."'";
            }
        }

        if($_GET["hari"] == 0){
            $hari = 1;
        }
        else {
            if(empty(arlookup($_GET["hari"], $op_hari, 1))){
                $hari = 1;
            }
            else {
                $hari = arlookup($_GET["hari"], $op_hari, 1);
                switch ($hari){
                    case 1:
                        $hari = "JAM < 24";
                        break;
                    case 2:
                        $hari = "JAM >= 24 AND JAM < 72"; //1-2
                        break;
                    case 3:
                        $hari = "JAM >= 48 AND JAM < 96"; //2-3
                        break;
                    case 4:
                        $hari = "JAM >= 96 AND JAM < 192"; //4-7
                        break;
                    case 5:
                        $hari = "JAM >= 192 AND JAM < 384"; //8-15
                        break;
                    case 6:
                        $hari = "JAM >= 384 AND JAM < 744"; //16-30
                        break;
                    case 7:
                        $hari = "JAM >= 744"; //30
                        break;
                    }
            }
        }

        if($_GET["hc"] == 0){
            $hc = 1;
        }
        else {
            if(empty(arlookup($_GET["hc"], $op_hc, 1))){
                $hc = 1;
            }
            else {
                $hc = "HARDCOM = '".$op_hc[arlookup($_GET["hc"], $op_hc, 1)][2]."'";
            }
        }

        if($_GET["gaul"] == 0){
            $gaul = 1;
        }
        else {
            if(empty(arlookup($_GET["gaul"], $op_gaul30, 1))){
                $gaul = 1;
            }
            else {
                $gaul = "GAUL30_BACK = '".$op_gaul30[arlookup($_GET["gaul"], $op_gaul30, 1)][2]."'";
            }
        }

        if($_GET["rihana"] == 0){
            $rihana = 1;
        }
        else {
            if(empty(arlookup($_GET["rihana"], $op_rihana, 1))){
                $rihana = 1;
            }
            else {
                $rihana = "RHN_F = '".$op_rihana[arlookup($_GET["rihana"], $op_rihana, 1)][2]."'";
            }
        }

        if($_GET["g3p"] == 0){
            $g3p = 1;
        }
        else {
            if(empty(arlookup($_GET["g3p"], $op_g3p, 1))){
                $g3p = 1;
            }
            else {
                $g3p = "GGN_3P_F = '".$op_g3p[arlookup($_GET["g3p"], $op_g3p, 1)][2]."'";
            }
        }

        $cf = true;

    }




    if($cf == true){
        $condition = " WHERE ".$indi." AND ".$plg." AND ".$sto." AND ".$dewa." AND ".$alpro." AND ".$channel." AND ".$plasa." AND ".$hari." AND ".$hc." AND ".$rihana." AND ".$g3p." AND ".$gaul."";
    }
    else {
        $condition = "";
    }

    if(!empty($_GET["search"])){
        $param = "%{$_GET['search']}%";
        $condition = " WHERE ND_TELP LIKE ? OR ND_INT LIKE ? OR TROUBLE_NO LIKE ?";

    }

    $order = " ORDER BY TOTAL_P ASC";

    if ($stmt = $query->prepare("SELECT * 
    FROM " . $t_point . "" . $condition . "" . $order . " LIMIT ?, ?")) {

            if(empty($_GET["search"])){
                $stmt->bind_param("ii", $start_from, $per_page); 
            }
            else if(!empty($_GET["search"])){
                $stmt->bind_param("sssii", $param, $param, $param, $start_from, $per_page); 
            }
            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            $stmt->close();
            
            $no = $per_page * ($page-1);
    }

    if ($stmt = $query->prepare("SELECT 
    COUNT(TROUBLE_NO) as number FROM " . $t_point . "" . $condition . "")) {
        // Bind "$user_id" to parameter.
        $stmt->execute();   // Execute the prepared query.

        $stmt->bind_result($total_records);
        $stmt->fetch();

        $stmt->close();
    }
    
    $total_pages = ceil($total_records / $per_page);
?>

<!DOCTYPE html>
<html div class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickyfooter.min.js", $path_level); ?>"></script>

    <script src="<?php pathcv($path_type, "js/components/datepicker.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
    <link rel="stylesheet" href="<?php pathcv($path_type, "js/spectrum.css", $path_level); ?>">
    <script src="<?php pathcv($path_type, "js/spectrum.js", $path_level); ?>"></script>
    <style>
        .uk-dropdown.uk-datepicker, .uk-dropdown.uk-datepicker a {
            color: white;
        }
        .uk-dropdown.uk-datepicker a:hover {
            color: dodgerblue;
        }
    </style>
    </head>
    <body class="uk-height-1-1">
    
    <div id="sidebar" class="sd-offcanvas uk-offcanvas">
        <div class="uk-offcanvas-bar sd-offcanvas-bar">
                <form class="uk-form uk-width-1-1" action="" method="GET" id="option-form">
                <div class="uk-grid"  style="height: 100%">
                    <div class="uk-width-1-1">
                        <div class="uk-panel-space uk-text-center"><img src="<?php pathcv($path_type, "assets/stardusk-brand.svg", $path_level); ?>" style=""></div>
                    </div>
                    <div class="uk-width-8-10 uk-container-center">
                    <input type="hidden" id="format" value="" name="format">
                        <div>
                            <h3 class="uk-contrast">SEARCH</h3>
                        </div>
                        <div>
                            <input type="text" name="search" class="uk-width-1-1" placeholder="ex. 0411245378">
                        </div>
                        <hr class="uk-grid-divider"></hr>
                        <div class="uk-grid uk-grid-small uk-grid-width-1-1 sd-sidebar-menu">
                            <div>
                                <select class="uk-width-1-1" name="indi">
                                    <?php print_option($_GET["indi"], $op_indi); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="plg">
                                    <?php print_option($_GET["plg"], $op_plg); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="sto">
                                    <?php print_option($_GET["sto"], $op_sto); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="dewa">
                                    <?php print_option($_GET["dewa"], $op_dewa); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="alpro">
                                    <?php print_option($_GET["alpro"], $op_alpro); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="channel">
                                    <?php print_option($_GET["channel"], $op_channel); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="plasa">
                                    <?php print_option($_GET["plasa"], $op_plasa); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="hari">
                                    <?php print_option($_GET["hari"], $op_hari); ?>
                                </select>
                            </div>
                                                                <div>
                                    <select class="uk-width-1-1" name="gaul">
                                        <?php print_option($_GET["gaul"], $op_gaul30); ?>
                                    </select>
                                    </div>
                            <div>
                                <select class="uk-width-1-1" name="hc">
                                    <?php print_option($_GET["hc"], $op_hc); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="rihana">
                                    <?php print_option($_GET["rihana"], $op_rihana); ?>
                                </select>
                            </div>
                            <div>
                                <select class="uk-width-1-1" name="g3p">
                                    <?php print_option($_GET["g3p"], $op_g3p); ?>
                                </select>
                            </div>
                            <div class="uk-clearfix">
                                <button class="uk-button uk-button-primary uk-float-right">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <div class="uk-width-1-1 sd-content sd-table sd-table-point">
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead class="uk-contrast">
                    <tr>
                        <td colspan="19"><a href="#sidebar" class="sd-offcanvas-toggle" data-uk-offcanvas="{mode:'slide'}"><i class="uk-icon-medium uk-icon-chrome uk-icon-spin"></i></a>
                        <div class='uk-button-dropdown sd-table-dropdown' data-uk-dropdown='{mode: "click"}'>
                            <a id="download" class="sd-offcanvas-toggle uk-margin-small-left"><i class="uk-icon-medium uk-icon-cloud-download"></i></a>
                            <div class='uk-dropdown uk-contrast'>
                                <ul class='uk-nav uk-nav-dropdown'>
                                    <li><a id="csv"><span class="uk-icon-file-text-o uk-icon-justify"></span> Download as CSV</a></li>
                                    <li><a id="xls"><span class="uk-icon-file-excel-o uk-icon-justify"></span> Download as XLS</a></li>
                                </ul>
                        </div>
                        <?php if(!empty($condition)):?>
                            <span class="uk-margin-left">Result: <span class="uk-text-bold"><?php echo $total_records; ?></span>, Page: <span class="uk-text-bold"><?php echo $total_pages; ?></span></span>
                        <?php endif; ?>
                        </td>
                        <td colspan="1" class="uk-clearfix"><a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>" class="sd-offcanvas-toggle uk-float-right"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a></td>
                    </tr>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Info Tiket</th>
                        <th rowspan="2">Total Poin</th>
                        <th colspan="10" style="border-bottom: 1px solid white;">Poin</th>
                        <th rowspan="2">Jam/Hari</th>
                        <th rowspan="2">Lapul</th>
                        <th rowspan="2">Gaul</th>
                        <th rowspan="2">SLG</th>
                        <th rowspan="2">Info STO</th>
                        <th rowspan="2" <?php if($_SESSION["level"] > 2) echo "colspan = 2"; ?>>Keterangan</th>
                        <?php if($_SESSION["level"] < 3) echo "<th rowspan='2'></th>";?>
                    </tr>
                    <tr class="uk-text-small">
                        <th>Order Dewa</th>
                        <th>My Indi</th>
                        <th>Rihana</th>
                        <th>GGN 3P</th>
                        <th>Gaul</th>
                        <th>SLG</th>
                        <th>GGU TUA</th>
                        <th>Plasa</th>
                        <th>Hardcom</th>
                        <th>Lapul</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $count_current = 0;
                while($row = $result->fetch_assoc()):

                switch ($row["MITRA"]) {
                    case 'PT. TA':
                        $row["MITRA"] = 'PT.TA';
                        break;
                }
/*                $row["LAPUL"] = "[LAPUL : ".$row["LAPUL"]."]";
                $row["GAUL30_BACK"] = "[GAUL : ".$row["GAUL30_BACK"]."]";*/
                if($row["STO"] == ''){
                    $row["STO"] = "-";
                }
                // $row["SLG"] = "[SLG : ".$row["SLG"]."]";
                $no = $no + 1;

                switch ($row["TIPE_CUST"]) {
                    case 'SILVER':
                        $badge_cust = "' style='background-color: silver;";
                        break;
                    case 'TITANIUM/GOLD':
                        $badge_cust = "' style='background-color: goldenrod;";
                        $row["TIPE_CUST"] = 'TITANIUM';
                        break;
                    case 'PLATINUM':
                        $badge_cust = "' style='background-color: gray;";
                        break;
                    case 'BUSINESS':
                        $badge_cust = "' style='background-color: seagreen;";
                        break;
                    case 'ENTERPRISE':
                        $badge_cust = 'sd-badge sd-badge-ent';
                        break;
                }

                switch ($row["JENIS"]) {
                    case 'FTTH':
                        $badge_jenis = 'uk-badge-success';
                        break;
                    case 'NON-FTTH':
                        $badge_jenis = 'uk-badge-danger';
                        break;
                    default:
                        $badge_jenis = 'sd-super-hidden';
                        break;
                }

                switch ($row["SEGMEN"]) {
                    case 'INNER':
                        $badge_segmen2 = '';
                        $badge_segmen = 'uk-icon-sign-in';
                        break;
                    case 'OUTER':
                        $badge_segmen2 = '';
                        $badge_segmen = 'uk-icon-sign-out';
                        break;
                    default:
                        $badge_segmen2 = 'sd-super-hidden';
                        $badge_segmen = 'sd-super-hidden';
                        break;
                }

                if(empty($row["ND_TELP"])){
                    $default_cmdf = $row["ND_INT"];
                }
                else {
                    $default_cmdf = $row["ND_TELP"];
                }

                $pcs_arlen_sto = count($cmdf_sto);
                for($y = 0; $y < $pcs_arlen_sto; $y++) {

                    if($row["CMDF_RL"] == $cmdf_sto[$y][1]) {

                        $default_index = $cmdf_sto[$y][0];
                        break 1;
                    }
                }

                ?>
                    <tr>
                        <td><?php echo $no; ?>
                        </td>
                        <td>
                            <span class="tiket uk-text-bold"><?php echo $row["TROUBLE_NO"]; ?></span><br>
                            <span class="nd_telp"><?php echo $row["ND_TELP"]; ?></span><br>
                            <span class="nd_int"><?php echo $row["ND_INT"]; ?></span><br>
                            <span class='uk-badge <?php echo $badge_cust; ?>'><?php echo $row["TIPE_CUST"]; ?></span>
                        </td>
                        <td>
                            <span class=" uk-text-bold"><?php echo $row["TOTAL_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["ORDER_DEWA_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["MY_INDIHOME_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["RIHANA_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["GGN_3P_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["GAUL30_BACK_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["SLG_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["GGU_TUA_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["PLS_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["HCM_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["LAPUL_P"]; ?></span><br>
                        </td>
                        <td>
                            <span><?php echo $row["JAM"]; ?></span><br>
                            (<span class="uk-text-bold"><?php echo $row["HARI"]; ?></span>)
                        </td>
                        <td>
                            <span><?php echo $row["LAPUL"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["GAUL30_BACK"]; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row["SLG"]; ?></span>
                        </td>
                        <td>
                            <span class='uk-badge jenis <?php echo $badge_jenis; ?>'><?php echo $row["JENIS"]; ?></span>
                            <span class='uk-badge <?php echo $badge_segmen2; ?> segmen'><span class='<?php echo $badge_segmen; ?>' style='margin-right: 5px;'></span><?php echo $row["SEGMEN"]; ?></span><br>
                            [<span class="uk-text-bold"><?php echo $row["STO"]; ?></span>]<span class="uk-hidden sto"><?php echo $row["CMDF_RL"]; ?></span><br>
                            <span class="mitra"><?php echo $row["MITRA"]; ?></span>
                        </td>
                        <td <?php if($_SESSION["level"] > 2) echo "colspan = 2"; ?>>
                        <?php 
                        $br = 0;
                        if($row["HARDCOM"] == 1): ?>
                            <span class='uk-badge uk-badge-danger'>HARD COMPLAIN</span>
                        <?php $br = 1; endif; ?>
                        <?php if($row["CHANNEL"] == 'MY INDIHOME'): ?>
                            <span class='uk-badge'>MY INDIHOME</span>
                        <?php $br = 1; endif; ?>
                        <?php if($row["GGN_3P_F"] == 1): ?>
                            <span class='uk-badge uk-badge-warning'>GANGGUAN 3P</span>
                        <?php $br = 1; endif; ?>
                        <?php if($br == 1){ echo "<br>"; $br = 0; } ?>
                            [CHANNEL : <span class="uk-text-bold"><?php echo $row["CHANNEL"]; ?></span>]
                        </td>
                        <?php if($_SESSION["level"] < 3): ?>
                        <td>
                            <a class="uk-button uk-button-primary uk-margin-small-bottom"><span class='uk-icon-eye uk-icon-justify'></span></a>
                            <div class='uk-button-dropdown sd-table-dropdown' data-uk-dropdown='{pos: "right-top", mode: "click"}'>
                            <a class="uk-button uk-button-success"><span class='uk-icon-pencil-square-o uk-icon-justify'></span></a>
                            <div class='uk-dropdown uk-contrast'>
                                <ul class='uk-nav uk-nav-dropdown uk-dropdown-close'>
                                    <li><a class='submit-rihana uk-link' href="#inputpop" data-uk-modal>Insert/Edit in Rihana</a></li>
                                    <li><a class='submit-plasa uk-link' href="#inputpop" data-uk-modal>Insert/Edit in Plasa</a></li>
                                    <li><a class='submit-dewa uk-link' href="#inputpop" data-uk-modal>Insert/Edit in Order Dewa</a></li>
                                    <li class='uk-nav-divider'></li>
                                    <li><a class='submit-cmdf uk-link'>Insert/Edit in CMDF</a></li>
                                    <li><a href='point_config.php' target="_blank">Edit Point Config</a></li>
                                </ul>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
               <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="uk-width-1-1 sd-pagination">
            <ul class="uk-pagination uk-panel-space">
                <li><button class="uk-pagination-previous" type="submit" form="option-form" name="page" value="1">First</button></li>
                <?php
                    // ex:
                    // sp 3 4 5 ep
                    // 4 - 2 = 2
                    $startp = $page - 2;
                    if($startp < 1){
                        $startp = 1;
                    }

                    $endp = $page + 2;
                    $condp = $total_pages - $page;
                    if($condp < 2){
                        $endp = $total_pages;
                    }

                    for ($i=$startp; $i<=$endp; $i++):
                        if(($startp > 2) && $i == $startp): ?>
                            <li><button class='sd-disabled' disabled>..</button></li>
                        <?php endif;
                        if($startp == 2 && $i == $startp): ?>
                            <li><button type='submit' form='option-form' name='page' value='<?php echo 1; ?>'><?php echo 1; ?></button></li>
                        <?php endif;
                        if($page == $i): ?>
                            <li><button class='uk-active sd-disabled' type='submit' form='option-form' name='page' value='<?php echo $i;?>' disabled><?php echo $i;?></button></li>
                        <?php else: ?>
                            <li><button type='submit' form='option-form' name='page' value='<?php echo $i; ?>'><?php echo $i; ?></button></li>
                        <?php endif;
                        if($condp == 3 && $i == $endp): $i++; ?>
                            <li><button type='submit' form='option-form' name='page' value='<?php echo $i; ?>'><?php echo $i; ?></button></li>
                        <?php endif;
                        if(($condp > 3) && $i == $endp):?>
                            <li><button class='sd-disabled' disabled>..</button></li>
                        <?php endif;
                    endfor;
                ?>
                <li><button class="uk-pagination-next" type="submit" form="option-form" name="page" value="<?php echo $total_pages; ?>">Last</button></li>
            </ul>
        </div>
    </div>
    <div class="uk-modal" id="inputpop">
        <div class="uk-modal-dialog sd-background-none" id="modalbox">
        </div>
    </div>
    <script>
    $('.uk-table').stickyTableHeaders();

    $( ".submit-cmdf" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var sto = tr.find(".sto").text();
            var telp = tr.find(".nd_telp").text();
            var int = tr.find(".nd_int").text();

            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", sto).attr("name", "sto").attr("class", "inputinfo");
            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", int).attr("name", "nd_int").attr("class", "inputinfo");
            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", telp).attr("name", "nd_telp").attr("class", "inputinfo");

            form.attr("action", "../nonatero/cmdf.php");
            form.submit();

            $(".inputinfo").remove();
        });

        $( ".submit-dewa" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

/*            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("action", "../point/dewa_edit.php");
            form.submit();

            $(".inputinfo").remove();*/
            $.post( "<?php pathcv($path_type, "dashboard/point/dewa_module.php", $path_level); ?>", { itiket: tiket }, function( data ) {
                $( "#modalbox" ).html( data );
            });
        });

        $( ".submit-rihana" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

/*            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("action", "../point/rihana_edit.php");
            form.submit();

            $(".inputinfo").remove();*/

            $.post( "<?php pathcv($path_type, "dashboard/point/rihana_module.php", $path_level); ?>", { itiket: tiket }, function( data ) {
                $( "#modalbox" ).html( data );
            });
        });

        $( ".submit-plasa" ).click(function() {
          var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

/*            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("action", "../point/plasa_edit.php");
            form.submit();

            $(".inputinfo").remove();
            // $( '#modalbox' ).load( '' );*/
            $.post( "<?php pathcv($path_type, "dashboard/point/plasa_module.php", $path_level); ?>", { itiket: tiket }, function( data ) {
                $( "#modalbox" ).html( data );
            });
        });

        $( "#csv" ).click(function() {
            var form = $("#option-form");
            var format = $("#format");

            form.attr("action", "download.php");
            format.attr("value", "1");
            form.submit();
            form.attr("action", "");
            format.attr("value", "");
        });

        $( "#xls" ).click(function() {
            var form = $("#option-form");
            var format = $("#format");

            form.attr("action", "download.php");
            format.attr("value", "2");
            form.submit();
            form.attr("action", "");
            format.attr("value", "");
        });

    <?php if(!empty($message)): ?>                   
                UIkit.notify("<?php echo $message; ?>", {timeout: 3000, status:'<?php echo $alert; ?>'});
    <?php endif; ?>
    </script>
    <div class="sd-backtop">
        <a href="#top" data-uk-smooth-scroll><span class="uk-icon-angle-up uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
        <a href="#bottom" data-uk-smooth-scroll><span class="uk-icon-angle-down uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
    </div>
    <div id="bottom"></div>
    <form action='' method='POST' id='sub-option' target="_blank">
        <div id="container"></div>
    </form>
    </body>
</html>

<?php
    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>