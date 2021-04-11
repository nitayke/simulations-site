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
include './get_data.php';
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
		foreach ($parameters as $param)
			echo "<option" . ($_POST['parameter'] == $param ? " selected>".$param : ">".$param) . "</option>";
	else
		foreach ($parameters as $param)
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
<input type="submit" name="submit" value="Go">
</form>
<input type="button" id="button" value="Add Condition"/>

<script>
document.getElementById("button").addEventListener("click", addCondition);
function addCondition() {
	var itm = document.getElementById("filter1");
	itm.removeChild(document.getElementById("button"));
	var cln = itm.cloneNode(true);
	console.log(cln);
	document.getElementById("filters").appendChild(cln);
}
</script>

</div>
</div>


<!-- Table -->

<body>
	<table id="table">
	<thead>
		<tr id="min">
		<th>Min Value</th>
		</tr>
		<tr id="max">
		<th>Max Value</th>
		</tr>
		<tr id="avg">
		<th>Avg Value</th>
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
			$line = "";
			foreach ($parameters as $param)
			{
				echo "<td>" . $developer[$param] . "</td>";
				$line = $line . $developer[$param] . ", ";
			}
			$line = substr($line, 0, strlen($line) - 2);
			fwrite($myfile, $line);

			$line = "";
			if ($developer['stats'] != '' && $developer['stats'] != '0') {
				foreach ($arr as $key => $val){
					echo "<td>" . $val . "</td>";
					$line .= ", " . $val;
				}
			}
			$line .= "\n";
			fwrite($myfile, $line);

			echo "</tbody>";
		}
		fclose($myfile);
		?>
		</tbody>
	</table>


	<script>

		var BIG_NUM = 99999;
		var table = document.getElementById("table");
		var row_len = table.rows[4].cells.length;
		console.log(row_len);
		var min = new Array(row_len).fill(BIG_NUM), max = new Array(row_len).fill(0), sum = new Array(row_len).fill(0);
		for (var i = 0, row; row = table.rows[i]; i++)
		{
			for (var j = 1, cell; cell = row.cells[j]; j++)
			{
				if (isNaN(parseFloat(cell.innerHTML)))
					continue;
				var val = parseFloat(cell.innerHTML);

				if (j < 10) // bit cells
				{
					if (val == 1)
						cell.style.background = "#eff542";
					else if (val == 2)
						cell.style.background = "#f55742";
				}

				if (val < min[j])
					min[j] = val;

				if (val > max[j])
					max[j] = val;

				sum[j] += val;
			}
			
		}
		console.log(row_len);
		for (var i = 1; i < row_len; i++)
		{
			if (isNaN(parseFloat(table.rows[4].cells[i].innerHTML)))
			{
				console.log("hi");
				var rows = ["min", "max", "avg"];
				rows.forEach(function(entry) {
					var node = document.createElement("td");
					node.innerHTML = "";
					document.getElementById(entry).appendChild(node);
				});
				continue;
			}
			if (min[i] == BIG_NUM)
				continue;
			var node = document.createElement("td");
			node.innerHTML = min[i];
			document.getElementById("min").appendChild(node);

			var node = document.createElement("td");
			node.innerHTML = max[i];
			document.getElementById("max").appendChild(node);
			
			var node = document.createElement("td");
			if (i < 10)
				node.innerHTML = "";
			else
				node.innerHTML = (sum[i] / (table.rows.length - 4)).toFixed(2);
			document.getElementById("avg").appendChild(node);
		}

	</script>

</body>
</html>