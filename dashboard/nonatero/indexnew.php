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
?>
<!DOCTYPE html>
<html class="uk-height-1-1">
<head>
        <?php
            require_once $webf_starter;
        ?>
        <link rel="stylesheet" href="<?php pathcv($path_type, "js/chartist.css", $path_level); ?>">
        <link rel="stylesheet" href="<?php pathcv($path_type, "js/chartist-plugin-tooltip.css", $path_level); ?>">

        <script src="<?php pathcv($path_type, "js/chartist.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-tooltip.min.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/chartist-plugin-fill-donut.min.js", $path_level); ?>"></script>
</head>
<body>
    <div class="uk-grid">
        <nav class="uk-width-1-1 uk-navbar uk-navbar-attached" id="top">
            <div class="uk-margin-top uk-margin-bottom uk-width-1-1 uk-clearfix">
                <a class="uk-margin-left uk-float-left"><span class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></span></a>
                <img class="uk-margin-right uk-float-right" src="<?php pathcv($path_type, "assets/stardusk-small.svg", $path_level); ?>" style="height: 25px;>
            </div>
        </nav>
        <div class="uk-width-1-1 sd-content">
        </div>
    </div>
</body>
</html>