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

        $stmt->execute();   // Execute the prepared query.
        
        $sto_list = $stmt->get_result();
        $stmt->close();
    }

    $shortcut = "tiket";
    if(!isset($_GET["tiket"])) {
        $_GET["tiket"] = 0;
    }

    switch($_GET["tiket"]){
        $tiket = "TIPE_TIKET";
        case '1':
            $tiket = "TIPE_TIKET = 'FISIK'";
            $cf = true;
            break;
        case '2':
            $tiket = "TIPE_TIKET = 'BILLING'";
            $cf = true;
            break;
        case '3':
            $tiket = "TIPE_TIKET = 'LOGIC'";
            $cf = true;
            break;
        default:
            $tiket = "1";
            break;
    }

    if(!isset($_GET["plg"])) {
        $_GET["plg"] = 0;
    }
    
    switch($_GET["plg"]){
        case '1':
            $plg = "TIPE_CUST = 'SILVER'";
            $cf = true;
            break;
        case '2':
            $plg = "TIPE_CUST = 'TITANIUM/GOLD'";
            $cf = true;
            break;
        case '3':
            $plg = "TIPE_CUST = 'PLATINUM'";
            $cf = true;
            break;
        case '4':
            $plg = "TIPE_CUST = 'BUSINESS'";
            $cf = true;
            break;
        case '5':
            $plg = "TIPE_CUST = 'ENTERPRISE'";
            $cf = true;
            break;
        default:
            $plg = "1";
            break;
    }

    if(!isset($_GET["sto"])) {
        $_GET["sto"] = 0;
    }

    if(!isset($_GET["produk"])) {
        $_GET["produk"] = 0;
    }
    
    switch($_GET["produk"]){
        case '1':
            $produk = "PRODUK_GGN = 'INTERNET'";
            $cf = true;
            break;
        case '2':
            $produk = "PRODUK_GGN = 'IPTV'";
            $cf = true;
            break;
        case '3':
            $produk = "PRODUK_GGN = 'TELEPON'";
            $cf = true;
            break;
        default:
            $produk = "1";
            break;
    }

    if(!isset($_GET["jenis"])) {
        $_GET["jenis"] = 0;
    }
    
    switch($_GET["jenis"]){
        case '1':
            $produk = "JENIS = 'FTTH'";
            $cf = true;
            break;
        case '2':
            $produk = "JENIS = 'NON-FTTH'";
            $cf = true;
            break;
        default:
            $produk = "1";
            break;
    }

    if(!isset($_GET["channel"])) {
        $_GET["channel"] = 0;
    }
    
    switch($_GET["channel"]){
        case '1':
            $produk = "CHANNEL = '147'";
            $cf = true;
            break;
        case '2':
            $produk = "CHANNEL = 'C4 DES'";
            $cf = true;
            break;
        case '3':
            $produk = "CHANNEL = 'MEDIA SOSIAL'";
            $cf = true;
            break;
        default:
            $produk = "1";
            break;
    }

    if($cf == true){
        $condition = " WHERE ".$tiket." AND ".$plg." AND ".$sto." AND ".$produk;
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
<html>
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
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
                            <div class="uk-grid uk-grid-width-1-6 uk-grid-small" data-uk-grid-margin="">
                                <div>
                                    <select class="uk-width-1-1" name="tiket">
                                        <option value="0" <?php if(compare($_GET["tiket"], 0)){ echo "selected";} ?>># Tipe Tiket</option>
                                        <option value="1" <?php if(compare($_GET["tiket"], 1)){ echo "selected";} ?>>Fisik</option>
                                        <option value="2" <?php if(compare($_GET["tiket"], 2)){ echo "selected";} ?>>Billing</option>
                                        <option value="3" <?php if(compare($_GET["tiket"], 3)){ echo "selected";} ?>>Logic</option>
                                        <option value="4" <?php if(compare($_GET["tiket"], 4)){ echo "selected";} ?>>Non-Teknis</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="plg">
                                        <option value="0" <?php if(compare($_GET["plg"], 0)){ echo "selected";} ?>># Tipe PLG</option>
                                        <option value="1" <?php if(compare($_GET["plg"], 1)){ echo "selected";} ?>>Silver</option>
                                        <option value="2" <?php if(compare($_GET["plg"], 2)){ echo "selected";} ?>>Titanium</option>
                                        <option value="3" <?php if(compare($_GET["plg"], 3)){ echo "selected";} ?>>Platinum</option>
                                        <option value="4" <?php if(compare($_GET["plg"], 4)){ echo "selected";} ?>>Business</option>
                                        <option value="5" <?php if(compare($_GET["plg"], 5)){ echo "selected";} ?>>Enterprise</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="sto">
                                        <option value="0"># STO</option>
                                        <?php 
                                        $no_list = 0;
                                        while($row = $sto_list->fetch_assoc()) {

                                            $selected = "";
                                            if(compare($_GET["sto"], $no_list)){ $selected = "selected";}

                                            $no_list = $no_list + 1;
                                            if($row["STO"] != ''){
                                                echo "<option value='".$no_list."' ".$selected.">".$row["STO"]."</option>";
                                            }
                                            else {
                                                echo "<option value='".$no_list."' ".$selected.">No STO</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="produk">
                                        <option value="0" <?php if(compare($_GET["tiket"], 0)){ echo "selected";} ?>>Produk GGN</option>
                                        <option value="1" <?php if(compare($_GET["tiket"], 1)){ echo "selected";} ?>>Internet</option>
                                        <option value="2" <?php if(compare($_GET["tiket"], 2)){ echo "selected";} ?>>IPTV</option>
                                        <option value="3" <?php if(compare($_GET["tiket"], 3)){ echo "selected";} ?>>Telepon</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="alpro">
                                        <option value="0">Jenis Alpro</option>
                                        <option value="1">FTTH</option>
                                        <option value="2">NON-FTTH</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="channel">
                                        <option value="0">Channel</option>
                                        <option value="1">147</option>
                                        <option value="2">C4 DES</option>
                                        <option value="3">MEDIA SOSIAL</option>
                                        <option value="4">MY INDIHOME</option>
                                        <option value="5">PLASA</option>
                                        <option value="6">TAM DBS</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="emosi">
                                        <option value="0">Emosi PLG</option>
                                        <option value="1">Ramah</option>
                                        <option value="2">Agak Marah</option>
                                        <option value="3">Marah</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="form-s-s" class="uk-width-1-1">
                                        <option value="0">Hari/Jam</option>
                                        <option value="0">Option 02</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="form-s-s" class="uk-width-1-1">
                                        <option value="0">Lapul</option>
                                        <option value="0">Option 02</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="form-s-s" class="uk-width-1-1">
                                        <option value="0">Gaul</option>
                                        <option value="0">Option 02</option>
                                    </select>
                                </div>
                                <div>
                                    <select class="uk-width-1-1" name="hc">
                                        <option value="0">Hardcomplain</option>
                                        <option value="1">Ya</option>
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
        $("table").stickyTableHeaders();
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
