<?php
include './dbex/db_connect.php';
	include './variables.php';
	$conn = OpenCon();
	$filters = isset($_POST['parameter']) && isset($_POST['operator']) && isset($_POST['value']) &&
	$_POST['parameter'] !== '' && $_POST['operator'] !== '' && $_POST['value'] !== '';

	$slide = array_key_exists("table", $_GET) ? trim($_GET["table"]) : '';

	$result = mysqli_query($conn, "show tables");
	if ($slide == '')
		$slide = mysqli_fetch_array($result)[0];
	$sqlQuery = "SELECT " . implode(",", $parameters) . ", stats FROM " . $slide;
	if ($filters)
	{
		if (array_key_exists($_POST['operator'], $operators_sql))
			$operator = $operators_sql[$_POST['operator']];
		else
			$operator = $_POST['operator'];

		if ($_POST['parameter'] == 'ending_reason')
			$_POST['value'] = '"' . $_POST['value'] . '"';
		$sqlQuery = $sqlQuery . " WHERE " . $_POST['parameter'] . $operator . $_POST['value'];
	}
	$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));
	
	$developer = mysqli_fetch_assoc($resultSet);
	$updated_parameters = $parameters;
	if ($developer['stats'] != '' && $developer['stats'] != '0'){
		$arr=unserialize($developer ['stats']);
		foreach ($arr as $key => $val)
			array_push($updated_parameters, $key);
	}
?>