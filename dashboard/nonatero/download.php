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

    $cf = false;

    sec_session_start();

    if(login_check($query)):

        if(isset($_GET["tiket"], $_GET["plg"], $_GET["sto"], $_GET["produk"], $_GET["alpro"], $_GET["channel"], $_GET["emosi"], $_GET["hari"], $_GET["hc"], $_GET["g3p"], $_GET["loker"], $_GET["gaul"], $_GET["search"], $_GET["searchm"])){

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

    if ($stmt = $query->prepare("SELECT LOKER_DISPATCH 
    FROM ".$t_nona." GROUP BY LOKER_DISPATCH"))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $op_loker = array();

        $op_loker[0][0] = "0";
        $op_loker[0][1] = "# LOKER";
        $op_loker[0][2] = "1";

        $x = 1;
        while($row = $result->fetch_assoc()) {
            $op_loker[$x][0] = $x;
            $op_loker[$x][1] = $row["LOKER_DISPATCH"];
            $op_loker[$x][2] = $row["LOKER_DISPATCH"];

            $x++;
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

        if($_GET["tiket"] == 0){
            $tiket = 1;
        }
        else {
            if(empty(arlookup($_GET["tiket"], $op_tiket, 1))){
                $tiket = 1;
            }
            else {
                $tiket = "NONA.TIPE_TIKET = '".$op_tiket[arlookup($_GET["tiket"], $op_tiket, 1)][2]."'";
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

        if($_GET["plg"] == 0){
            $plg = 1;
        }
        else {
            if(empty(arlookup($_GET["plg"], $op_plg, 1))){
                $plg = 1;
            }
            else {
                $plg = "NONA.TIPE_CUST = '".$op_plg[arlookup($_GET["plg"], $op_plg, 1)][2]."'";
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
                $sto = "NONA.STO = '".$op_sto[arlookup($_GET["sto"], $op_sto, 1)][2]."'";
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
                $produk = "NONA.PRODUK_GGN = '".$op_produk[arlookup($_GET["produk"], $op_produk, 1)][2]."'";
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
                $alpro = "NONA.JENIS = '".$op_alpro[arlookup($_GET["alpro"], $op_alpro, 1)][2]."'";
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
                $channel = "NONA.CHANNEL = '".$op_channel[arlookup($_GET["channel"], $op_channel, 1)][2]."'";
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
                $emosi = "NONA.EMOSI_PLG = '".$op_emosi[arlookup($_GET["emosi"], $op_emosi, 1)][2]."'";
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
                        $hari = "NONA.HARI < 3";
                        break;
                    case 2:
                        $hari = "NONA.HARI > 3 AND NONA.HARI < 8";
                        break;
                    case 3:
                        $hari = "NONA.HARI > 7 AND NONA.HARI < 16";
                        break;
                    case 4:
                        $hari = "NONA.HARI > 15 AND NONA.HARI < 22";
                        break;
                    case 5:
                        $hari = "NONA.HARI > 21 AND NONA.HARI < 31";
                        break;
                    case 6:
                        $hari = "NONA.HARI > 30";
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
                $hc = "NONA.HARDCOM = '".$op_hc[arlookup($_GET["hc"], $op_hc, 1)][2]."'";
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
                $g3p = "NONA.GGN_3P_F = '".$op_g3p[arlookup($_GET["g3p"], $op_g3p, 1)][2]."'";
            }
        }

        if($_GET["loker"] == 0){
            $loker = 1;
        }
        else {
            if(empty(arlookup($_GET["loker"], $op_loker, 1))){
                $loker = 1;
            }
            else {
                $loker = "NONA.LOKER_DISPATCH = '".$op_loker[arlookup($_GET["loker"], $op_loker, 1)][2]."'";
            }
        }

        $condition = " WHERE ".$tiket." AND ".$plg." AND ".$sto." AND ".$produk." AND ".$alpro." AND ".$channel." AND ".$emosi." AND ".$hc." AND ".$hari." AND ".$g3p." AND ".$loker." AND ".$gaul."";

    if(!empty($_GET["search"]) && !empty($_GET["searchm"])){
        switch ($_GET["searchm"]) {
            case 1:
                $condition = " WHERE NONA.ND_TELP LIKE ? OR NONA.ND_INT LIKE ? OR NONA.TROUBLE_NO LIKE ?";
                break;
            
            case 2:
                $condition = " WHERE KET.KETERANGAN LIKE ?";
                break;
        }
        $param = "%{$_GET['search']}%";
    }

    if ($stmt = $query->prepare("SELECT * FROM (SELECT TROUBLE_NO, ND_TELP, ND_INT, TIPE_CUST, TIPE_TIKET, EMOSI_PLG, PRODUK_GGN, JENIS, CMDF_RL, STO, MITRA, SEGMEN, CHANNEL, HARI, JAM, SLG, GAUL30_BACK, LAPUL, HEADLINE, KELUHAN_DESC, LOKER_DISPATCH, HARDCOM, GGN_3P_F FROM " . $t_nona . ") AS NONA LEFT OUTER JOIN (SELECT * FROM " . $t_nona_ket . " WHERE EXPIRE_DATE >= CURDATE()) AS KET ON KET.ND = CASE WHEN NONA.ND_TELP IS NULL OR NONA.ND_TELP = '' THEN NONA.ND_INT
    ELSE NONA.ND_TELP END" . $condition . "")) {



            if(!empty($_GET["search"]) && !empty($_GET["searchm"])){
                switch ($_GET["searchm"]) {
                    case 1:
                        $stmt->bind_param("sss", $param, $param, $param); 
                        break;
                    
                    case 2:
                        $stmt->bind_param("s", $param);
                        break;
                }
            }
            
            $stmt->execute();   // Execute the prepared query.

            $result = $stmt->get_result();
            $stmt->close();


            
    }

$date = date('[d-m-Y][h.i]', time());
$filename = $date." NONATERO";

if($_GET["format"] == 1){
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=\"".$filename.".csv\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    $dl = "\",";
    $xl = "";
    $bn = "";
}
else if($_GET["format"] == 2)
{
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=\"".$filename.".xls\"");  //File name extension was wrong
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    $dl = "\"\t";
    $bn = "\"\"";
    $xl = "=\"\"";
}

$x = 0;
while($row = $result->fetch_assoc()): $x++; endwhile;

echo "\"DATA NONATERO\"\n";
echo "\"RESULT".$dl."\"".$x."\"\n\n";

echo
"\"NO".$dl. 
"\"TROUBLE NO".$dl.
"\"ND TELP".$dl.
"\"ND INTERNET".$dl.
"\"TIPE CUSTOMER".$dl.
"\"TIPE TIKET".$dl.
"\"EMOSI PELANGGAN".$dl.
"\"PRODUK GANGGUAN".$dl.
"\"JENIS ALPRO".$dl.
"\"CMDF".$dl.
"\"STO".$dl.
"\"MITRA".$dl.
"\"SEGMEN".$dl.
"\"CHANNEL".$dl.
"\"HARI".$dl.
"\"JAM".$dl.
"\"SLG".$dl.
"\"GAUL".$dl.
"\"LAPUL".$dl.
"\"HEADLINE".$dl.
"\"KELUHAN".$dl.
"\"LOKER DISPATCH".$dl.
"\"HARD COMPLAIN".$dl.
"\"GANGGUAN 3P".$dl.
"\"KETERANGAN".$dl.
"\"EXPIRE DATE\"\n";

    $result->data_seek(0);
    $x = 0;
    while($row = $result->fetch_assoc()):

        $row["KETERANGAN"] = html_entity_decode($row["KETERANGAN"]);

        $x++;

        echo "\"".$x.$dl;
        echo "\"".$row["TROUBLE_NO"].$dl;
        echo "\"".$xl.$row["ND_TELP"].$bn.$dl;
        echo "\"".$xl.$row["ND_INT"].$bn.$dl;
        echo "\"".$row["TIPE_CUST"].$dl;
        echo "\"".$row["TIPE_TIKET"].$dl;
        echo "\"".$row["EMOSI_PLG"].$dl;
        echo "\"".$row["PRODUK_GGN"].$dl;
        echo "\"".$row["JENIS"].$dl;
        echo "\"".$row["CMDF_RL"].$dl;
        echo "\"".$row["STO"].$dl;
        echo "\"".$row["MITRA"].$dl;
        echo "\"".$row["SEGMEN"].$dl;
        echo "\"".$row["CHANNEL"].$dl;
        echo "\"".$row["HARI"].$dl;
        echo "\"".$row["JAM"].$dl;
        echo "\"".$row["SLG"].$dl;
        echo "\"".$row["GAUL30_BACK"].$dl;
        echo "\"".$row["LAPUL"].$dl;
        echo "\"".$row["HEADLINE"].$dl;
        echo "\"".$row["KELUHAN_DESC"].$dl;
        echo "\"".$row["LOKER_DISPATCH"].$dl;
        echo "\"".$row["HARDCOM"].$dl;
        echo "\"".$row["GGN_3P_F"].$dl;
        echo "\"".$row["KETERANGAN"].$dl;
        echo "\"".$row["EXPIRE_DATE"]."\"\n";

    endwhile;
}

    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>