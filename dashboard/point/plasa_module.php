<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $webframe."webf_function.php";

    require $p_incl."login/function.php";

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] < 3)):

        if(isset($_POST["itiket"])){
        $itiket = filter_input(INPUT_POST, 'itiket', FILTER_SANITIZE_STRING);
        $itiketalt = $itiket;
        $prep_stmt = "SELECT * FROM ".$t_nona_pls." WHERE TROUBLE_NO = ? LIMIT 1";
            $stmt = $query->prepare($prep_stmt);
            
            if ($stmt) {
                $stmt->bind_param('s', $itiket);
                $stmt->execute();
                $stmt->bind_result($tiket, $ind, $inama, $icp, $ikeluhan, $idatek, $icsr, $iketerangan, $itanggal, $iflag);
                $stmt->fetch();
                $stmt->close();
                
                if (empty($itiket)) {
                    $itiket = $itiketalt;
                    $title = "INSERT ORDER PLASA";
                }
                else {
                    $title = "EDIT ORDER PLASA";
                }
                if(!empty($itanggal)){
                    $itanggal = explode("-", $itanggal);
                    $itanggal = $itanggal[2]."/".$itanggal[1]."/".$itanggal[0];
                }
            } else {
                $message = 'Database error.';
                $alert = 'danger';
                echo "failed";
            }
        }

?>

                            <form class="uk-form sd-box" action="" method="POST" id="modalform" name="registration-form">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box sd-shadow-box" data-uk-grid-margin="">
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
                                        <?php if(!empty($itiket)): ?>
                                        <input type="hidden" name="tiket" value="<?php echo $itiket; ?>">
                                        <input type="hidden" name="itiket" value="<?php echo $itiket; ?>">
                                        <input type='text' placeholder='TROUBLE NO' class='uk-width-1-1' disabled value="<?php echo $itiket; ?>">
                                        <?php else: ?>
                                        <input type='text' placeholder='TROUBLE NO' class='uk-width-1-1' name='tiket'>
                                        <?php endif; ?>

                                        <?php if(!empty($tiket)): ?>
                                        <input type="hidden" name="mode" value="1">
                                        <?php elseif(empty($tiket)): ?>
                                        <input type="hidden" name="mode" value="0">
                                        <?php endif; ?>       
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-key""></i>
                                        <input type='text' placeholder='ND TELP/INT' class='uk-width-1-1' name="nd" value="<?php echo $ind; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-user""></i>
                                        <input type='text' placeholder='NAMA PENGIRIM' class='uk-width-1-1' name="nama" value="<?php echo $inama; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-phone-square""></i>
                                        <input type='text' placeholder='CP PENGIRIM' class='uk-width-1-1' name="cp" value="<?php echo $icp; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-user""></i>
                                        <input type='text' placeholder='CSR' class='uk-width-1-1' name="csr" value="<?php echo $icsr; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-1-2 uk-width-small-1-1">
                                        <i class="uk-icon-phone-square""></i>
                                        <input type='text' placeholder='DATEK' class='uk-width-1-1' name="datek" value="<?php echo $idatek; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-small-1-1" >
                                        <textarea class='uk-width-1-1' placeholder="KELUHAN (max. 200 digit)" name="keluhan"><?php echo $ikeluhan; ?></textarea>
                                </div>
                                <div class="uk-form-icon uk-width-small-1-1" >
                                        <textarea class='uk-width-1-1' placeholder="KETERANGAN (max. 200 digit)" name="keterangan"><?php echo $iketerangan; ?></textarea>
                                </div>
                                <div class="uk-form-icon uk-width-medium-4-10 uk-width-small-1-1">
                                        <i class="uk-icon-calendar-plus-o""></i>
                                        <input type='text' placeholder='TANGGAL' class='uk-width-1-1' name="tanggal" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="<?php echo $itanggal; ?>">
                                </div>
                                <div class="uk-form-icon uk-width-medium-6-10 uk-width-small-1-1 uk-clearfix">
                                        <input type='text' placeholder='FLAG (ex. #00ff00)' id="cpicker" name="flag" value="<?php if(empty($iflag)) echo "rgba(0,0,0,0)"; else echo $iflag; ?>">
                                        <button type="reset" class="uk-button uk-button-danger uk-float-right uk-margin-small-left" value="1" name="submit">RESET</button>
                                        <button type="submit" class="uk-button uk-button-primary uk-float-right" value="1" name="submit" onclick="return formcheck(
                                           this.form.tiket,
                                           this.form.nd,
                                           this.form.nama);">SUBMIT</button>
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

                            function formcheck(tiket, nd, nama, perihal) {
    // Check each field has a value
        if (tiket.value == '' || nd.value == '' || nama.value == '') {
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
                    </form>

<?php
    mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;

?>