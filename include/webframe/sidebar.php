<?php
    require_once "webf_function.php";

    require_once "path_definer.php";
    require $p_conf;
?>
    <div id="sidebar" class="sd-offcanvas uk-offcanvas">
        <div class="uk-offcanvas-bar sd-offcanvas-bar">
                <div class="uk-grid"  style="height: 100%">
                    <div class="uk-width-1-1">
                        <div class="uk-panel-space uk-text-center"><img src="<?php pathcv($path_type, "assets/stardusk-brand.svg", $path_level); ?>" style=""></div>
                    </div>
                    <div class="uk-width-8-10 uk-container-center">
                        <div class="uk-grid uk-grid-collapse" data-uk-grid-margin="">
                                    <select class="uk-width-1-1" name="tiket">
                                        <?php print_option($_GET["tiket"], $op_tiket); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="plg">
                                        <?php print_option($_GET["plg"], $op_plg); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="sto">
                                        <?php print_option($_GET["sto"], $op_sto); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="produk">
                                        <?php print_option($_GET["produk"], $op_produk); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="alpro">
                                        <?php print_option($_GET["alpro"], $op_alpro); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="channel">
                                        <?php print_option($_GET["channel"], $op_channel); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="emosi">
                                        <?php print_option($_GET["emosi"], $op_emosi); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="hari">
                                        <?php print_option($_GET["hari"], $op_hari); ?>
                                    </select>
                                    <select class="uk-width-1-1" name="hc">
                                        <?php print_option($_GET["hc"], $op_hc); ?>
                                    </select>
                        </div>
                    </div>
                </div>
        </div>
    </div>