<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] < 3)):

    if(isset($_POST["nd_telp"], $_POST["nd_int"])){
    $nd_telp = filter_input(INPUT_POST, 'nd_telp', FILTER_SANITIZE_STRING);
    $nd_int = filter_input(INPUT_POST, 'nd_int', FILTER_SANITIZE_STRING);

    if(empty($nd_telp)){
        $nd = $nd_int;
    }
    else {
        $nd = $nd_telp;
    }

    $prep_stmt = "SELECT * FROM ".$t_nona_ket." WHERE ND = ? LIMIT 1";
                    $stmt = $query->prepare($prep_stmt);
                    
                    if ($stmt) {
                        if(empty($nd_telp)){
                            $stmt->bind_param('s', $nd_int);
                        }
                        else {
                            $stmt->bind_param('s', $nd_telp);
                        }
                        $stmt->execute();
                        $stmt->bind_result($ind, $iketerangan, $iexpire);
                        $stmt->fetch();
                        $stmt->close();
                        
                        if (!empty($itiket)) {
                            // A user with this email address already exists
                            $title = "EDIT KETERANGAN";
                        }
                        else {
                            $title = "INSERT KETERANGAN";
                        }

                        if(!empty($iexpire)){
                            $iexpire = explode("-", $iexpire);
                            $iexpire = $iexpire[2]."/".$iexpire[1]."/".$iexpire[0];
                        }
                    } else {
                        $message = 'Database error.';
                        $alert = 'danger';
                        echo "failed";
                    }
    }

?>
                    <form class="uk-form sd-box" action="" method="POST" id="modalform" name="registration-form">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                            <div class="uk-width-1-1">
                            <div class="uk-grid">
                            <div class="uk-width-1-1 uk-clearfix">
                                <div class="uk-grid">
                                    <div class="uk-width-9-10">
                                        <h3 class="uk-contrast"><?php echo $title; ?>
                                        </h3>
                                    </div>
                                    <div class="uk-width-1-10">
                                        <a id="modalclose" class="uk-modal-close uk-close uk-close-alt uk-float-right" style="color: black;"></a>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="uk-grid uk-grid-small" data-uk-grid-margin="">
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-key""></i>
                                        <?php if(!empty($nd)): ?>
                                        <input type="hidden" name="nd" value="<?php echo $nd; ?>">
                                        <input type='text' placeholder='ND TELP/INT' class='uk-width-1-1' disabled value="<?php echo $nd; ?>">
                                        <?php else: ?>
                                        <input type='text' placeholder='ND TELP/INT' class='uk-width-1-1' name='nd'>
                                        <?php endif; ?>
                                </div>
                                <div class="uk-form-icon uk-width-small-1-2">
                                        <i class="uk-icon-calendar-plus-o""></i>
                                        <input type='text' placeholder='TANGGAL' class='uk-width-1-1' name="expire" data-uk-datepicker="{format:'DD/MM/YYYY', pos:'bottom'}" value="<?php echo $iexpire; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-small-1-1" >
                                        <textarea class='uk-width-1-1' placeholder="KETERANGAN (max. 200 digit)" name="keterangan"><?php echo $iketerangan; ?></textarea>
                                </div>
                                <div class="uk-form-icon uk-width-small-1-1 uk-clearfix">
                                        <button type="reset" class="uk-button uk-button-danger uk-float-right uk-margin-small-left" value="1" name="submit">RESET</button>
                                        <button type="submit" class="uk-button uk-button-primary uk-float-right" value="1" name="submit" onclick="return formcheck(
                                           this.form.nd,
                                           this.form.expire);">SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    $("#cpicker").spectrum({
        showPaletteOnly: true,
        preferredFormat: "hex",
        allowEmpty: true,
        containerClassName: "sd-cpick-box",
        replacerClassName: "sd-cpick-input",
        palette: [
            ["rgba(0,0,0,0)"],
            ["#c00000", "#f79646", "#f5f445", "#7fd13b", "#4bacc6", "#1f497d", "#8064a2"],
            ["#a3171e", "#e36c09", "#dede07", "#5ea226", "#31859b", "#17365d", "#5f497a"],
            ["#6d0f14", "#974806", "#c0c00d", "#3f6c19", "#205867", "#0f243e", "#3f3151"],
        ]
    })

    function formcheck(nd, expire) {
    // Check each field has a value
        if (nd.value == '' || expire.value == '') {
            alert('You must provide all the requested details. Please try again');
            return false;
        }
    }

            $( "#modalclose" ).click(function() {
            var modal = $("#modalform");

            setTimeout(function() {
                modal.detach();
            }, 2000);
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