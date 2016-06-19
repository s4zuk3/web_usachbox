<?php

	require_once("../config.php");

	$ftp_connection = @ftp_connect(ftp_config::$server, ftp_config::$port) or die("Error connect FTP");
	$ftp_login = @ftp_login($ftp_connection, ftp_config::$username, ftp_config::$password) or die("Error login FTP");
	$path_length = strlen($ftp_path);
	$contents = @ftp_rawlist($ftp_connection, ftp_config::$ftp_path) or die("Error: No se pueden listar los archivos");
	$contents = join("\n", $contents);

	preg_match_all('/^([drwx+-]{10})\s+(\d+)\s+(\w+)\s+(\w+)\s+(\d+)\s+(.{12}) (.*)$/m', $contents, $matches, PREG_SET_ORDER);
	echo '<h3>Directorio: '.ftp_config::$ftp_path.'</h3>';
	echo '<table class="table table-bordered table-hover"><thead><th>Nombre</th><th>Peso</th><th>Fecha Última Modificación</th></thead><tbody>';
	
	    for ($i = 0 ; $i < count($matches) ; $i++){
	    	echo '<tr>';
	    	echo '<td>' . $matches[$i][7] . '</td>';
	    	echo '<td>';
	    	if( $matches[$i][5] < 1024 ){
	    		echo ''.$matches[$i][5].' B';
	    	}else if( round($matches[$i][5]/1024) < 1024){
	    		echo ''.round($matches[$i][5]/1024).' Kb';
	    	}else{
	    		echo ''.round($matches[$i][5]/(1024*1024)).' Mb';
	    	}
	    	echo '</td>';
	    	echo '<td>' . $matches[$i][6] . '</td>';
	    	echo '</tr>';
	    	
	    }
	echo '</tbody></table>';

	ftp_close($ftp_connection); 

?>


