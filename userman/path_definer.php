<?php

	$config_path = "dioc/server_config.php";
	$htdocs_suffix = "/";
	$htdocs_dash = $htdocs_suffix."dioc/";

	$p_conf = $_SERVER["DOCUMENT_ROOT"].$htdocs_suffix.$config_path;

	global $p_conf;
	global $htdocs_suffix;