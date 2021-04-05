<!DOCTYPE html>
<html lang="en">
<head>
	<title>Indoors Simulations</title>
	<meta charset="UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Della+Respira' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<?php
	include './dbex/db_connect.php';
	include './variables.php';
	$conn = OpenCon();
	$filters = isset($_POST['parameter']) && isset($_POST['operator']) && isset($_POST['value']) &&
	$_POST['parameter'] !== '' && $_POST['operator'] !== '' && $_POST['value'] !== '';
?>

<!-- Top Line - Title and links -->

<div style="display:flex; flex-direction: row; align-items: center;">
	<a href="/">
	<img src="drone.png" width="100"></a>

	<h1> Simulations scenarios</h1>
	
	<h2>Tables:&nbsp;</h2>

	<div class="pagination">
		<?php
		
		$slide = array_key_exists("table", $_GET) ? trim($_GET["table"]) : '';

		$result = mysqli_query($conn, "show tables");
		while($table = mysqli_fetch_array($result)) {
			if ($slide == '')
				$slide = $table[0];
			if ($table[0] == $slide)
				echo("<a href=\"?table=" . $table[0] . "\" class=\"active\">" . $table[0] . "</a>");
			else
				echo("<a href=\"?table=" . $table[0] . "\">" . $table[0] . "</a>");
		}?>
	</div>
</div>


<!-- Filters -->

<div style="display:flex; flex-direction: row; align-items: center;">

<form method="post">
<label for="parameter">Filter:</label>
<select name="parameter">
<option></option>
<?php
	if ($filters)
		foreach ($parameters as $param){
			echo "<option" . ($_POST['parameter'] == $param ? " selected>".$param : ">".$param) . "</option>";
	}
	else
		foreach ($parameters as $param)
			echo "<option>" . $param . "</option>";
	
?>
</select>

<select name="operator">
<option></option>
<?php
	if ($filters)
		foreach ($operators as $operator){
			echo "<option" . ($_POST['operator'] == $operator ? " selected>".$operator : ">".$operator) . "</option>";
		}
	else
		foreach ($operators as $operator)
			echo "<option>" . $operator . "</option>";

?>
</select>

<input name="value" value="<?php echo $filters ? $_POST['value'] : ''; ?>">
<input type="submit" name="submit" value="Filter">
</form>

</div>


<!-- Table -->

<?php
	$sqlQuery = "SELECT " . implode(",", $parameters) . ", stats FROM " . $slide;
	if ($filters)
	{
		if (array_key_exists($_POST['operator'], $operators_sql))
			$operator = $operators_sql[$_POST['operator']];
		else 
			$operator = $_POST['operator'];
		$sqlQuery = $sqlQuery . " WHERE " . $_POST['parameter'] . $operator . $_POST['value'];
	}
	$resultSet = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
	$resultSet2 = mysqli_query($conn, $sqlQuery) or die("database error:". mysqli_error($conn));
?>

<body>
	<table>
		<thead>
		<tr>
			<?php
				foreach ($parameters as $param)
				{
					echo "<th>" . str_replace("_", " ", $param) . "</th>";
				}
				$developer = mysqli_fetch_assoc($resultSet2);
				if ($developer['stats'] != '' && $developer['stats'] != '0'){ // TODO: REMOVE THE '0' AFTER REMOVING IT FROM DB
					$arr=unserialize($developer ['stats']);
					foreach ($arr as $key => $val)
						echo "<th>" . $key . "</th>";
				}?>
		</tr>
		</thead>

		<tbody>
		<?php
		while( $developer = mysqli_fetch_assoc($resultSet) ) { ?>
			<?php
				foreach ($parameters as $param) {
					echo "<td>" . $developer[$param] . "</td>";
				}
			if ($developer['stats'] != '' && $developer['stats'] != '0') { // SAME
				$arr2 = unserialize($developer ['stats']);
				foreach ($arr2 as $key => $val)
					echo "<td>" . $val . "</td>";
			}?>
		</tbody>
		<?php } ?>
	</table>

</body>
</html>
