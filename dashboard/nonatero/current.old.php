<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    $webf_header_type = 2;
    $webf_footer_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "Nonatero | Current";
    
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
    FROM ".$t_nona." GROUP BY STO"))
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

    if(!isset($_GET["tiket"])){
        $_GET["tiket"] = 0;
    }
    if($tiket = cdt_create($_GET["tiket"], "TIPE_TIKET", $op_tiket)){
        $cf = true;
    }
    if($tiket == ''){
        $tiket = 1;
    }

    if(!isset($_GET["plg"])){
        $_GET["plg"] = 0;
    }
    if($plg = cdt_create($_GET["plg"], "TIPE_CUST", $op_plg)){
        $cf = true;
    }
    if($plg == ''){
        $plg = 1;
    }

    if(!isset($_GET["sto"])){
        $_GET["sto"] = 0;
    }
    if($sto = cdt_create($_GET["sto"], "STO", $op_sto)){
        $cf = true;
    }
    if($sto == ''){
        $sto = 1;
    }

    if(!isset($_GET["produk"])){
        $_GET["produk"] = 0;
    }
    if($produk = cdt_create($_GET["produk"], "PRODUK_GGN", $op_produk)){
        $cf = true;
    }
    if($produk == ''){
        $produk = 1;
    }

    if(!isset($_GET["alpro"])){
        $_GET["alpro"] = 0;
    }
    if($alpro = cdt_create($_GET["alpro"], "JENIS", $op_alpro)){
        $cf = true;
    }
    if($alpro == ''){
        $alpro = 1;
    }

    if(!isset($_GET["channel"])){
        $_GET["channel"] = 0;
    }
    if($channel = cdt_create($_GET["channel"], "CHANNEL", $op_channel)){
        $cf = true;
    }
    if($channel == ''){
        $channel = 1;
    }

    if(!isset($_GET["emosi"])){
        $_GET["emosi"] = 0;
    }
    if($emosi = cdt_create($_GET["emosi"], "EMOSI_PLG", $op_emosi)){
        $cf = true;
    }
    if($emosi == ''){
        $emosi = 1;
    }

    if(!isset($_GET["hari"])){
        $_GET["hari"] = 0;
    }
    if($hari = cdt_create($_GET["hari"], "HARI", $op_hari, " > ")){
        $cf = true;
    }
    if($hari == ''){
        $hari = 1;
    }

    if(!isset($_GET["hc"])){
        $_GET["hc"] = 0;
    }
    if($hc = cdt_create($_GET["hc"], "HARDCOM", $op_hc)){
        $cf = true;
    }
    if($hc == ''){
        $hc = 1;
    }

    if($cf == true){
        $condition = " WHERE ".$tiket." AND ".$plg." AND ".$sto." AND ".$produk." AND ".$alpro." AND ".$channel." AND ".$emosi." AND ".$hari." AND ".$hc;
    }
    else {
        $condition = "";
    }

    if ($stmt = $query->prepare("SELECT * 
    FROM " . $t_nona . "" . $condition . " LIMIT ?, ?")) {

            $stmt->bind_param("ii", $start_from, $per_page); 
            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            $stmt->close();
            
            $no = $per_page * ($page-1);
    }

    if ($stmt = $query->prepare("SELECT 
    COUNT(TROUBLE_NO) as number FROM " . $t_nona . "" . $condition . "")) {
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
    <style>
        .sd-table tbody tr > td:nth-child(2) > span:nth-child(1),
.sd-table tbody tr > td:nth-child(3) > span:nth-child(1),
.sd-table tbody tr > td:nth-child(4) > div:nth-child(1),
.sd-table tbody tr > td:nth-child(4) > span:nth-child(6),
.sd-table tbody tr > td:nth-child(4) > span:nth-child(4),
.sd-table tbody tr > td:nth-child(6) > span
 {
    font-weight: bolder;
 }
    </style>
    </head>
    <body>
    <div class="uk-grid">
        <?php
            require_once $webf_sidebar;
        ?>
        <?php
            require_once $webf_header;
        ?>
        <div class="uk-width-1-1 sd-subheader">
                <div>
                    <div class="uk-panel-space">
                        <ul class="uk-breadcrumb">
                            <li><a class="uk-text-uppercase" href="../nonatero/">Nonatero</a></li>
                            <li><span class="uk-text-uppercase">Current</span></li>
                        </ul>
                    </div>
                </div>
        </div>
        <div class="uk-width-1-1 sd-option">
            <div class="uk-grid">
                <div class="uk-width-7-10">
                    <form class="uk-form" action="" method="GET" id="option-form">

                            <div class="uk-grid uk-grid-width-1-5 uk-grid-small" data-uk-grid-margin="">
                                <span class="sd-option-legend uk-width-1-1">Filter</span>
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
                                    <button type="submit" class="uk-button uk-button-primary uk-width-1-1">SUBMIT
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="uk-width-1-10"></div>
                <div class="uk-width-2-10"></div>
            </div>
        </div>
        <div class="uk-width-1-1 sd-content sd-table">
            <table class="uk-table uk-table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Info Tiket</th>
                        <th>Jam/Hari</th>
                        <th>Layanan/Headline</th>
                        <th>Paket</th>
                        <th>Info STO</th>
                        <th>Loker</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                while($row = $result->fetch_assoc()) {

                switch ($row["MITRA"]) {
                    case 'PT. TA':
                        $row["MITRA"] = 'PT.TA';
                        break;
                }

                if($row["STO"] != ''){
                    $row["STO"] = "[".$row["STO"]."]";
                }
                $row["LAPUL"] = "[LAPUL : ".$row["LAPUL"]."]";
                $row["GAUL30_BACK"] = "[GAUL : ".$row["GAUL30_BACK"]."]";
                $row["HARI"] = "(".$row["HARI"].")";
                $row["CHANNEL"] = "[CHANNEL : ".$row["CHANNEL"]."]";
                $row["KELUHAN_DESC"] = "# ".$row["KELUHAN_DESC"]."";
                $no = $no + 1;

                switch ($row["TIPE_CUST"]) {
                    case 'SILVER':
                        $badge_cust = 'sd-badge sd-badge-slv';
                        break;
                    case 'TITANIUM/GOLD':
                        $badge_cust = 'sd-badge sd-badge-ttn';
                        $row["TIPE_CUST"] = 'TITANIUM';
                        break;
                    case 'PLATINUM':
                        $badge_cust = 'sd-badge sd-badge-plt';
                        break;
                    case 'BUSINESS':
                        $badge_cust = 'sd-badge sd-badge-bsn';
                        break;
                    case 'ENTERPRISE':
                        $badge_cust = 'sd-badge sd-badge-ent';
                        break;
                }

                switch ($row["TIPE_TIKET"]) {
                    case 'BILLING':
                        $badge_tipe = 'sd-badge sd-badge-blg';
                        break;
                    case 'FISIK':
                        $badge_tipe = 'sd-badge sd-badge-fsk';
                        break;
                    case 'LOGIC':
                        $badge_tipe = 'sd-badge sd-badge-log';
                        break;
                }

                switch ($row["EMOSI_PLG"]) {
                    case 'Marah':
                        $badge_emosi = 'uk-badge-danger sd-badge sd-badge-mrh';
                        break;
                    case 'Agak Marah':
                        $badge_emosi = 'uk-badge-warning sd-badge sd-badge-amr';
                        break;
                    case 'Ramah':
                        $badge_emosi = 'sd-badge sd-badge-rmh';
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
                }

                echo "
                
                    <tr>
                        <td>"."$no"."<br>
                            <a><span class='uk-icon-eye'></span></a><br>
                            <a><span class='uk-icon-pencil-square-o'></span></a>
                        </td>
                        <td>
                            <span>".$row["TROUBLE_NO"]."</span><br>
                            <span>".$row["ND_TELP"]."</span><br>
                            <span>".$row["ND_INT"]."</span><br>
                            <span class='uk-badge ".$badge_tipe."'>".$row["TIPE_TIKET"]."</span>
                            <span class='uk-badge ".$badge_cust."'>".$row["TIPE_CUST"]."</span>
                        </td>
                        <td>
                            <span>".$row["JAM"]."</span><br>
                            <span>".$row["HARI"]."</span><br>
                        </td>
                        <td>
                            <div>
                                <div class='uk-panel'>
                                <span class='uk-panel-badge uk-badge ".$badge_emosi."'>".$row["EMOSI_PLG"]."</span>
                                </div>
                                <span class='uk-badge'><span class='".$badge_produk."' style='margin-right: 5px;'></span>".$row["PRODUK_GGN"]."</span>
                                <span>".$row["LAPUL"]."</span><span>".$row["GAUL30_BACK"]."</span><br>
                            </div>
                            <span>".$row["HEADLINE"]."</span><br>
                            <span>".$row["KELUHAN_DESC"]."</span><br>
                            <span>".$row["CHANNEL"]."</span><br>
                        </td>
                        <td>
                            <span>".$row["PAKET_INT"]."</span><br>
                            <span>".$row["PAKET_IPTV"]."</span><br>
                        </td>
                        <td>
                            <span class='uk-badge ".$badge_jenis."'>".$row["JENIS"]."</span>
                            <span class='uk-badge ".$badge_segmen2."'><span class='".$badge_segmen."' style='margin-right: 5px;'></span>".$row["SEGMEN"]."</span><br>
                            <span>".$row["STO"]."</span><br>
                            <span>".$row["MITRA"]."</span>
                        </td>
                        <td>
                        <span>".$row["LOKER_DISPATCH"]."</span><br>
                        </td>
                    </tr>
                    ";
                }
                ?>



                </tbody>
            </table>
        </div>
        <div class="uk-width-1-1 sd-pagination">
            <ul class="uk-pagination uk-panel-space">
                <li><button class="uk-pagination-previous" type="submit" form="option-form" name="page" value="1">First</button></li>
                <?php
                    for ($i=1; $i<=$total_pages; $i++) {
                        if($page == $i){
                            echo " <li><button class='uk-active sd-disabled' type='submit' form='option-form' name='page' value='" .$i. "' disabled>" .$i. "</button>";
                        }
                        else {
                        echo " <li><button type='submit' form='option-form' name='page' value='" .$i. "'>" .$i. "</button>";
                        }
                    };
                ?>
                <li><button class="uk-pagination-next" type="submit" form="option-form" name="page" value="<? echo $total_pages; ?>">Last</button></li>
            </ul>
        </div>
        <?php
            require_once $webf_footer;
        ?>
    </div>
    <script>
    $(window).load(function() {
        $("#bottom").stickyFooter({
    // The class that is added to the footer.
    class: 'sticky-bottom',

    // The footer will stick to the bottom of the given frame. The parent of the footer is used when an empty string is given.
    frame: '',

    // The content of the frame. You can use multiple selectors. e.g. "#header, #body"
    content: 'body'
    });
    });
    </script>
    <div class="sd-backtop">
        <a href="#top" data-uk-smooth-scroll><span class="uk-icon-caret-square-o-up uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
        <a href="#bottom" data-uk-smooth-scroll><span class="uk-icon-caret-square-o-down uk-icon-medium uk-icon-spin uk-animation-hover"></span></a>
    </div>
    </body>
</html>

<?php
    mysqli_close($query);
?>
