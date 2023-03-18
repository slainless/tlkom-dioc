<?php

	require_once "path_definer.php";

	function pathcv($flag, $realp, $relup = 0) {

		global $htdocs_dash;
		if($flag == 1) {
			echo "//".$_SERVER['SERVER_NAME'].$htdocs_dash.$realp;
		}
		if($flag == 2) {
			$relpath = str_repeat("../", $relup);
			echo $relpath.$realp;
		}
	}

	function arlookup($value, $array, $special = 0){

    	$pcs_arlen = count($array);
        for($x = 0; $x < $pcs_arlen; $x++) {

            if($value == $array[$x][0]) {
                    return $array[$x][0];
                    break;
            }
        }
    }

	function print_option($value, $array, $special = 0){

        $arlen = count($array);

    	for($x = 0; $x < $arlen; $x++): ?>

			<option value='<?php echo $array[$x][0]; ?>'
			<?php
				switch($special){
					case 0:
						if($value == $array[$x][0]){
			        		echo " selected='selected'";
			        	}
			        	break;
			        case 1:
			        	if($value == $array[$x][1]){
			        		echo " selected='selected'";
			        	}
			        	break;
			    }
			?>
			><?php echo $array[$x][1]; ?></option>
    <?php	endfor;
	}

?>