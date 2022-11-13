<?php
// MYSQL database functions [db.php] made by ekk, dkh-gh
	// include  database config
	include 'db_config.php';
	
	$_db = [
		// -- [creating connection to database] -- //
		'connect' => function() {
			$dbLink = mysqli_connect($GLOBALS['db_config']['hostname'], $GLOBALS['db_config']['username'], $GLOBALS['db_config']['password'], $GLOBALS['db_config']['basename']);
			for($i = 0; $i < count($GLOBALS['db_config']["sets"]); $i++)
				mysqli_query($dbLink, $GLOBALS['db_config']['sets'][$i]);
			return $dbLink;
		},
		
		// -- [close connection to database] -- //
		'disconnect' => function($dbLink) {
			mysqli_close($dbLink);
		},
// $GLOBALS['_db']['']()
		// -- [make query] -- //
		'query' => function($query) {
			$dbLink = $GLOBALS['_db']['connect']();
			$ret =  mysqli_query($dbLink, $query);
			$GLOBALS['_db']['disconnect']($dbLink);
			return $ret;
		},
		
		// -- [lines by column = value] -- //
		'get_lines' => function($table, $column, $value, $order=null) {
			$req = "SELECT * FROM `".$table."`";
			if($column != '*' && $value != '*')
				$req .= " WHERE `".$column."` = '".$value."'";
			if ($order)
				$req .= " ORDER BY `".$order."`";
			$q = $GLOBALS['_db']['query']($req);
			if($q) {
				$rows = [];
				while($row = mysqli_fetch_assoc($q))
					array_push($rows, $row);
				$ret = $rows;
			} 
			else 
				$ret = false;
			return $ret;
		},
		
		// -- [get lines by filter] -- //
		'filter' => function($table, $filters) {
			$q = "SELECT * FROM `".$table.'` WHERE';
			$i = 1;
			foreach($filters as $key => $filter) {
				$q .= " `".$key."` = '".$filter."' ";
				if(count($filters) > $i)
					$q .= " AND ";
				$i++;
			}
			$ret = $GLOBALS['_db']['query']($q);
			if(mysqli_num_rows($ret)) {
				$rows = [];
				while($row = mysqli_fetch_assoc($ret))
					array_push($rows, $row);
				$ret = $rows;
			}
			else
				$ret = false;
			return $ret;
		},
		
		// -- [get 1 line by column = value] -- //
		'get_line' => function($table, $column, $value) {
			$q = $GLOBALS['_db']['query']("SELECT * FROM `".$table."` WHERE `".$column."` = '".$value."'");
			$ret = false;
			if(mysqli_num_rows($q) == 1)
				$ret = mysqli_fetch_assoc($q);
			return $ret;
		},
		
		// -- [create line] -- //
		'add_line' => function($table, $columns, $values) {
			$q = "INSERT INTO `".$table."` (";
			$c = 0;
			foreach($columns as $col) {
				$q .= "`".$col."`";
				$c++;
				if($c != (count($columns)))
					$q .= ", ";
			}
			$c = 0;
			$q .= ") VALUES (";
			foreach($values as $val) {
				$q .= "'".$val."'";
				$c++;
				if($c != count($values))
					$q .= ", ";
			}
			$q .= ")";
			return $GLOBALS['_db']['query']($q);
		},
		
		// -- [delete line] -- //
		'delete_line' => function($table, $column, $value) {
			if(!$GLOBALS['_db']['get_line']($table, $column, $value))
				return false; 
			$q = "DELETE FROM `".$table
				."` WHERE `".$column."` = '".$value."'";
			return $GLOBALS['_db']['query']($q);
		},

		// -- [update cells by column = value] -- //
		'update_cells' => function($table, $column, $value, $values) {
			$q = "UPDATE `".$table."` SET ";
			foreach ($values as $col => $val) {
				$q .= "`".$col."` = '".$val."'";
				if(next($values))
					$q .= ", ";
			}
			$q .= " WHERE `".$column."` = '".$value."'";
			return $GLOBALS['_db']['query']($q);
		},
		
		// -- [get max id in table] -- //
		'get_max_ID' => function($table) {
			return intval(mysqli_fetch_array(
				$GLOBALS['_db']['query']('SELECT MAX(`id`) FROM `'.$table.'`')
			)[0]);
		},
		
		// -- [Jack the ripper :D (split the string and removes emptiness)] -- //
		'Jack' => function($data, $splitter) {
			$ret = explode($splitter, $data);
			for($i = count($ret); $i >= 0; $i--) {
				if($ret[$i] == '')
					array_splice($ret, $i, 1);
			}
			return $ret;
		},

	];
