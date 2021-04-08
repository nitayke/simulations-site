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

<?php include './get_data.php'; ?>

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
	<table>
		<thead>
		<tr>
			<?php
				foreach ($updated_parameters as $param)
					echo "<th>" . str_replace('_', ' ', $param) . "</th>";
			?>
		</tr>
		</thead>

		<tbody>
		<?php
		while( $developer = mysqli_fetch_assoc($resultSet) ) {
			foreach ($parameters as $param)
				echo "<td>" . $developer[$param] . "</td>";
			if ($developer['stats'] != '' && $developer['stats'] != '0') {
				foreach ($arr as $key => $val)
					echo "<td>" . $val . "</td>";
			}
			echo "</tbody>";
		}
		?>
	</table>

</body>
</html>
