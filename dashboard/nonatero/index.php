<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    $webf_header_type = 1;
    $webf_footer_type = 1;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 2;

    $page_title = "DIOC | NONATERO";

    if ($stmt = $query->prepare("SELECT COUNT(TROUBLE_NO) AS COUNT, TIPE_CUST 
    FROM " . $t_nona . " GROUP BY TIPE_CUST ORDER BY COUNT DESC")) {

            $stmt->execute();   // Execute the prepared query.
            $result = $stmt->get_result();

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
            "#363457","#735290","#797a9e","#9893da","#bbbdf6"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart1 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
                echo "stroke: ".$palette[$x]." !important;}";

        }
        ?>

        <?php

        $palette = array(
            "#77b6ea","#c7d3dd"
        );

        $alphabet = range('a', 'z');
        $pcs_arlen = count($palette);
        for($x = 0; $x < $pcs_arlen; $x++) {

                echo "#chart2 .ct-series-".$alphabet[$x]." .ct-slice-donut {";
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
                    <div class="uk-width-6-10">
                        <div class="uk-grid uk-grid-large">
                            <div class="uk-width-1-2">
                                <div class="ct-chart ct-square" id="chart1"></div>
                                <script>
                                new Chartist.Pie('#chart1', 
                                {
                                    series: [
                                    <?php

                                    while($row = $result->fetch_assoc()){
                                        if($row["TIPE_CUST"] == "TITANIUM/GOLD"){ $row["TIPE_CUST"] = "TITANIUM"; }
                                        echo "{meta: '".$row["TIPE_CUST"]."', value: ".$row["COUNT"]."},";

                                        if(!isset($count_total)) {
                                            $count_total = $row["COUNT"];
                                        }
                                        else {
                                            $count_total = $count_total + $row["COUNT"];
                                        }
                                    } ?>
                                    ],
                                    labels: [
                                    <?php
                                        $result->data_seek(0);
                                        while($row = $result->fetch_assoc()){
                                            echo "'".$row["TIPE_CUST"]."',";
                                        }
                                    ?>
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
                                                content: '<span class="chart-desc"><span class="chart-value"><?php echo $count_total; ?></span><br><span class="chart-info">Current</span></span>'
                                                }
                                            ]
                                        })
                                    ]
                                });
                                </script>
                            </div>
                            <div class="uk-width-1-2">
                                <div class="ct-chart ct-square" id="chart2"></div>
                                <script>
                                new Chartist.Pie('#chart2', 
                                {
                                    series: [
                                        {meta: 'Current', value: <?php echo $count_total; ?>},
                                        {meta: 'History', value: <?php echo $count_h; ?>}
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
                                                content: '<span class="chart-desc"><span class="chart-value"><?php echo $count_h; ?></span><br><span class="chart-info">History</span></span>'
                                                }
                                            ]
                                        })
                                    ]
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-2-10"></div>
                    <div class="uk-width-2-10">
                        <div class="uk-grid">
                            <div class="uk-width-1-1 uk-clearfix">
                            <!--<div class="uk-width-1-3">
                                    tengah
                                </div> -->
                                <div class="uk-width-3-4 uk-float-right sd-content-main-btn">
                                    <ul data-uk-grid-margin="" class="uk-grid">
                                        <li class="uk-width-1-1 uk-button-dropdown" data-uk-dropdown="{pos:'left-top', mode:'click'}">
                                            <a class="sd-button-large uk-button uk-width-1-1">
                                                <div class="uk-panel">
                                                    <div class="sd-badge uk-panel-badge"><i class="uk-icon-pencil-square-o uk-icon-large"></i></div>
                                                    <div class="uk-text-right"><span>AKSES</span><br><span>TABEL</span></div>
                                                </div>
                                            </a>
                                            <div class="uk-dropdown">
                                                <ul class="uk-nav uk-nav-dropdown">
                                                    <li><a href="current.php">Current</a></li>
                                                    <li><a href="history.php">History</a></li>
                                                    <li class="uk-nav-divider"></li>
                                                    <li><a href="cmdf.php">CMDF</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="uk-width-1-1 uk-grid-margin">
                                            <a class="sd-button-large uk-button uk-width-1-1" href="manual.php">
                                                <div class="uk-panel">
                                                    <div class="sd-badge uk-panel-badge"><i class="uk-icon-cogs uk-icon-large"></i></div>
                                                    <div class="uk-text-right"><span>UPDATE</span><br><span>MANUAL</span></div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            require_once $webf_footer;
        ?>
    </div>
</body>
</html>