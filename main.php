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

$slide = array_key_exists("table", $_GET) ? trim($_GET["table"]) : '';

$result = mysqli_query($conn, "show tables");
if ($slide == '')
    $slide = mysqli_fetch_array($result)[0];
$sqlQuery = "SELECT * FROM " . $slide;

$resultSet = mysqli_query($conn, $sqlQuery) or die("<br>database error: ". mysqli_error($conn));


$path = "./table.csv";

$myfile = fopen($path, "w");

$developer = mysqli_fetch_assoc($resultSet);
if ($developer['stats'] != '' && $developer['stats'] != '0') {
    $arr=unserialize($developer ['stats']);
	array_pop($developer);
	foreach ($arr as $key => $val){
		$developer[$key] = $val;
	}
}
else
	array_pop($developer);


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

<label for="parameter">Filter:</label>
<select id="parameter">
<option></option>
<?php
	foreach ($developer as $key => $val)
		echo "<option>" . $key . "</option>";
?>
</select>

<select id="operator">
<option></option>
<?php
	foreach ($operators as $operator)
		echo "<option>" . $operator . "</option>";
?>
</select>

<input id="value">
<input type="button" value="Go" id="filter_btn">
<input type="button" id="add_filter_btn" value="Add Condition"/>
<br><br>

<script>

	var operators_url = {'==': "eq", "!=": "ne", ">": "gt", "<": "lt", ">=": "ge", "<=": "le"};
	document.getElementById("filter_btn").addEventListener("click", filter);
	function filter() {
		var e = document.getElementById("parameter");
		var strParam = e.options[e.selectedIndex].text;

		e = document.getElementById("operator");
		var strOp = e.options[e.selectedIndex].text;

		var strVal = document.getElementById("value").value;

		if (strParam.length == 0 || strOp.length == 0 || strVal.length == 0)
		{
			var uri = window.location.toString();
			if (uri.indexOf("?") > 0) {
				var clean_uri = uri.substring(0, uri.indexOf("?"));
				window.location.href = clean_uri;
			}
		}
		else
		{
			if (window.location.href.includes("?"))
				window.location.href += '&' + strParam + '=' + operators_url[strOp] + strVal;
			else
				window.location.href = '?' + strParam + '=' + operators_url[strOp] + strVal;
		}
	}

	document.getElementById("add_filter_btn").addEventListener("click", addCondition);
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
				foreach ($developer as $key => $val)
				{
					echo "<th>" . str_replace('_', ' ', $key) . "</th>";
					$line = $line . str_replace('_', ' ', $key) . ", ";
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
			if ($developer['stats'] != '' && $developer['stats'] != '0') {
				$arr =unserialize($developer ['stats']);
				array_pop($developer);
				foreach ($arr as $key => $val){
					$developer[$key] = $val;
				}
			}
			else
				array_pop($developer);
			$flag = true;
			$line = "";
			if (count($_GET) - isset($_GET['table']) > 0) // if there is parameter
			{
				foreach ($_GET as $key => $val)
				{
					if ($key !== 'table')
					{
						switch(substr($val, 0, 2))
						{
							case 'eq':
								if ($developer[$key] !== substr($val, 2))
									$flag = false;
								break;
							case 'ne':
								if ($developer[$key] === substr($val, 2))
									$flag = false;
								break;
							case 'lt':
								if ($developer[$key] >= substr($val, 2))
									$flag = false;
								break;
							case 'gt':
								if ($developer[$key] <= substr($val, 2))
									$flag = false;
								break;
							case 'le':
								if ($developer[$key] > substr($val, 2))
									$flag = false;
								break;
							case 'ge':
								if ($developer[$key] < substr($val, 2))
									$flag = false;
								break;
						}
					}
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