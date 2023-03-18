<?php
    require_once "path_definer.php";

    require $p_conf;
    require $p_conn;
    require $p_incl."login/function.php";

    require $webframe."webf_function.php";

    $webf_sidebar_type = 2;
    $webf_title = "nonatero";
    
    $path_type = 1;
    $path_level = 1;

    $page_title = "Dashboard | User Manager";

    $mode = array(
        array(1,"Insert Mode",0),
        array(2,"View/Delete Mode",0),
    );

    sec_session_start();

    if(login_check($query) && ($_SESSION["level"] == 1 || $_SESSION["level"] == 2)):

    require "remove.php";

    if($_SESSION["level"] == 2){
        $condition = " WHERE level > 2";
    }
    else {
        $condition = "";
    }

    if ($stmt = $query->prepare("SELECT id, username, name, level 
    FROM " . $t_members . $condition . "")) {

            $stmt->execute();   // Execute the prepared query.
            
            $result = $stmt->get_result();
            $stmt->close();
    }
 ?>
<!DOCTYPE html>
<html class="uk-height-1-1">
    <head>
    <?php
        require_once $webf_starter;
    ?>
    <script src="<?php pathcv($path_type, "js/components/sticky.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/jquery.stickytableheaders.min.js", $path_level); ?>"></script>
    <script src="<?php pathcv($path_type, "js/components/notify.min.js", $path_level); ?>"></script>
    <style>
    </style>
    </head>
    <body class="uk-height-1-1">
    <div class="sd-fixed sd-fixed-top">
        <a href="<?php pathcv($path_type, "dashboard/", $path_level); ?>"><i class="uk-icon-medium uk-icon-th-large uk-icon-spin uk-animation-hover"></i></a>
    </div>
        <div class="uk-height-1-1 uk-vertical-align">
            <div class="uk-width-1-1 uk-vertical-align-middle">
                <div class="uk-width-large-5-10 uk-width-medium-7-10 uk-width-small-8-10 uk-width-10-10 uk-container-center uk-margin-large-top uk-margin-large-bottom" id="container">
                            <div class="uk-grid uk-grid-width-1-1 uk-grid-small sd-table-insert uk-panel uk-panel-box uk-panel-box" data-uk-grid-margin="">
                            <table class="uk-table uk-table-hover sd-table-edit">
                                <thead>
                                    <tr>
                                        <th colspan="4"><h3 class="uk-contrast">USER MANAGER</h3></th>
                                    </tr>
                                    <tr>
                                        <th>LEVEL</th>
                                        <th>USERNAME</th>
                                        <th>NAME</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="uk-width-1-10 level"><?php echo $row["level"]; ?></td>
                                        <td class="uk-width-3-10 user"><?php echo $row["username"]; ?><span class="uk-hidden id"><?php echo $row["id"]; ?></span></td>
                                        <td class="uk-width-4-10 name"><?php echo $row["name"]; ?></td>
                                        <td class="uk-width-2-10">
                                            <a class="uk-button uk-button-primary sd-edit"><span class="uk-icon-pencil-square"></span></a>
                                            <a class="uk-button uk-button-danger sd-remove"><span class="uk-icon-trash"></span></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
        <form action='' method='POST' id='sub-option'>
            <div id="containerinput">
                <input type="hidden" name="mode" value="2"></input>
            </div>
        </form>
        <script>
        $( ".sd-remove" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#containerinput");

            var tr = $(this).closest("tr");
            var id = tr.find(".id").text();

            var accept = confirm('Are you sure want to remove this account?');
            if(accept == true){
                $("<input>").appendTo(icon).attr("type", "hidden").attr("value", id).attr("name", "id").attr("class", "inputinfo");

                form.submit();

                $(".inputinfo").remove();
            }
            else {
                event.preventDefault();
            }
        });

        $( ".sd-edit" ).click(function() {
            var form = $("#sub-option");
            var icon = $("#containerinput");

            var tr = $(this).closest("tr");
            var id = tr.find(".id").text();

            $("<input>").appendTo(icon).attr("type", "hidden").attr("value", id).attr("name", "id").attr("class", "inputinfo");

            form.attr("action", "form.php");
            form.attr("target", "_blank");
            form.submit();
            form.attr("target", "");
            form.attr("action", "");
            $(".inputinfo").remove();
        });

        <?php 
        if(empty($message)){
            if(isset($_GET["msg"])){
                        switch($_GET["msg"]) {
                            case 1:
                                $message = "User inserted.";
                                $alert = "success";
                                break;
                            case 2:
                                $message = "User updated";
                                $alert = "success";
                                break;
                        }
                    }
            }

            if(!empty($message)): ?>
                UIkit.notify("<?php echo $message; ?>", {timeout: 3000, status:'<?php echo $alert; ?>'});
        <?php endif;        ?>
        </script>
    </body>
</html>

<?php
mysqli_close($query);

else:
    header("Location: ".$r_logn."");
endif;
?>