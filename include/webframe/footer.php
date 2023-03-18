<?php
    require_once "webf_function.php";

    require_once "path_definer.php";
    require $p_conf;
?>
<?php if($webf_footer_type == 1): ?>
        <div class="uk-width-1-1" id="bottom">
            <div class="sd-footer uk-flex uk-flex-column">
                <div>
                    <div class="uk-panel-space">
                        <div class="uk-clearfix">
                            <div class="uk-float-left">
                                <span class="sd-main-name uk-text-uppercase"><i class="uk-icon-chrome uk-icon-spin" style="font-size: 1.5rem; line-height: 1em; width: 1em; margin-right: 30px"></i></span>
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

<?php if($webf_footer_type == 2): ?>
        <div class="uk-width-1-1" id="bottom">
            <div class="sd-footer uk-flex uk-flex-column">
                <div>
                    <div class="uk-panel-space">
                        <div class="uk-clearfix">
                            <div class="uk-float-left">
                                <span class="sd-main-name"><i class="uk-icon-chrome uk-icon-spin" style="font-size: 1.5rem; line-height: 1em; width: 1em; margin-right: 30px"></i></span>
                            </div>
                            <div class="sd-name uk-text-right uk-float-right">
                                <span class="sd-main-name" style="font-size: 1.3rem;">Made in Makassar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php endif ?>