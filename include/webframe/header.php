<?php
    require_once "webf_function.php";

    require_once "path_definer.php";
    require $p_conf;
?>
<?php if($webf_header_type == 1): ?>
    <div class="uk-width-1-1 sd-header-frame" id="top">
        <div class="sd-header uk-flex uk-flex-column">
            <div>
                <div class="uk-panel-space">
                    <div class="uk-clearfix">
                        <div class="uk-float-left">
                            <a href="#sidebar" class="sd-offcanvas-toggle" data-uk-offcanvas=""><i class="uk-icon-medium uk-icon-bars uk-icon-spin uk-animation-hover"></i></a>
                        </div>
                        <div class="sd-name uk-text-right uk-float-right">
                            <span class="sd-main-name  uk-text-uppercase">Muhammad Arham</span><br>
                            <span class="sd-sub-name  uk-text-uppercase">Admin Server</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sd-header-title uk-grid-width-1-2">
                <div class="uk-grid">
                    <div class="uk-width-3-5 uk-container-center">
                        <!-- <h1 class="sd-main-title uk-text-uppercase">DASHBOARD</h1>
                        <h1 class="sd-sub-title uk-text-uppercase">IOC-W</h1> -->
                        <img src="<?php pathcv($path_type, "assets/stardusk.svg", $path_level); ?>">
                    </div>
                </div>
            </div>
            <div class="sd-header-nav uk-grid">
                <div class="uk-width-1-2">
                    <div class="uk-grid">
                        <div class="uk-width-3-5 uk-container-center">
                            <ul class="uk-navbar-nav">
                                <li><a <?php if(compare($webf_title, "statistik")){ echo "class='active'"; } ?> href="<?php pathcv($path_type, "dashboard/statistik/", $path_level); ?>">STATISTIK</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div class="uk-grid">
                        <div class="uk-width-3-5 uk-container-center uk-clearfix">
                            <ul class="uk-navbar-nav uk-float-right">
                                <li><a <?php if(compare($webf_title, "nonatero")){ echo "class='active'"; } ?> href="<?php pathcv($path_type, "dashboard/nonatero/", $path_level); ?>">NONATERO</a></li>
                                <li><a <?php if(compare($webf_title, "point")){ echo "class='active'"; } ?> href="<?php pathcv($path_type, "dashboard/point/", $path_level); ?>">POINT</a></li>
                                <li><a <?php if(compare($webf_title, "rock")){ echo "class='active'"; } ?> href="<?php pathcv($path_type, "dashboard/rock/", $path_level); ?>">ROCK</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif($webf_header_type == 2): ?>
    <div class="uk-width-1-1 sd-header-frame">
        <div class="sd-header sd-header-small uk-flex uk-flex-column">
            <div>
                <div class="uk-panel-space">
                    <div class="uk-clearfix">
                        <div class="uk-float-left">
                         <a href="#sidebar" class="sd-offcanvas-toggle" data-uk-offcanvas=""><i class="uk-icon-medium uk-icon-bars uk-icon-spin uk-animation-hover"></i></a>
                        </div>
                        <div class="sd-name uk-text-right uk-float-right">
                                <img src="<?php pathcv($path_type, "assets/stardusk-small.svg", $path_level); ?>" style="height: 23px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>