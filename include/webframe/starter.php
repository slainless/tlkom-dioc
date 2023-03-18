<?php
    require_once "webf_function.php";

    require_once "path_definer.php";
    require $p_conf;
?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?></title>

        <link rel="icon" type="image/png" href="<?php pathcv($path_type, "favicon.ico", $path_level); ?>" sizes="16x16" />
        
        <link rel="stylesheet" href="<?php pathcv($path_type, "css/uikit.css", $path_level); ?>">
        <link rel="stylesheet" href="<?php pathcv($path_type, "css/stardusk.css", $path_level); ?>">

        <script src="<?php pathcv($path_type, "js/jquery.js", $path_level); ?>"></script>
        <script src="<?php pathcv($path_type, "js/uikit.min.js", $path_level); ?>"></script>