<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/setting_path.php";
	require $p_svropt;
	require $p_cnona;
	require $p_crock;

	require $p_inc . "database/fetch_setting.php";

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona . " AS nonatero";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($nonatero);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(ND) FROM " . $t_nona_cmdf . " AS cmdf";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($cmdf);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona_rhn . " AS rihana";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($rihana);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona_pls . " AS plasa";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($plasa);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona_odw . " AS dewa";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($dewa);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_rock . " AS rock";
	if ($stmt = $que_rock->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($rock);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_nona_h . " AS nona_h";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($nona_h);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "SELECT COUNT(TROUBLE_NO) FROM " . $t_rock_h . " AS rock_h";
	if ($stmt = $que_rock->prepare("" . $process . "")) // truncate nona tc
	{
		$stmt->execute();
		$stmt->bind_result($rock_h);

		$stmt->fetch();
		$stmt->close();

		echo "SUCCESS, QUERY -> $process<br>";
	}
	else
	{
		echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}

	$process = "UPDATE " . $t_stat . "
	SET 
	nonatero = ?,
	cmdf_plg = ?,
	rock = ?,
	dewa = ?,
	plasa = ?,
	rihana = ?,
	nona_h = ?,
	rock_h = ?
	WHERE id = 1";
	if ($stmt = $que_nona->prepare("" . $process . "")) // truncate nona tc
	{
            $stmt->bind_param("iiiiiiii", $nonatero, $cmdf, $rock, $dewa, $plasa, $rihana, $nona_h, $rock_h); 
            $stmt->execute();   // Execute the prepared query.

            echo "SUCCESS, QUERY -> $process<br>";
    }
    else
    {
    	echo "ERROR, QUERY -> $process, will exit now";
		exit();
	}
?>