<?php
	
	$host = "localhost";
	$user = "root";
	$password = "";
	$databaseName = "sample-db";
	$con = mysqli_connect($host, $user, $password, $databaseName);
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  die();
	}
?>
<?php 
	
	function getTableNamesFromDatabse($databaseName, $con) {
		$selQuery = "show tables";
		$result = mysqli_query($con, $selQuery);
		if($result) {
			$tableNamesArray = array();
			while($table = mysqli_fetch_array($result)) {
			    array_push($tableNamesArray, $table[0]);
			}
			return $tableNamesArray;
		} else {
			return array();
		}
	}

	function getAllDataFromDatabase($tableNamesArray, $con) {
		$data = array();
		mysqli_query($con, "SET CHARACTER SET utf8");
		foreach($tableNamesArray as $tableName) {
			$query = "SELECT * FROM ".$tableName;
			$result = mysqli_query($con, $query);
			if(!$result) {
				echo "Something wrong in your query.</br>".$query;die();
			}
			$data[$tableName] = array();
			while($row = mysqli_fetch_assoc($result)) {
				array_push($data[$tableName], $row);
			}
		}
		return $data;
	}

	function getDataFromAllTableBasedQuery($tableNamesArray, $sort, $order, $limit, $con) {
		$data = array();
		mysqli_query($con, "SET CHARACTER SET utf8");
		foreach($tableNamesArray as $tableName) {
			$query = "SELECT * FROM ".$tableName." ".($sort?(" ORDER BY ".$sort.($order?" ".strtoupper($order):" ASC")):"")." ".($limit?"LIMIT ".$limit:"");
			$result = mysqli_query($con, $query);
			if(!$result) {
				echo "Something wrong in your query.</br>".$query;die();
			}
			$data[$tableName] = array();
			while($row = mysqli_fetch_assoc($result)) {
				array_push($data[$tableName], $row);
			}
		}
		return $data;
	}

	function getFinalData($tableNamesArray, $tableNameFromQuery, $sort, $order, $limit, $con) {
		$query = "";
		$data = array();
		if(!$tableNameFromQuery && !$sort && !$limit) {
			$data = getAllDataFromDatabase($tableNamesArray, $con);
		} else {
			if(!$tableNameFromQuery) {
				$data = getDataFromAllTableBasedQuery($tableNamesArray, $sort, $order, $limit, $con);
			} else {
				mysqli_query($con, "SET CHARACTER SET utf8");
				$query = "SELECT * FROM ".$tableNameFromQuery." ".($sort?(" ORDER BY ".$sort.($order?" ".strtoupper($order):" ASC")):"")." ".($limit?"LIMIT ".$limit:"");
				$result = mysqli_query($con, $query);
				if(!$result) {
					echo "Something wrong in your query.</br>".$query;die();
				}
				$data[$tableNameFromQuery] = array();
				while($row = mysqli_fetch_assoc($result)) {
					array_push($data[$tableNameFromQuery],$row);
				}	
			}
			
		}
		return $data;
	}
?>
<?php
	// getting all the table names
	$tableNamesArray = getTableNamesFromDatabse($databaseName, $con);
	$tableNameFromQuery = (isset($_REQUEST['table'])&&trim($_REQUEST['table'])?$_REQUEST['table']:"");
	$sort = (isset($_REQUEST['sort'])&&trim($_REQUEST['sort'])?$_REQUEST['sort']:"");
	$order = (isset($_REQUEST['order'])&&trim($_REQUEST['order'])?$_REQUEST['order']:"");
	$limit = intval((isset($_REQUEST['limit'])&&trim($_REQUEST['limit'])?$_REQUEST['limit']:0));
	$finalData = getFinalData($tableNamesArray, $tableNameFromQuery, $sort, $order, $limit, $con);
	echo json_encode($finalData);
	mysqli_close($con);
	die();
?>
