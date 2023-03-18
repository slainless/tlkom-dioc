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

    if(isset($_GET["indi"], $_GET["plg"], $_GET["sto"], $_GET["dewa"], $_GET["alpro"], $_GET["channel"], $_GET["plasa"], $_GET["hari"], $_GET["hc"], $_GET["rihana"], $_GET["g3p"], $_GET["gaul"])){

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

    $op_indi = array(
        array(0,"# My Indihome",1),
        array(1,"Not My Indihome",0),
        array(2,"My Indihome",1),
    );

    $op_dewa = array(
        array(0,"# Order Dewa",1),
        array(1,"Not Order Dewa",0),
        array(2,"Order Dewa",1),
    );

    $op_plasa = array(
        array(0,"# Plasa",1),
        array(1,"Not Plasa",0),
        array(2,"Plasa",1),
    );

    $op_rihana = array(
        array(0,"# Rihana",1),
        array(1,"Not Rihana",0),
        array(2,"Rihana",1),
    );
    $op_g3p = array(
        array(0,"# GGN 3P",1),
        array(1,"Not GGN 3P",0),
        array(2,"GGN 3P",1),
    );

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

        $condition = " WHERE ".$indi." AND ".$plg." AND ".$sto." AND ".$dewa." AND ".$alpro." AND ".$channel." AND ".$plasa." AND ".$hari." AND ".$hc." AND ".$rihana." AND ".$g3p." AND ".$gaul."";

    $order = " ORDER BY TOTAL_P ASC";

    if ($stmt = $query->prepare("SELECT * 
    FROM " . $t_point . "" . $condition . "" . $order . "")) {

            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            $stmt->close();


            
    }

$date = date('[d-m-Y][h.i]', time());
$filename = $date." POINT";

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

echo "\"DATA POINT\"\n";
echo "\"ROW COUNT".$dl."\"".$x."\"\n\n";

echo 
"\"NO".$dl.
"\"TROUBLE NO".$dl.
"\"ND TELP".$dl.
"\"ND INTERNET".$dl.
"\"TIPE CUSTOMER".$dl.
"\"TOTAL POIN".$dl.
"\"P. ORDER DEWA".$dl.
"\"P. MY INDIHOME".$dl.
"\"P. RIHANA".$dl.
"\"P. GANGGUAN 3P".$dl.
"\"P. GAUL".$dl.
"\"P. SLG".$dl.
"\"P. GGU TUA".$dl.
"\"P. PLASA".$dl.
"\"P. HARD COMPLAIN".$dl.
"\"P. LAPUL".$dl.
"\"JAM".$dl.
"\"HARI".$dl.
"\"LAPUL".$dl.
"\"GAUL".$dl.
"\"SLG".$dl.
"\"CMDF".$dl.
"\"STO".$dl.
"\"JENIS ALPRO".$dl.
"\"MITRA".$dl.
"\"SEGMEN".$dl.
"\"CHANNEL\"\n";

    $result->data_seek(0);
    $x = 0;
    while($row = $result->fetch_assoc()):

        $x++;

        echo "\"".$x.$dl;
        echo "\"".$row["TROUBLE_NO"].$dl;
echo "\"".$xl.$row["ND_TELP"].$bn.$dl;
echo "\"".$xl.$row["ND_INT"].$bn.$dl;
echo "\"".$row["TIPE_CUST"].$dl;
echo "\"".$row["TOTAL_P"].$dl;
echo "\"".$row["ORDER_DEWA_P"].$dl;
echo "\"".$row["MY_INDIHOME_P"].$dl;
echo "\"".$row["RIHANA_P"].$dl;
echo "\"".$row["GGN_3P_P"].$dl;
echo "\"".$row["GAUL30_BACK_P"].$dl;
echo "\"".$row["SLG_P"].$dl;
echo "\"".$row["GGU_TUA_P"].$dl;
echo "\"".$row["PLS_P"].$dl;
echo "\"".$row["HCM_P"].$dl;
echo "\"".$row["LAPUL_P"].$dl;
echo "\"".$row["JAM"].$dl;
echo "\"".$row["HARI"].$dl;
echo "\"".$row["LAPUL"].$dl;
echo "\"".$row["GAUL30_BACK"].$dl;
echo "\"".$row["SLG"].$dl;
echo "\"".$row["CMDF_RL"].$dl;
echo "\"".$row["STO"].$dl;
echo "\"".$row["JENIS"].$dl;
echo "\"".$row["MITRA"].$dl;
echo "\"".$row["SEGMEN"].$dl;
echo "\"".$row["CHANNEL"]."\"\n";

    endwhile;
}

    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>