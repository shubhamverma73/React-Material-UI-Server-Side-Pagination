<?php 

	//======== Real escape string ============
	function escape($text) {
		global $mysqli;
		return $mysqli->real_escape_string($text);
	}

	//========= Insert query function ======
	function insert($array, $table) {
		global $mysqli;
		$query = "";
				
		if(! is_array($array) ) {
			die("ERROR: Invalid Operation.");
		}
		foreach($array as $key => $value ) {
		  $query .= "`$key`='$value',";   		
		}
		$query = " insert into `$table` set ".substr($query, 0, -1);
		
		$mysqli->query($query) or die($mysqli->error);
		return $mysqli->insert_id;
		//return true;
	} 

	//============= Update query ==========================
	function update($array, $table, $where) {
		global $mysqli;
		$query = "";	

		if( !is_array($array) ) {
			die("Invalid Array");
		} else {
			foreach($array as $key => $value ) {
				$query .= "`$key`='$value',";   		
			}
		}
		
		if( !is_array($where) ) {
			$where = " where ".$where;
		} else {
			foreach($where as $key => $value ) {
				$where .= "`$key`='$value' and";
			}
			$where = substr($where, 0, -3);
		}

		$query = "update `$table` set ".substr($query,0,-1).$where;
		$mysqli->query($query) or die($mysqli->error);
		if( $mysqli->affected_rows > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	// ============= Var Dump ===================
	function dump($value){
		echo "<pre>"; var_dump($value); echo "</pre>";
	}
	
	function clean($string) {
        //$string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.
        
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

?>