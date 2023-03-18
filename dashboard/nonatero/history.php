<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "Nonatero | History";
    
    $per_page=50;

    sec_session_start();

    if(login_check($query)):

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
    FROM ".$t_nona_h." GROUP BY STO"))
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

    $op_tiket = array(
        array(0,"# Tipe Tiket",1),
        array(1,"Fisik","FISIK"),
        array(2,"Billing","BILLING"),
        array(3,"Logic","LOGIC"),
        array(4,"Non-Teknis","NON-TEKNIS")
    );

    $op_plg = array(
        array(0,"# Tipe PLG",1),
        array(1,"Silver","SILVER"),
        array(2,"Titanium","TITANIUM/GOLD"),
        array(3,"Platinum","PLATINUM"),
        array(4,"Business","BUSINESS"),
        array(5,"Enterprise","ENTERPRISE")
    );

    $op_produk = array(
        array(0,"# Produk GGN",1),
        array(1,"Internet","INTERNET"),
        array(2,"IPTV","IPTV"),
        array(3,"Telepon","TELEPON")
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

    $op_emosi = array(
        array(0,"# Emosi PLG",1),
        array(1,"Ramah","Ramah"),
        array(2,"Agak Marah","Agak Marah"),
        array(3,"Marah","Marah"),
    );

    $op_hari = array(
        array(0,"# Hari",1),
        array(1,"3 > Hari",0),
        array(2,"8 > Hari > 3",3),
        array(3,"16 > Hari > 7",8),
        array(4,"22 > Hari > 15",16),
        array(5,"31 > Hari > 21",22),
        array(6,"Hari > 30",31),
    );

    $op_hc = array(
        array(0,"# Hardcomplain",1),
        array(1,"Not Hardcomplain",0),
        array(2,"Hardcomplain",1),
    );

    $op_g3p = array(
        array(0,"# GGN 3P",1),
        array(1,"Not GGN 3P",0),
        array(2,"GGN 3P",1),
    );

    $datestart = '';
    $dateend = '';

    if(!isset($_GET["datestart"]) || empty($_GET["datestart"])){
            $time = "";
    }

    if(isset($_GET["tiket"], $_GET["plg"], $_GET["sto"], $_GET["produk"], $_GET["alpro"], $_GET["channel"], $_GET["emosi"], $_GET["hari"], $_GET["hc"], $_GET["g3p"]) && empty($_GET["search"])){

        if($_GET["tiket"] == 0){
            $tiket = 1;
        }
        else {
            if(empty(arlookup($_GET["tiket"], $op_tiket, 1))){
                $tiket = 1;
            }
            else {
                $tiket = "TIPE_TIKET = '".$op_tiket[arlookup($_GET["tiket"], $op_tiket, 1)][2]."'";
            }
        }


        if(!isset($_GET["datestart"]) || empty($_GET["datestart"])){
            $time = "";
        }
        else{
                if(empty($_GET["dateend"]))
                {
                    $dateend = date("Y-m-d");
                }
                else {
                    $dateend = $_GET["dateend"];
                }

                $datestart = $_GET["datestart"];
                $time = " AND DATE(TANGGAL) BETWEEN ? AND ?";
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

        if($_GET["produk"] == 0){
            $produk = 1;
        }
        else {
            if(empty(arlookup($_GET["produk"], $op_produk, 1))){
                $produk = 1;
            }
            else {
                $produk = "PRODUK_GGN = '".$op_produk[arlookup($_GET["produk"], $op_produk, 1)][2]."'";
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

        if($_GET["emosi"] == 0){
            $emosi = 1;
        }
        else {
            if(empty(arlookup($_GET["emosi"], $op_emosi, 1))){
                $emosi = 1;
            }
            else {
                $emosi = "EMOSI_PLG = '".$op_emosi[arlookup($_GET["emosi"], $op_emosi, 1)][2]."'";
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
                        $hari = "HARI < 3";
                        break;
                    case 2:
                        $hari = "HARI > 3 AND HARI < 8";
                        break;
                    case 3:
                        $hari = "HARI > 7 AND HARI < 16";
                        break;
                    case 4:
                        $hari = "HARI > 15 AND HARI < 22";
                        break;
                    case 5:
                        $hari = "HARI > 21 AND HARI < 31";
                        break;
                    case 6:
                        $hari = "HARI > 30";
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
        $condition = " WHERE ".$tiket." AND ".$plg." AND ".$sto." AND ".$produk." AND ".$alpro." AND ".$channel." AND ".$emosi." AND ".$hc." AND ".$hari." AND ".$g3p."";
    }
    else {
        $condition = "";
    }

    if(!empty($_GET["search"])){
        $param = "%{$_GET['search']}%";
        $condition = " WHERE ND_TELP LIKE ? OR ND_INT LIKE ? OR TROUBLE_NO LIKE ?";

    }

    if ($stmt = $query->prepare("SELECT * 
    FROM " . $t_nona_h . "" . $condition . "" . $time . " LIMIT ?, ?")) {

            if(empty($_GET["search"])){
                if(empty($_GET["datestart"])){
                    $stmt->bind_param("ii", $start_from, $per_page);
                }
                else {
                    $stmt->bind_param("ssii", $datestart, $dateend, $start_from, $per_page);
                }
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
    COUNT(TROUBLE_NO) as number FROM " . $t_nona_h . "" . $condition . "" . $time . "")) {
        // Bind "$user_id" to parameter.
        if(!empty($datestart)){
            $stmt->bind_param("ss", $datestart, $dateend);
        }
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
    <script src="<?php pathcv($path_type, "js/components/datepicker.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickyfooter.min.js", $path_level); ?>"></script>
    <style>

        .uk-dropdown.uk-datepicker, .uk-dropdown.uk-datepicker a {
            color: white;
        }
        .uk-dropdown.uk-datepicker a:hover {
            color: dodgerblue;
        }
    
    </style>
    </head>
    <body>
    <div class="uk-grid">
   
    <input type="hidden" name="nd" value="">
        <div id="sidebar" class="sd-offcanvas uk-offcanvas">
        <div class="uk-offcanvas-bar sd-offcanvas-bar">
         <form class="uk-form uk-width-1-1" action="" method="GET" id="option-form">
                <div class="uk-grid"  style="height: 100%">
                    <div class="uk-width-8-10 uk-container-center uk-margin-top">
                        <div><h3 class="uk-contrast">SEARCH</h3></div>
                            <div>
                                <input type="text" name="search" class="uk-width-1-1 uk-margin-small-bottom" placeholder="ex. 0411245378">
                                <div class="uk-width-1-1">
                                    <div class="uk-grid uk-grid-small" data-uk-grid-margin=""">
                                    <div class="uk-form-icon uk-width-1-1">
                                        <i class="uk-icon-calendar-times-o""></i>
                                        <input type='text' placeholder='START' class='uk-width-1-1' name="datestart" value="<?php echo $datestart; ?>" data-uk-datepicker>
                                    </div>
                                    <div class="uk-form-icon uk-width-1-1 uk-margin-small-top">
                                        <i class="uk-icon-calendar-times-o""></i>
                                        <input type='text' placeholder='END' class='uk-width-1-1' name="dateend" value="<?php echo $dateend; ?>" data-uk-datepicker>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <hr class="uk-grid-divider"></hr>
                        <div><h3 class="uk-contrast">FILTER</h3></div>
                        <div class="uk-grid uk-grid-small uk-grid-width-1-1 sd-sidebar-menu">
                            <div>
                                    <select class="uk-width-1-1" name="tiket">
                                        <?php print_option($_GET["tiket"], $op_tiket); ?>
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
                                    <select class="uk-width-1-1" name="produk">
                                        <?php print_option($_GET["produk"], $op_produk); ?>
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
                                    <select class="uk-width-1-1" name="emosi">
                                        <?php print_option($_GET["emosi"], $op_emosi); ?>
                                    </select>
                                    </div>
                                    <div>
                                    <select class="uk-width-1-1" name="hari">
                                        <?php print_option($_GET["hari"], $op_hari); ?>
                                    </select>
                                    </div>
                                    <div>
                                    <select class="uk-width-1-1" name="hc">
                                        <?php print_option($_GET["hc"], $op_hc); ?>
                                    </select>
                                    </div>
                                    <div>
                                        <select class="uk-width-1-1" name="g3p">
                                            <?php print_option($_GET["g3p"], $op_g3p); ?>
                                        </select>
                                    </div>
                                    <div class="uk-clearfix"><button class="uk-button uk-button-primary uk-float-right">SUBMIT</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <div class="uk-width-1-1 sd-header">
        </div>
        <div class="uk-width-1-1 sd-table">
            <table class="uk-table uk-table-striped uk-table-hover sd-table">
                <thead class="uk-contrast">
                    <tr>
                        <td colspan="8"><a href="#sidebar" class="sd-offcanvas-toggle" data-uk-offcanvas="{mode:'slide'}"><i class="uk-icon-medium uk-icon-chrome uk-icon-spin"></i></a></td>
                        <td colspan="1" class="uk-clearfix"><a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>" class="sd-offcanvas-toggle uk-float-right"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a></td>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Info Tiket</th>
                        <th>Jam/Hari</th>
                        <th>Layanan/Headline</th>
                        <th>Paket</th>
                        <th>STO</th>
                        <th>Loker</th>
                        <th <?php if($_SESSION["level"] > 2) echo "colspan = 2"; ?>>Tanggal</th>
                        <?php if($_SESSION["level"] < 3) echo "<th></th>";?>
                    </tr>
                </thead>
                <tbody>

                <?php
                while($row = $result->fetch_assoc()):

                switch ($row["MITRA"]) {
                    case 'PT. TA':
                        $row["MITRA"] = 'PT.TA';
                        break;
                }

                if($row["STO"] == ''){
                    $row["STO"] = "-";
                }
                $row["KELUHAN_DESC"] = "# ".$row["KELUHAN_DESC"]."";
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

                switch ($row["TIPE_TIKET"]) {
                    case 'BILLING':
                        $badge_tipe = "' style='background-color: forestgreen;'";
                        break;
                    case 'FISIK':
                        $badge_tipe = "uk-badge-danger";
                        break;
                    case 'LOGIC':
                        $badge_tipe = "uk-badge-warning";
                        break;
                }

                switch ($row["EMOSI_PLG"]) {
                    case 'Marah':
                        $badge_emosi = 'uk-badge-danger';
                        break;
                    case 'Agak Marah':
                        $badge_emosi = 'uk-badge-warning';
                        break;
                    case 'Ramah':
                        $badge_emosi = 'uk-badge-primary';
                        break;
                }

                switch ($row["PRODUK_GGN"]) {
                    case 'INTERNET':
                        $badge_produk = 'uk-icon-globe';
                        break;
                    case 'IPTV':
                        $badge_produk = 'uk-icon-television';
                        break;
                    case 'TELEPON':
                        $badge_produk = 'uk-icon-phone';
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
                } ?>
                    <tr>
                        <td><?php echo $no; ?><br>
                        </td>
                        <td>
                            <span class='tiket uk-text-bold'><?php echo $row["TROUBLE_NO"]; ?></span><br>
                            <span class='nd_telp'><?php echo $row["ND_TELP"]; ?></span><br>
                            <span class='nd_int'><?php echo $row["ND_INT"]; ?></span><br>
                            <span class='uk-badge tipe_tiket <?php echo $badge_tipe; ?>'><?php echo $row["TIPE_TIKET"]; ?></span>
                            <span class='uk-badge tipe_cust <?php echo $badge_cust; ?>'><?php echo $row["TIPE_CUST"]; ?></span>
                        </td>
                        <td>
                            <span class="jam"><?php echo $row["JAM"]; ?></span><br>
                            (<span class="hari uk-text-bold"><?php echo $row["HARI"]; ?></span>)
                        </td>
                        <td>
                            <div>
                                <div class='uk-panel'>
                                <span class='uk-panel-badge emosi uk-badge <?php echo $badge_emosi; ?>'><?php echo $row["EMOSI_PLG"]; ?></span>
                                </div>
                                <span class='uk-badge produk'><span class='<?php echo $badge_produk; ?>' style='margin-right: 5px;'></span><?php echo $row["PRODUK_GGN"]; ?></span>
                                [LAPUL : <span class="lapul uk-text-bold"><?php echo $row["LAPUL"]; ?></span>][GAUL : <span class="gaul uk-text-bold"><?php echo $row["GAUL30_BACK"]; ?></span>]<br>
                            </div>
                            <span class="headline"><?php echo $row["HEADLINE"]; ?></span><br>
                            <span class="keluhan uk-text-bold"><?php echo $row["KELUHAN_DESC"]; ?></span><br>
                            [CHANNEL : <span class="channel uk-text-bold"><?php echo $row["CHANNEL"]; ?></span>]<br>
                        </td>
                        <td>
                            <span class="paket_int"><?php echo $row["PAKET_INT"]; ?></span><br>
                            <span class="paket_tv"><?php echo $row["PAKET_IPTV"]; ?></span><br>
                        </td>
                        <td>
                            <span class='uk-badge jenis <?php echo $badge_jenis; ?>'><?php echo $row["JENIS"]; ?></span>
                            <span class='uk-badge <?php echo $badge_segmen2; ?> segmen'><span class='<?php echo $badge_segmen; ?>' style='margin-right: 5px;'></span><?php echo $row["SEGMEN"]; ?></span><br>
                            [<span class="uk-text-bold"><?php echo $row["STO"]; ?></span>]<span class="uk-hidden sto"><?php echo $row["CMDF_RL"]; ?></span><br>
                            <span class="mitra"><?php echo $row["MITRA"]; ?></span>
                        </td>
                        <td>
                        <span class="loker"><?php echo $row["LOKER_DISPATCH"]; ?></span><br>
                        </td>
                        <td <?php if($_SESSION["level"] > 2) echo "colspan = 2"; ?>>
                        <span class="tanggal"><?php echo $row["TANGGAL"]; ?></span><br>
                        </td>
                        <?php if($_SESSION["level"] < 3): ?>
                        <td>
                            <a class="uk-button uk-button-primary uk-margin-small-bottom"><span class='uk-icon-eye uk-icon-justify'></span></a>
                            <div class='uk-button-dropdown sd-table-dropdown' data-uk-dropdown='{pos: "left-top", mode: "click"}'>
                            <a class="uk-button uk-button-success"><span class='uk-icon-pencil-square-o uk-icon-justify'></span></a>
                            <div class='uk-dropdown uk-contrast'>
                                <ul class='uk-nav uk-nav-dropdown'>
                                    <li><a class='submit-rihana uk-link'>Insert/Edit in Rihana</a></li>
                                    <li><a class='submit-plasa uk-link'>Insert/Edit in Plasa</a></li>
                                    <li><a class='submit-dewa uk-link'>Insert/Edit in Order Dewa</a></li>
                                    <li class='uk-nav-divider'></li>
                                    <li><a class='submit-cmdf uk-link'>Insert/Edit in CMDF</a></li>
                                    <li><a href='dewa.php'>Edit Point Config</a></li>
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
            <ul class="uk-pagination uk-panel-space uk-margin-top uk-margin-bottom">
                <li><button class="uk-pagination-previous" type="submit" form="option-form" name="page" value="1">First</button></li>
                <?php
                    $startp = $page - 2;
                    if($startp < 2){
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
                        if($page == $i): ?>
                            <li><button class='uk-active sd-disabled' type='submit' form='option-form' name='page' value='<?php echo $i;?>' disabled><?php echo $i;?></button></li>
                        <?php else: ?>
                            <li><button type='submit' form='option-form' name='page' value='<?php echo $i; ?>'><?php echo $i; ?></button></li>
                        <?php endif;
                        if(($condp > 2) && $i == $endp): ?>
                            <li><button class='sd-disabled' disabled>..</button></li>
                        <?php endif;
                    endfor;
                ?>
                <li><button class="uk-pagination-next" type="submit" form="option-form" name="page" value="<?php echo $total_pages; ?>">Last</button></li>
            </ul>
        </div>
    </div>
    <div class="sd-backtop">
        <a href="#top" data-uk-smooth-scroll><span class="uk-icon-angle-up uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
        <a href="#bottom" data-uk-smooth-scroll><span class="uk-icon-angle-down uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
    </div>
    <div id="bottom"></div>
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

            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("action", "../point/dewa_edit.php");
            form.submit();

            $(".inputinfo").remove();
        });

        $( ".submit-rihana" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("action", "../point/rihana_edit.php");
            form.submit();

            $(".inputinfo").remove();
        });

        $( ".submit-plasa" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#container");

            var tr = $(this).closest("tr");
            var tiket = tr.find(".tiket").text();

            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", tiket).attr("name", "itiket").attr("class", "inputinfo");

            form.attr("action", "../point/plasa_edit.php");
            form.submit();

            $(".inputinfo").remove();
        });
    </script>
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