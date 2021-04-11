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

$slide = array_key_exists("table", $_GET) ? trim($_GET["table"]) : '';

$result = mysqli_query($conn, "show tables");
if ($slide == '')
    $slide = mysqli_fetch_array($result)[0];
$sqlQuery = "SELECT * FROM " . $slide;

$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));

$developer = mysqli_fetch_assoc($resultSet);
$updated_parameters = $parameters;
if ($developer['stats'] != '' && $developer['stats'] != '0'){
    $arr=unserialize($developer ['stats']);
    foreach ($arr as $key => $val)
        array_push($updated_parameters, $key);
}


$path = "./table.csv";

$myfile = fopen($path, "w");
?>

<body>


<!-- Top Line - Title and links -->

<div style="display:flex; flex-direction: row; align-items: center;">
	<a href="/">
	<img src="drone.png" width="100"></a>

	<h1>Simulations scenarios</h1>
	
	<label>Tables:</label>

	<div class="pagination">
		<?php
		
		$result = mysqli_query($conn, "show tables");

		while($table = mysqli_fetch_array($result)) {
			if ($table[0] == $slide)
				echo("<a href=\"?table=" . $table[0] . "\" class=\"active\">" . $table[0] . "</a>");
			else
				echo("<a href=\"?table=" . $table[0] . "\">" . $table[0] . "</a>");
		}?>
	</div>
	
	<a href="/pichart.php" class="button">Pi Chart</a>

	<a href="/table.csv" class="button">Get .csv file</a>
</div>


<!-- Filters -->

<div id="filters">
<div style="display:flex; flex-direction: row; align-items: center;" id="filter1">

<form method="post">
<label for="parameter">Filter:</label>
<select name="parameter">
<option></option>
<?php
	if ($filters)
		foreach ($updated_parameters as $param)
			echo "<option" . ($_POST['parameter'] == $param ? " selected>".$param : ">".$param) . "</option>";
	else
		foreach ($updated_parameters as $param)
			echo "<option>" . $param . "</option>";
	
?>
</select>

<select name="operator">
<option></option>
<?php
	if ($filters)
		foreach ($operators as $operator)
			echo "<option" . ($_POST['operator'] == $operator ? " selected>".$operator : ">".$operator) . "</option>";
	else
		foreach ($operators as $operator)
			echo "<option>" . $operator . "</option>";
?>
</select>

<input name="value" value="<?php echo $filters ? $_POST['value'] : ''; ?>">
<input type="submit" name="submit" value="Go" id="submit">
</form>
<input type="button" id="button" value="Add Condition"/>

</div>
</div>

<script>
	document.getElementById("button").addEventListener("click", addCondition);
	function addCondition() {
		var itm = document.getElementById("filters").lastElementChild;
		var addCondition = itm.removeChild(document.getElementById("button"));
		var go = itm.lastElementChild.removeChild(document.getElementById("submit"));
		var cln = itm.cloneNode(true);
		cln.lastElementChild.appendChild(go);
		cln.appendChild(addCondition);
		document.getElementById("filters").appendChild(cln);
	}
</script>


<!-- Table -->

<body>
	<table id="table">
	<thead>
		<tr id="min">
		<th>Min</th>
		</tr>
		<tr id="max">
		<th>Max</th>
		</tr>
		<tr id="avg">
		<th>Avg</th>
		</tr>
		<tr>
			<?php
				$line = "";
				foreach ($updated_parameters as $param) 
				{
					echo "<th>" . str_replace('_', ' ', $param) . "</th>";
					$line = $line . str_replace('_', ' ', $param) . ", ";
				}
				$line = substr($line, 0, strlen($line) - 2) . "\n";
				fwrite($myfile, $line);
			?>
		</tr>
		</thead>

		<tbody>
		<?php
		$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));
		while ($developer = mysqli_fetch_assoc($resultSet)) {
			$flag = true;
			$line = "";
			if ($developer['stats'] != '' && $developer['stats'] != '0') {
				array_pop($developer);
				foreach ($arr as $key => $val){
					$developer[$key] = $val;
				}
			}
			else
				array_pop($developer);
			if ($filters)
			{
				switch ($_POST['operator'])
				{
					case '==':
						if ($developer[$_POST['parameter']] !== $_POST['value'])
							$flag = false;
						break;
					case '!=':
						if ($developer[$_POST['parameter']] === $_POST['value'])
							$flag = false;
						break;
					case '<':
						if ($developer[$_POST['parameter']] >= $_POST['value'])
							$flag = false;
						break;
					case '>':
						if ($developer[$_POST['parameter']] <= $_POST['value'])
							$flag = false;
						break;
					case '<=':
						if ($developer[$_POST['parameter']] > $_POST['value'])
							$flag = false;
						break;
					case '>=':
						if ($developer[$_POST['parameter']] < $_POST['value'])
							$flag = false;
						break;
				}
				
			}
			if ($flag === false)
				continue;
			foreach ($developer as $key => $val)
			{
				echo "<td>" . $val . "</td>";
				$line = $line . $val . ", ";
			}
			$line = substr($line, 0, strlen($line) - 2) . "\n";
			fwrite($myfile, $line);

			echo "</tbody>";
		}
		fclose($myfile);
		?>
	</table>

	<script src="./main.js"></script>

</body>
</html>