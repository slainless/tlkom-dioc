<?php
	require_once "path_definer.php";

	require $p_conf;
	$webf_header_type = 1;
	$webf_title = "point";
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Variables component - UIkit tests</title>

        <link rel="stylesheet" href="css/uikit.css">
        <link rel="stylesheet" href="css/stardusk.css">

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

</head>
<body>
    <div class="uk-grid">
		<?php
			require_once $webf_header;
		?>
</div>
</body>
</html>