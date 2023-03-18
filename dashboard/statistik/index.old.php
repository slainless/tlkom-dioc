<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    $webf_header_type = 1;
    $webf_footer_type = 1;
    $webf_title = "statistik";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "DIOC | STATISTIK";

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, TIPE_CUST 
    FROM " . $t_nona . " GROUP BY TIPE_CUST  ORDER BY COUNT DESC")) {

            $stmt->execute();   // Execute the prepared query.
            $tipe = $stmt->get_result();

            $stmt->free_result();
            $stmt->close();

    }


    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, PRODUK_GGN 
    FROM " . $t_nona . " GROUP BY PRODUK_GGN  ORDER BY COUNT DESC")) {

            $stmt->execute();   // Execute the prepared query.
            $produk = $stmt->get_result();

            $stmt->free_result();
            $stmt->close();

    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, JENIS 
    FROM " . $t_nona . " GROUP BY JENIS  ORDER BY COUNT DESC")) {

            $stmt->execute();   // Execute the prepared query.
            $jenis = $stmt->get_result();

            $stmt->free_result();
            $stmt->close();

    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT_H 
    FROM " . $t_nona_h . "")) {

            $stmt->execute();   // Execute the prepared query.
            $stmt->bind_result($count_h);
            $stmt->fetch();

            $stmt->free_result();
            $stmt->close();
    }

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT_TIKET, TIPE_TIKET 
    FROM " . $t_nona . " GROUP BY TIPE_TIKET ORDER BY COUNT_TIKET DESC")) {

            $stmt->execute();   // Execute the prepared query.
            $sto = $stmt->get_result();

            $stmt->free_result();
            $stmt->close();
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

        <script src="<?php pathcv($path_type, "js/chartist.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-tooltip.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-fill-donut.min.js", $path_level); ?>"></script>


        <script src="js/core/core.js"></script>
        <script src="js/core/touch.js"></script>
        <script src="js/core/utility.js"></script>
        <script src="js/core/smooth-scroll.js"></script>
        <script src="js/core/scrollspy.js"></script>
        <script src="js/core/toggle.js"></script>
        <script src="js/core/alert.js"></script>
        <script src="js/core/button.js"></script>
        <script src="js/core/dropdown.js"></script>
        <script src="js/core/grid.js"></script>
        <script src="js/core/modal.js"></script>
        <script src="js/core/nav.js"></script>
        <script src="js/core/offcanvas.js"></script>
        <script src="js/core/switcher.js"></script>
        <script src="js/core/tab.js"></script>
        <script src="js/core/cover.js"></script>

        <script src="js/components/accordion.js"></script>
        <script src="js/components/autocomplete.js"></script>
        <script src="js/components/datepicker.js"></script>
        <script src="js/components/form-password.js"></script>
        <script src="js/components/form-select.js"></script>
        <script src="js/components/grid.js"></script>
        <script src="js/components/grid-parallax.js"></script>
        <script src="js/components/htmleditor.js"></script>
        <script src="js/components/lightbox.js"></script>
        <script src="js/components/nestable.js"></script>
        <script src="js/components/notify.js"></script>
        <script src="js/components/pagination.js"></script>
        <script src="js/components/parallax.js"></script>
        <script src="js/components/search.js"></script>
        <script src="js/components/slider.js"></script>
        <script src="js/components/slideset.js"></script>
        <script src="js/components/slideshow.js"></script>
        <script src="js/components/sticky.js"></script>
        <script src="js/components/timepicker.js"></script>
        <script src="js/components/tooltip.js"></script>
        <script src="js/components/upload.js"></script>

        <style>
        <?php

        $palette = array(
            "#735290","#9893da","#bbbdf6"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart1 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important;}";

        }

        $palette = array(
            "#33658a","#77b6ea","#c7d3dd"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart2 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important;}";

        }

        $palette = array(
            "#be5a38","#f06543","#f09d51"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart3 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important;}";

        }
        
        ?>
        </style>
</head>
<body>
    <?php
            require_once $webf_sidebar;
    ?>
    <div class="uk-grid">
        <?php
            require_once $webf_header;
        ?>
        <div class="uk-width-1-1 sd-content">
            <div class="sd-content-main uk-grid">
                <div class="uk-grid uk-container-center uk-width-8-10 uk-grid-collapse">
                    <div class="uk-width-1-1">
                        <div class="uk-grid uk-grid-large">
                            <div class="uk-width-1-3">
                                <div class="ct-chart ct-square" id="chart3"></div>
                                <script>
                                new Chartist.Pie('#chart3', 
                                {
                                    series: [
                                    <?php 
                                    while($row = $produk->fetch_assoc()) {
                                        echo "{meta: '".$row["PRODUK_GGN"]."', value: ".$row["COUNT"]."},";

                                        if(!isset($nona)) {
                                            $nona = $row["COUNT"];
                                        }
                                        else {
                                            $nona = $nona + $row["COUNT"];
                                        }
                                    }
                                    ?>
                                    ],
                                    labels: [
                                    ]
                                }, 
                                {
                                    donut: true,
                                    showLabel: false,
                                    plugins: [
                                        Chartist.plugins.tooltip(),
                                        Chartist.plugins.fillDonut({
                                            items: [
                                                {
                                                content: '<span class="chart-desc"><span class="chart-value">JENIS</span><br><span class="chart-info">Layanan</span></span>'
                                                }
                                            ]
                                        })
                                    ]
                                });
                                </script>
                            </div>
                            <div class="uk-width-1-3">
                                <div class="ct-chart ct-square" id="chart2"></div>
                                <script>
                                new Chartist.Pie('#chart2', 
                                {
                                    series: [
                                    <?php 
                                    while($row = $jenis->fetch_assoc()) {
                                        if($row["JENIS"] == ""){ $row["JENIS"] = "NO STO"; }
                                        echo "{meta: '".$row["JENIS"]."', value: ".$row["COUNT"]."},";
                                    }
                                    ?>
                                    ],
                                    labels: [
                                    ]
                                }, 
                                {
                                    donut: true,
                                    showLabel: false,
                                    plugins: [
                                        Chartist.plugins.tooltip(),
                                        Chartist.plugins.fillDonut({
                                            items: [
                                                {
                                                content: '<span class="chart-desc"><span class="chart-value">Jenis</span><br><span class="chart-info">Alpro</span></span>'
                                                }
                                            ]
                                        })
                                    ]
                                });
                                </script>
                            </div>
                            <div class="uk-width-1-3">
                                <div class="ct-chart ct-square" id="chart1"></div>
                                <script>
                                new Chartist.Pie('#chart1', 
                                {
                                    series: [
                                    <?php
                                    while($row = $sto->fetch_assoc()) {
                                        echo "{meta: '".$row["TIPE_TIKET"]."', value: ".$row["COUNT_TIKET"]."},";
                                    }
                                    ?>
                                    ],
                                    labels: [
                                    1, 2
                                    ]
                                }, 
                                {
                                    donut: true,
                                    showLabel: false,
                                    plugins: [
                                        Chartist.plugins.tooltip(),
                                        Chartist.plugins.fillDonut({
                                            items: [
                                                {
                                                content: '<span class="chart-desc"><span class="chart-value">Jenis</span><br><span class="chart-info">Gangguan</span></span>'
                                                }
                                            ]
                                        })
                                    ]
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-grid uk-container-center uk-width-8-10 uk-grid-collapse sd-content-main">
            <div class="uk-width-7-10">
            </div>
            <div class="uk-width-2-10">
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-clearfix">
                    <!--<div class="uk-width-1-3">
                            tengah
                        </div> -->
                        <div class="uk-width-3-4 uk-float-right sd-content-main-btn">
                            <ul data-uk-grid-margin="" class="uk-grid">
                                <li class="uk-width-1-1 uk-grid-margin">
                                    <a class="sd-button-large uk-button uk-width-1-1" href="manual.php">
                                        <div class="uk-panel">
                                            <div class="sd-badge uk-panel-badge"><i class="uk-icon-pie-chart uk-icon-large"></i></div>
                                            <div class="uk-text-right"><span>LIHAT</span><br><span>STATISTIK LENGKAP</span></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-10">
            </div>
        </div>
        <div class="uk-width-1-1 sd-main-chart">
            <div class="ct-chart .ct-double-octave" id="chart4"></div>
            <script>
                new Chartist.Line('#chart4', 
                {
                    series: [
                        [
                            {meta: 'Silver', value: 255}, 
                            {meta: 'Titanium', value: 55}, 
                            {meta: 'Platinum', value: 10},
                            {meta: 'Business', value: 25},
                            {meta: 'Enterprise', value: 30}
                        ]
                    ],
                    labels: [
                    1, 2, 3, 4, 5
                    ]
                }, 
                {
                    fullWidth: true,
                    showArea: true,
                    plugins: [
                        Chartist.plugins.tooltip()
                    ]
                });
            </script>
        </div>
        <?php
            require_once $webf_footer;
        ?>
    </div>
</body>
</html>