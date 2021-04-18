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

include './variables.php';
include './get_data.php';

?>

<body>


<!-- Top Line - Title and links -->

<div style="display:flex; flex-direction: row; align-items: center;">
	<a href="/">
	<img src="drone.png" width="100"></a>

	<h1>Simulations scenarios</h1>
	<script src="./javascript/table.js"></script>
	<label>Tables:</label>
	<select class="filter" onchange="selectChange(this)" id="table_choose">
		<?php
		
		$result = mysqli_query($conn, "show tables");

		while($table = mysqli_fetch_array($result)) {
			if ($table[0] == $slide)
				echo "<option selected>" . $table[0] . "</option>";
			else
				echo "<option>" . $table[0] . "</option>";
		}?>
	</select>
	<a href="/pichart.php" class="button">Pi Chart</a>

	<a href="/table.csv" class="button">Get .csv file</a>
</div>


<!-- Filters -->

<label for="parameter">Filters:</label>
<br>
<span id="filters">
<span>
<select id="parameter" onchange="paramChange(this)" class="filter">
<option></option>
<?php
	foreach ($developer as $key => $val)
		echo "<option>" . $key . "</option>";
?>
</select>

<select id="operator" class="filter">
<option></option>
<?php
	foreach ($operators as $operator)
		echo "<option>" . $operator . "</option>";
?>
</select>

<input id="value" class="filter">

<select id="ending_reason" hidden class="filter">
<option></option>
<?php
	foreach ($ending_reasons as $value)
		echo "<option>" . $value . "</option>";
?>
</select>

<select id="logic_op" hidden class="filter">
<option>And</option>
<option>Or</option>
</select>

</span>
</span>
<input type="button" value="Go" id="filter_btn" class="button">
<input type="button" id="add_filter_btn" value="Add Condition" class="button">
<br><br>

<script src="./javascript/filters.js"></script>


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
				if (!is_null($developer)) // empty table
					$parameters = $developer;
				foreach ($parameters as $param => $val)
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
		if (isset($_GET['filter']))
		{
			$filters = $_GET['filter'];
			foreach ($parameters as $key => $val)
			{
				$filters = str_replace($key, '$developer[\'' . $key . "']", $filters);
			}
			$filters = str_replace('*', '&&', $filters);
			$filters = str_replace('+', '||', $filters);
		}


		$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));
		while ($developer = mysqli_fetch_assoc($resultSet)) {
			if ($developer['stats'] != '' && $developer['stats'] != '0') {
				$arr =unserialize($developer ['stats']);
				array_pop($developer);
				foreach ($arr as $key => $val){
					$developer[$key] = $val;
				}
			}
			else
				array_pop($developer);
			$line = "";
			if (isset($_GET['filter']) && !eval("return " . $filters . ";"))
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

	<script src="./javascript/statistics.js"></script>

</body>
</html>