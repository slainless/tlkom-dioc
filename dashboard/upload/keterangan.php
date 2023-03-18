<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    sec_session_start();

    if(login_check($query) && $_SESSION["level"] < 3):

    // require "cmdf_proses.php";

    $webf_sidebar_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 1;

    $page_title = "Upload | Keterangan";

?>
<!DOCTYPE html>
<html class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/upload.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/tooltip.min.js", $path_level); ?>"></script>

    <script src="<?php pathcv($path_type, "js/custom-upload.js", $path_level); ?>"></script>
    <style>
    </style>
    </head>
    <body class="uk-height-1-1">
    <div class="sd-fixed sd-fixed-top">
        <a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-3-10 uk-width-medium-4-10 uk-width-small-5-10 uk-width-8-10 uk-container-center">
                    <div class="uk-form sd-box" action="#" method="post" enctype="multipart/form-data" id="uploadform">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                            <div class="uk-grid uk-text-center">
                                <h3 class="uk-contrast">UPLOAD KETERANGAN
                                </h3>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-width-large-4-10 uk-width-medium-4-10 uk-width-small-4-10">
                                    <select name="mode" class="uk-width-1-1" data-uk-tooltip="{pos:'left'}" title="LOAD MODE" id="mode">
                                        <option value="1">REPLACE</option>
                                        <option value="2">IGNORE</option>
                                    </select>
                                    <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-width-large-2-10 uk-width-medium-2-10 uk-width-small-2-10">
                                    <input class="uk-width-1-1" type="text" name="ignore" value="0" data-uk-tooltip="{pos:'top-left'}" title="IGNORE LINES" id="ignore"></input>
                                    <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-width-large-2-10 uk-width-medium-2-10 uk-width-small-2-10">
                                    <select name="limit" class="uk-width-1-1" data-uk-tooltip="{pos:'top-left'}" title="DELIMITER" id="limit">
                                        <option value="1">;</option>
                                        <option value="2">,</option>
                                    </select>
                                    <span data-uk-tooltip title=""></span>
                                </div>
                                <div class="uk-width-large-2-10 uk-width-medium-2-10 uk-width-small-2-10">
                                    <select name="enclose" class="uk-width-1-1" data-uk-tooltip="{pos:'top-right'}" title="(OPTIONAL) ENCLOSE" id="enclose">
                                        <option value="1">"</option>
                                        <option value="2">'</option>
                                    </select>
                                    <span data-uk-tooltip title=""></span>
                                </div>
                            </div>
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-small-1-1" id="fileuploader">
                                </div>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-width-small-1-1 uk-clearfix">
                                    <button class="uk-width-large-3-10 uk-width-medium-3-10 uk-width-small-3-10 uk-button uk-button-danger uk-float-right" type="text" placeholder="PASSWORD" id="submit">SUBMIT</button>
                                </div>
                            </div>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
    $(document).ready(function()
{

    var upload = $("#fileuploader").uploadFile({
    url:"ket_proses.php",
    fileName:"uploadfile",
    autoSubmit:false,
    maxFileCount:1,
    maxFileSize:11000*1024,
    multiple: false,
    allowedTypes: "csv",
    showProgress: true,
    showFileCounter:false,
    dynamicFormData: function() {
        var data = { limit: limit, mode: mode, ignore: ignore, enclose: enclose };
        return data;
    },
    onSuccess:function(files,data,xhr,pd)
    {
        //files: list of files
        //data: response from server
        var message = $.parseJSON(data);

        UIkit.notify(message.text, {timeout: 3000, status: message.alert});

    },
    customProgressBar: function(obj,s) {
        this.statusbar = $("<div class='uk-placeholder'></div>");
        this.preview = $("<img class='ajax-file-upload-preview' />").width(s.previewWidth).height(s.previewHeight).appendTo(this.statusbar).hide();
            this.filename = $("<div class='uk-text-bold uk-margin-small-bottom'></div>").appendTo(this.statusbar);
            this.progressDiv = $("<div class='uk-progress uk-progress-danger uk-progress-striped uk-active'>").appendTo(this.statusbar).hide();
            this.progressbar = $("<div class='uk-progress-bar'></div>").appendTo(this.progressDiv);
            this.abort = $("<div>" + s.abortStr + "</div>").appendTo(this.statusbar).hide();
            this.cancel = $("<div>" + s.cancelStr + "</div>").appendTo(this.statusbar).hide();
            this.done = $("<div class='uk-button uk-button-primary' id='done' onclick='location.reload(true)' disabled>" + s.doneStr + "</div>").appendTo(this.statusbar).hide();
            this.download = $("<div>" + s.downloadStr + "</div>").appendTo(this.statusbar).hide();
            this.del = $("<div>" + s.deletelStr + "</div>").appendTo(this.statusbar).hide();
                        this.abort.addClass("uk-button uk-button-danger");

            this.download.addClass("custom-green");            
            this.cancel.addClass("uk-button uk-button-danger");
            this.del.addClass("custom-red");
    }
    });

    $("#submit").click(function(){
        limit = $("#limit").val();
        mode = $("#mode").val();
        ignore = $("#ignore").val();
        enclose = $("#enclose").val();
        upload.startUpload();
    });

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