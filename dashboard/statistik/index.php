<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";


    $webf_header_type = 1;
    $webf_footer_type = 1;
    $webf_title = "statistik";
    
    $path_type = 1;
    $path_level = 2;

    sec_session_start();

    $page_title = "Dashboard | Statistik";


    if(login_check($query)):

    $lastup = file_get_contents("../../cron/log.html");
    $lastup = substr($lastup, 17, 17);

    if ($stmt = $query->prepare("
        (SELECT COUNT(TROUBLE_NO) AS COUNT, PRODUK_GGN, DATE_FORMAT(TANGGAL, '%Y-%m-%e') AS TANGGAL FROM ".$t_nona_h." WHERE PRODUK_GGN = 'INTERNET' GROUP BY PRODUK_GGN, DATE(TANGGAL) ORDER BY DATE(TANGGAL) DESC LIMIT 6)
        UNION ALL 
        (SELECT COUNT(TROUBLE_NO) AS COUNT, PRODUK_GGN, DATE_FORMAT(TANGGAL, '%Y-%m-%e') AS TANGGAL FROM ".$t_nona_h." WHERE PRODUK_GGN = 'IPTV' GROUP BY PRODUK_GGN, DATE(TANGGAL) ORDER BY DATE(TANGGAL) DESC LIMIT 6)
        UNION ALL 
        (SELECT COUNT(TROUBLE_NO) AS COUNT, PRODUK_GGN, DATE_FORMAT(TANGGAL, '%Y-%m-%e') AS TANGGAL FROM ".$t_nona_h." WHERE PRODUK_GGN = 'TELEPON' GROUP BY PRODUK_GGN, DATE(TANGGAL) ORDER BY DATE(TANGGAL) DESC LIMIT 6)
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $produk_ggn = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            $row["TANGGAL"] = date_create($row["TANGGAL"]);
            $row["TANGGAL"] = date_format($row["TANGGAL"], "d M");
            list($d, $m) = explode(" ", $row["TANGGAL"]);
            $d = '<span class="chart-label-day chart-label">'.$d.'</span>';
            $m = '<span class="chart-label-month chart-label">'.$m.'</span>';
            $row["TANGGAL"] = "<div class=\"chart-label-wrapper\">".$d."<br>".$m."</div>";

            $produk_ggn[$x][0] = $row["COUNT"];
            $produk_ggn[$x][1] = $row["PRODUK_GGN"];
            $produk_ggn[$x][2] = $row["TANGGAL"];
            $x++;
        }
        $produk_ggn = array_reverse($produk_ggn);
    }



    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, STO FROM ".$t_nona." GROUP BY STO ORDER BY COUNT(TROUBLE_NO) DESC"))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $sto = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {

            if(empty($row["STO"])){
                $row["STO"] = 'No Data';
            }

/*            $d = '<span class="chart-label-day chart-label">'.$row["STO"].'</span>';
            $m = '<span class="chart-label-month chart-label">'.$row["COUNT"].'</span>';*/
            $d = '<span class="chart-label-day chart-label">'.$row["COUNT"].'</span>';
            $m = '<span class="chart-label-month chart-label">'.$row["STO"].'</span>';
            $dm = "<div class=\"chart-label-wrapper\">".$d."<br>".$m."</div>";

            if($x < 6):
                $sto[$x][0] = $row["COUNT"];
                $sto[$x][1] = $dm;
                $sto[$x][2] = $row["STO"];
                $x++;
            elseif($x == 6):
                $count = $row["COUNT"];

                $x++;
            elseif($x > 6):
                $count = $count + $row["COUNT"];
            endif;
        }
/*        $d = '<span class="chart-label-day chart-label">Other</span>';
        $m = '<span class="chart-label-month chart-label">'.$count.'</span>';*/
        $d = '<span class="chart-label-day chart-label">'.$count.'</span>';
        $m = '<span class="chart-label-month chart-label">Other</span>';
        $dm = "<div class=\"chart-label-wrapper\">".$d."<br>".$m."</div>";

        $sto[$x][0] = $count;
        $sto[$x][1] = $dm;
        $sto[$x][2] = "Other";

        $sto = array_reverse($sto);
    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, JENIS FROM ".$t_nona." WHERE JENIS IN ('FTTH', 'NON-FTTH') GROUP BY JENIS
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $jenis_alpro = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            $jenis_alpro[$x][0] = $row["COUNT"];
            $jenis_alpro[$x][1] = $row["JENIS"];
            $x++;
        }
    }



    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, EMOSI_PLG, CASE WHEN EMOSI_PLG = 'Marah' THEN 1 WHEN EMOSI_PLG = 'Agak Marah' THEN 2 WHEN EMOSI_PLG = 'Ramah' THEN 3 END AS URUT FROM ".$t_nona." WHERE EMOSI_PLG IN ('Agak Marah', 'Marah', 'Ramah') GROUP BY EMOSI_PLG ORDER BY URUT
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $emosi_plg = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            $emosi_plg[$x][0] = $row["COUNT"];
            $emosi_plg[$x][1] = $row["EMOSI_PLG"];
            $x++;
        }
    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, TIPE_CUST FROM ".$t_nona." WHERE TIPE_CUST IN ('SILVER', 'TITANIUM/GOLD', 'PLATINUM', 'BUSINESS', 'ENTERPRISE') GROUP BY TIPE_CUST ORDER BY COUNT(TROUBLE_NO) DESC
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $tipe_cust = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            if($row["TIPE_CUST"] == 'TITANIUM/GOLD'){
                $row["TIPE_CUST"] = 'TITANIUM';
            }
            $tipe_cust[$x][0] = $row["COUNT"];
            $tipe_cust[$x][1] = $row["TIPE_CUST"];
            $x++;
        }
    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, TIPE_TIKET FROM ".$t_nona." WHERE TIPE_TIKET IN ('BILLING', 'FISIK', 'LOGIC') GROUP BY TIPE_TIKET
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $tipe_tiket = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            $tipe_tiket[$x][0] = $row["COUNT"];
            $tipe_tiket[$x][1] = $row["TIPE_TIKET"];
            $x++;
        }
    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, DATE_FORMAT(TANGGAL, '%Y-%m-%e') AS TANGGAL FROM ".$t_nona_h." GROUP BY DATE(TANGGAL) ORDER BY DATE(TANGGAL) DESC LIMIT 6
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $total = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            $row["TANGGAL"] = date_create($row["TANGGAL"]);
            $row["TANGGAL"] = date_format($row["TANGGAL"], "d M");
            list($d, $m) = explode(" ", $row["TANGGAL"]);
            $d = '<span class="chart-label-day chart-label">'.$d.'</span>';
            $m = '<span class="chart-label-month chart-label">'.$m.'</span>';
            $dm = "<div class=\"chart-label-wrapper\">".$d."<br>".$m."</div>";

            $total[$x][0] = $row["COUNT"];
            $total[$x][1] = $dm;
            $total[$x][2] = $row["TANGGAL"];
            $x++;
        } $total = array_reverse($total);
    }

    if ($stmt = $query->prepare("(SELECT COUNT(*) AS 'COUNT', '< 1' AS HARI FROM ".$t_nona." WHERE JAM < 24 LIMIT 1) 
UNION ALL
(SELECT COUNT(*) AS 'COUNT', '1-2' AS HARI FROM ".$t_nona." WHERE JAM >= 24 AND JAM < 72 LIMIT 1)
UNION ALL
(SELECT COUNT(*) AS 'COUNT', '2-3' AS HARI FROM ".$t_nona." WHERE JAM >= 48 AND JAM < 96 LIMIT 1)
UNION ALL
(SELECT COUNT(*) AS 'COUNT', '4-7' AS HARI FROM ".$t_nona." WHERE JAM >= 96 AND JAM < 192 LIMIT 1)
UNION ALL
(SELECT COUNT(*) AS 'COUNT', '8-15' AS HARI FROM ".$t_nona." WHERE JAM >= 192 AND JAM < 384 LIMIT 1)
UNION ALL
(SELECT COUNT(*) AS 'COUNT', '16-30' AS HARI FROM ".$t_nona." WHERE JAM >= 384 AND JAM < 744 LIMIT 1)
UNION ALL
(SELECT COUNT(*) AS 'COUNT', '> 30' AS HARI FROM ".$t_nona." WHERE JAM >= 744 LIMIT 1)"))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $slgarray = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
            $slgarray[$x][0] = $row["COUNT"];
            $slgarray[$x][2] = $row["HARI"]." HARI";

/*            $d = '<span class="chart-label-day chart-label">'.$row["HARI"].'</span>';
            $m = '<span class="chart-label-month chart-label">'.$row["COUNT"].'</span>';*/
            $d = '<span class="chart-label-day chart-label">'.$row["COUNT"].'</span>';
            $m = '<span class="chart-label-month chart-label">'.$row["HARI"].'</span>';
            $slgarray[$x][1] = "<div class=\"chart-label-wrapper\">".$d."<br>".$m."</div>";
            $x++;


        } 
        // $slgarray = array_reverse($slgarray);
    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, GAUL30_BACK FROM ".$t_nona." GROUP BY GAUL30_BACK
        "))
    {

        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->close();

        $gaularray = array();

        $x = 0;
        while($row = $result->fetch_assoc()) {
/*            $d = '<span class="chart-label-day chart-label">N: '.$row["GAUL30_BACK"].'</span>';
            $m = '<span class="chart-label-month chart-label">'.$row["COUNT"].'</span>';*/
            $d = '<span class="chart-label-day chart-label">'.$row["COUNT"].'</span>';
            $m = '<span class="chart-label-month chart-label">N: '.$row["GAUL30_BACK"].'</span>';
            $gaularray[$x][1] = "<div class=\"chart-label-wrapper\">".$d."<br>".$m."</div>";
            $gaularray[$x][0] = $row["COUNT"];
            $gaularray[$x][2] = "GAUL: ".$row["GAUL30_BACK"];
            $x++;
        } 
    }

    

    

?>
<!DOCTYPE html>
<html>
<head>
        <?php
            require_once $webf_starter;
        ?>
        <link rel="stylesheet" href="<?php pathcv($path_type, "js/chartist.css", $path_level); ?>">
        <link rel="stylesheet" href="<?php pathcv($path_type, "js/chartist-plugin-tooltip.css", $path_level); ?>">
        <link rel="stylesheet" href="<?php pathcv($path_type, "css/stardusk.statistik.css", $path_level); ?>">

        <script src="<?php pathcv($path_type, "js/chartist.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-pointlabels.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-tooltip.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-fill-donut.min.js", $path_level); ?>"></script>
        <style>
        

        <?php
        $palette = array(
            "crimson","mistyrose"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart1 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important; }";

        }
        $palette = array(
            "crimson","#f05c79","#f8b9c6","mistyrose","white","lightcyan"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart5 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important; }";

        }

        $palette = array(
            "crimson","#f05c79","mistyrose","white","lightcyan"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart6 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important; }";

        }

        $palette = array(
            "crimson","#f05c79","mistyrose","white","lightcyan"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart7 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important; }";

        }

        $palette = array(
            "crimson","#eb2d53","#f05c79","#f48aa0","#f8b9c6","#fde8ec","mistyrose"
        );
        $palette = array_reverse($palette);

        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {
                $x++;
                echo "#chart2 .ct-chart-bar .ct-series-a .ct-bar:nth-child($x) {";
                $x = $x - 1;
                echo "stroke: ".$palette[$x]." !important; }";
        }

        $palette = array(
            "crimson","#eb2d53","#f05c79","#f48aa0","#f8b9c6","#fde8ec","mistyrose"
        );
//         $palette = array_reverse($palette);

        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {
                $x++;
                echo "#chart9 .ct-chart-bar .ct-series-a .ct-bar:nth-child($x) {";
                $x = $x - 1;
                echo "stroke: ".$palette[$x]." !important; }";
        }

        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {
                $x++;
                echo "#chart10 .ct-chart-bar .ct-series-a .ct-bar:nth-child($x) {";
                $x = $x - 1;
                echo "stroke: ".$palette[$x]." !important; }";
        }
        ?>
        </style>

</head>
<body>
    <div class="sd-fixed sd-fixed-top">
        <a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1 sd-content">
            <div class="sd-content-main uk-grid">
                <div class="uk-container-center uk-width-small-8-10 uk-margin-large-top uk-margin-large-top uk-margin-large-bottom" >
                    <div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-small-1-2 uk-grid-width-medium-1-2 uk-grid-large uk-grid-match" data-uk-grid-margin data-uk-grid-match="{target:'.panel-box'}">
                            <div class="panel-box uk-width-1-1">
                                <div class="uk-panel uk-panel-box">
                                    <div class="uk-panel uk-panel-space">  
                                        <div class="uk-grid uk-grid-divider uk-margin-top uk-margin-bottom">
                                            <div class="uk-width-2-10">
                                                <div class="uk-text-center">
                                                    <span class="sd-label-large uk-text-bold"><?php echo $emosi_plg[0][0] + $emosi_plg[1][0] + $emosi_plg[2][0]; ?></span><span class="sd-label-main uk-text-bold">GANGGUAN</span><span>SAAT INI</span>
                                                </div>
                                            </div>
                                            <div class="uk-width-8-10">
                                                KANAN
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-box">
                                <div class="uk-panel uk-panel-box">
                                    <div class="uk-panel uk-panel-teaser">
                                        <div class="uk-panel">
                                            <div class="ct-chart ct-square" id="chart1">
                                                <span class="uk-hidden chart-valuedesc">JENIS</span>
                                                <span class="uk-hidden chart-metadesc">ALPRO</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-2-3 uk-visible-large panel-box">
                                <div class="uk-panel uk-panel-box uk-padding-remove">
                                    <div class="uk-margin-top uk-margin-bottom uk-margin-large-left">
                                        <span class="chart-title"><span class="uk-text-bold chart-title-main">GANGGUAN PER STO</span><span class="chart-title-sub"></span><span class="uk-hidden ctm-default">GANGGUAN PER STO</span><span class="uk-hidden cts-default"></span></span>
                                    </div>
                                            <div class="ct-chart ct-major-tenth" id="chart2"></div>
                                </div>
                            </div class="panel-box">
                            <div class="uk-hidden-large panel-box">
                                <div class="uk-panel uk-panel-box">
                                    <div class="uk-panel-teaser">
                                            <div class="ct-chart ct-square" id="chart3"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-1 panel-box">
                                <div class="uk-panel uk-panel-box uk-padding-remove">
                                    <div class="uk-margin-top uk-margin-bottom uk-margin-large-left uk-clearfix">
                                        <span class="chart-title"><span class="uk-text-bold chart-title-main">PRODUK GANGGUAN</span><span class="chart-title-sub"></span><span class="uk-hidden ctm-default">PRODUK GANGGUAN</span><span class="uk-hidden cts-default"></span></span>
                                        <span class="uk-text-small uk-float-right uk-margin-large-right">(* SEJAM YANG LALU</span>
                                    </div>
                                            <div class="ct-chart ct-major-twelfth" id="chart4"></div>
                                </div>
                            </div>
                            <div class="panel-box">
                                <div class="uk-panel uk-panel-box">
                                    <div class="uk-panel-teaser">
                                            <div class="ct-chart ct-square" id="chart5">
                                                <span class="uk-hidden chart-valuedesc">TIPE</span>
                                                <span class="uk-hidden chart-metadesc">CUSTOMER</span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-box">
                                <div class="uk-panel uk-panel-box">
                                    <div class="uk-panel-teaser">
                                            <div class="ct-chart ct-square" id="chart6">
                                                <span class="uk-hidden chart-valuedesc">EMOSI</span>
                                                <span class="uk-hidden chart-metadesc">PELANGGAN</span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-box">
                                <div class="uk-panel uk-panel-box">
                                    <div class="uk-panel-teaser">
                                            <div class="ct-chart ct-square" id="chart7">
                                                <span class="uk-hidden chart-valuedesc">TIPE</span>
                                                <span class="uk-hidden chart-metadesc">TIKET</span>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-1 panel-box">
                                <div class="uk-panel uk-panel-box uk-padding-remove">
                                    <div class="uk-margin-top uk-margin-bottom uk-margin-large-left">
                                        <span class="chart-title"><span class="uk-text-bold chart-title-main">TOTAL GANGGUAN</span><span class="chart-title-sub"></span><span class="uk-hidden ctm-default">TOTAL GANGGUAN</span><span class="uk-hidden cts-default"></span></span>
                                        <span class="uk-text-small uk-float-right uk-margin-large-right">(* SEJAM YANG LALU</span>
                                    </div>
                                            <div class="ct-chart ct-major-twelfth" id="chart8"></div>
                                </div>
                            </div>
                            <div class="uk-width-1-2 uk-visible-large panel-box">
                                <div class="uk-panel uk-panel-box uk-padding-remove">
                                    <div class="uk-margin-top uk-margin-bottom uk-margin-large-left">
                                        <span class="chart-title"><span class="uk-text-bold chart-title-main">SLG</span><span class="chart-title-sub"></span><span class="uk-hidden ctm-default">SLG</span><span class="uk-hidden cts-default"></span></span>
                                    </div>
                                            <div class="ct-chart ct-octave" id="chart9"></div>
                                </div>
                            </div>
                            <div class="uk-width-1-2 uk-visible-large panel-box">
                                <div class="uk-panel uk-panel-box uk-padding-remove">
                                    <div class="uk-margin-top uk-margin-bottom uk-margin-large-left">
                                        <span class="chart-title"><span class="uk-text-bold chart-title-main">GAUL</span><span class="chart-title-sub"></span><span class="uk-hidden ctm-default">GAUL</span><span class="uk-hidden cts-default"></span></span>
                                    </div>
                                            <div class="ct-chart ct-octave" id="chart10">
                                            </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
<script>
var chart1 = new Chartist.Pie('#chart1', {
    series: [
        <?php for($x=0; $x<2; $x++): ?>
        {meta: '<?php echo $jenis_alpro[$x][1]; ?>', value: <?php echo $jenis_alpro[$x][0]; ?>},
        <?php endfor; ?>
    ],
}, 
{
    donut: true,
    showLabel: false,
    plugins: [
        Chartist.plugins.fillDonut({
            items: [
                { content: '<span class="chart-desc"><span class="chart-value">JENIS</span><br><span class="chart-info">ALPRO</span></span>' }
            ]
        })
    ]
});



var chart2 = new Chartist.Bar('#chart2', {
    series: [
[
<?php
    $limit = count($sto);
    for($x=0; $x<$limit; $x++): ?>
        <?php echo "{meta: '".$sto[$x][2]."', value: ".$sto[$x][0]."}"; ?>,
    <?php endfor; ?>
]

    ], labels: [
    <?php

    for($x=0; $x<$limit; $x++): ?>
            '<?php echo $sto[$x][1]; ?>',
    <?php endfor; ?>
    ]
}, 
{
    showLabel: false,
    fullWidth: true,
    stackBars: false,
    reverseData: false,
    chartPadding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0,
    },
    axisY: {
        showLabel: false,
        showGrid: false,
        offset: 0,
    },
    axisX: {
        showLabel: true,
        showGrid: true,
        offset: 60,
        labelOffset: {
          x: 0,
          y: 0
        },
    }
});

new Chartist.Pie('#chart3', {
    series: [
        {meta: 'A', value: 2},
    ], 
    labels: ['A']
}, 
{
    donut: true,
    showLabel: false,
    plugins: [
        Chartist.plugins.tooltip(),
        Chartist.plugins.fillDonut({
            items: [
                { content: '<span class="chart-desc"><span class="chart-value">JENIS</span><br><span class="chart-info">Layanan</span></span>' }
            ]
        })
    ]
});

var chart4 = new Chartist.Line('#chart4', {
    series: [

    <?php
    $limit = count($produk_ggn);
    $part = $limit/3;

    $start = $part * 3 - $part;
    $end = $part * 3;
    echo "[";
    for($x=$start; $x<$end; $x++): ?>
        {meta: '<?php echo $produk_ggn[$x][1]; ?>', value: <?php echo $produk_ggn[$x][0]; ?>},
    <?php endfor;
    echo "300],";
    ?>

    <?php

    $start = $part * 1 - $part;
    $end = $part * 1;
    echo "[";
    for($x=$start; $x<$end; $x++): ?>
        {meta: '<?php echo $produk_ggn[$x][1]; ?>', value: <?php echo $produk_ggn[$x][0]; ?>},
    <?php endfor;
    echo "200],";
    ?>

    <?php

    $start = $part * 2 - $part;
    $end = $part * 2;
    echo "[";
    for($x=$start; $x<$end; $x++): ?>
        {meta: '<?php echo $produk_ggn[$x][1]; ?>', value: <?php echo $produk_ggn[$x][0]; ?>},
    <?php endfor;
    echo "100],";
    ?>

    ], labels: [
    <?php

    $start = $part * 1 - $part;
    $end = $part * 1;
    for($x=$start; $x<$end; $x++): ?>
            '<?php 
        if($x == ($end-1)){
            $produk_ggn[$x][2] = $produk_ggn[$x][2]."*";
        }
        echo $produk_ggn[$x][2]; ?>',
    <?php endfor; ?>
    '']
}, 
{
    showLabel: false,
    showLine: false,
    showPoint: true,
    showArea: true,
    fullWidth: true,
    showArea: true,
    lineSmooth: true,
    areaBase: 1,
    high: 500,
    low: 0,
    reverseData: false,
    chartPadding: {
        top: 0,
        right: -10,
        bottom: 0,
        left: -10,
    },
    axisY: {
        showLabel: false,
        showGrid: false,
        offset: 0,
    },
    axisX: {
        showLabel: true,
        showGrid: true,
        offset: 60,
        labelOffset: {
          x: -8,
          y: 0
        },
    },
    plugins: [
        Chartist.plugins.tooltip(),

    ]
});

var chart5 = new Chartist.Pie('#chart5', {
    series: [
        <?php 
        $tclimit = count($tipe_cust);

        for($x=0; $x<$tclimit; $x++): ?>
        {meta: '<?php echo $tipe_cust[$x][1]; ?>', value: <?php echo $tipe_cust[$x][0]; ?>},
        <?php endfor; ?>
    ],
    labels: ['A']
}, 
{
    donut: true,
    showLabel: false,
    plugins: [
        Chartist.plugins.fillDonut({
            items: [
                { content: '<span class="chart-desc"><span class="chart-value">TIPE</span><br><span class="chart-info">CUSTOMER</span></span>' }
            ]
        })
    ]
});

var chart6 = new Chartist.Pie('#chart6', {
    series: [
        <?php for($x=0; $x<3; $x++): ?>
        {meta: '<?php echo $emosi_plg[$x][1]; ?>', value: <?php echo $emosi_plg[$x][0]; ?>},
        <?php endfor; ?>
    ],
    labels: ['A']
}, 
{
    donut: true,
    showLabel: false,
    plugins: [
        Chartist.plugins.fillDonut({
            items: [
                { content: '<span class="chart-desc"><span class="chart-value">EMOSI</span><br><span class="chart-info">Pelanggan</span></span>' }
            ]
        })
    ]
});

var chart7 = new Chartist.Pie('#chart7', {
    series: [
        <?php 
        $tclimit = count($tipe_tiket);

        for($x=0; $x<$tclimit; $x++): ?>
        {meta: '<?php echo $tipe_tiket[$x][1]; ?>', value: <?php echo $tipe_tiket[$x][0]; ?>},
        <?php endfor; ?>
    ],
    labels: ['A']
}, 
{
    donut: true,
    showLabel: false,
    plugins: [
        Chartist.plugins.fillDonut({
            items: [
                { content: '<span class="chart-desc"><span class="chart-value">TIPE</span><br><span class="chart-info">TIKET</span></span>' }
            ]
        })
    ]
});

var chart8 = new Chartist.Line('#chart8', {
series: [
[
<?php
    $limit = count($total);
    for($x=0; $x<$limit; $x++): ?>
        {meta: '<?php echo $total[$x][2]; ?>', value: <?php echo $total[$x][0]; ?>},
    <?php endfor; ?>
500]

    ], labels: [
    <?php

    for($x=0; $x<$limit; $x++): ?>
            '<?php 
        if($x == ($end-1)){
            $total[$x][1] = $total[$x][1]."*";
        }
        echo $total[$x][1]; ?>',
    <?php endfor; ?>
    ]
}, 
{
    showLabel: false,
    showLine: false,
    showPoint: true,
    showArea: true,
    fullWidth: true,
    showArea: true,
    lineSmooth: true,
    areaBase: 1,
    high: 700,
    low: 0,
    reverseData: false,
    chartPadding: {
        top: 0,
        right: -10,
        bottom: 0,
        left: -10,
    },
    axisY: {
        showLabel: false,
        showGrid: false,
        offset: 0,
    },
    axisX: {
        showLabel: true,
        showGrid: true,
        offset: 60,
        labelOffset: {
          x: -8,
          y: 0
        },
    },
    plugins: [
        Chartist.plugins.tooltip(),
        Chartist.plugins.ctPointLabels({
          textAnchor: 'middle'
        })
    ]
});

var chart10 = new Chartist.Bar('#chart10', {
    series: [
[
<?php
    $limit = count($gaularray);
    for($x=0; $x<$limit; $x++): ?>
        {meta: '<?php echo $gaularray[$x][2]; ?>', value: <?php echo $gaularray[$x][0]; ?>},
    <?php endfor; ?>
]

    ], labels: [
    <?php

    for($x=0; $x<$limit; $x++): ?>
            '<?php echo $gaularray[$x][1]; ?>',
    <?php endfor; ?>
    ]
}, 
{
    showLabel: false,
    fullWidth: true,
    stackBars: false,
    reverseData: false,
    chartPadding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0,
    },
    axisY: {
        showLabel: false,
        showGrid: false,
        offset: 0,
    },
    axisX: {
        showLabel: true,
        showGrid: true,
        offset: 60,
        labelOffset: {
          x: 0,
          y: 0
        },
    }
});



var chart9 = new Chartist.Bar('#chart9', {
    series: [
[
<?php
    $limit = count($slgarray);
    for($x=0; $x<$limit; $x++): ?>
        {meta: '<?php echo $slgarray[$x][2]; ?>', value: <?php echo $slgarray[$x][0]; ?>},
    <?php endfor; ?>
]

    ], labels: [
    <?php

    for($x=0; $x<$limit; $x++): ?>
            '<?php echo $slgarray[$x][1]; ?>',
    <?php endfor; ?>
    ]
}, 
{
    showLabel: false,
    fullWidth: true,
    stackBars: false,
    reverseData: false,
    chartPadding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0,
    },
    axisY: {
        showLabel: false,
        showGrid: false,
        offset: 0,
    },
    axisX: {
        showLabel: true,
        showGrid: true,
        offset: 60,
        labelOffset: {
          x: 0,
          y: 0
        },
    }
});

function donutOver() {
    var parent = $(this).closest(".ct-chart");
    var value = $(this).attr("ct:value");
    var meta = $(this).attr("ct:meta");

    var descp = parent.children(".ct-fill-donut-label");

    valuedesc = parent.children(".chart-valuedesc").text();
    metadesc = parent.children(".chart-metadesc").text();

    descp.find(".chart-value").text(value);
    descp.find(".chart-info").text(meta);
}

function donutLeave() {
    var parent = $(this).closest(".ct-chart");
    var value = $(this).attr("ct:value");

    var descp = parent.children(".ct-fill-donut-label");

    descp.find(".chart-value").text(valuedesc);
    descp.find(".chart-info").text(metadesc);
}

function barOver() {
    var parent = $(this).closest(".uk-panel");
    var value = $(this).attr("ct:value");
    var meta = $(this).attr("ct:meta");

    var descp = parent.find(".chart-title");

    descp.children(".chart-title-main").html(meta);
    descp.children(".chart-title-sub").text(" ("+value+")");
}

function barLeave() {
    var parent = $(this).closest(".uk-panel");
    var value = $(this).attr("ct:value");

    var descp = parent.find(".chart-title");

    var ctmd = descp.children(".ctm-default").text();
    var ctsd = descp.children(".cts-default").text();

    descp.children(".chart-title-main").text(ctmd);
    descp.children(".chart-title-sub").text(ctsd);
}

var addedEvents = false;
chart1.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-slice-donut" ).hover( donutOver, donutLeave);
  }
});

chart2.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-bar" ).hover( barOver, barLeave);
  }
});

chart4.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-point" ).hover( barOver, barLeave);
  }
});

chart5.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-slice-donut" ).hover( donutOver, donutLeave);
  }
});

chart6.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-slice-donut" ).hover( donutOver, donutLeave);
  }
});

chart7.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-slice-donut" ).hover( donutOver, donutLeave);
  }
});

chart8.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-point" ).hover( barOver, barLeave);
  }
});

chart9.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-bar" ).hover( barOver, barLeave);
  }
});

chart10.on('draw', function() {
  if (!addedEvents) {
    var valuedesc;
    var metadesc;
    $( ".ct-bar" ).hover( barOver, barLeave);
  }
});

</script>
</body>
</html>

<?php
    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>