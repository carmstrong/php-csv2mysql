<?php
	mysql_connect(':/Applications/MAMP/tmp/mysql/mysql.sock','root','root');
	$IMPORT_FILE = $argv[1];
	$EXPORT_FILE = $argv[2];
	$DB_NAME = $argv[3];
	$OPTION = $argv[4];
	$PK_INDEX = 0;
	$TABLE_NAME = basename($EXPORT_FILE,'.sql');
	
	$col_headings = array();
	$cols = array();
	$file = fopen($IMPORT_FILE,'r');
	$lineNum = 1;
	while( $line = fgetcsv($file) ){
		$num = count($line);
		for ($c=0; $c < $num; $c++) {
			if( $lineNum != 1){
	            $currentMaxLen = $cols[$c];
				$currentLen = strlen($line[$c]);
				if( $currentLen > $currentMaxLen){
					$cols[$c] = $currentLen;
				}
			}else{
				$name = $line[$c];
				$name = str_replace("'",'',$name);
				$name = str_replace("\"",'',$name);
				$col_headings[$c] = trim(substr($name,0,64));
			}
        }
		$lineNum++;
	}
	fclose($file);
	$heading_keys = array_keys($col_headings);
	$column_keys = array_keys($cols);
	$unused_cols = array_diff($heading_keys,$column_keys);
	# Print summary
	$output = fopen($EXPORT_FILE,'w');
	$numCols = count($col_headings);
	fwrite($output,"CREATE  TABLE `$DB_NAME`.`$TABLE_NAME` (\n");
	for($i = 0; $i< $numCols; $i++){
		if( !$unused_cols[$i] ){
			fwrite($output,'`'.$col_headings[$i]."` VARCHAR(".$cols[$i]."),\n");
		}
	}

	// Write primary key or not
	if ($OPTION != "--nopk") {
		// trim last comma
		fwrite($output);
		
		fwrite($output,"PRIMARY KEY (`$col_headings[$PK_INDEX]`)\n");
	}
	// Write character set
	fwrite($output, ") DEFAULT CHARACTER SET 'utf8';\n\n");
	// Re-open import file
	$file = fopen($IMPORT_FILE,'r');
	$lineNum = 1;
	while( $line = fgetcsv($file) ){
		if( $lineNum != 1){
			$num = count($line);
			$sql = 'INSERT INTO `'.$DB_NAME.'`.`'.$TABLE_NAME.'` VALUES(';
			for ($c=0; $c < $num; $c++) {
				if( !$unused_cols[$c] ){
					$sql .= "'".mysql_real_escape_string($line[$c])."', ";
				}
	        }
			$sql = rtrim($sql,", ");
			$sql .= ');';
			fwrite($output,$sql."\n");
		}
		$lineNum++;
	}
	fclose($file);
	fclose($output);
?>
