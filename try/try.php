<!DOCTYPE html>
<html>
<body>

<?php
$data = serialize(array("key1"=>"value1", "key2"=>"value2", "key3"=>"value3", "key4"=>"value4", "key5"=>"value5"));
//echo $data, PHP_EOL;

//echo $parsed ,' ', PHP_EOL;
echo "The array is :";
echo "<br>";
echo "The size of Array in bytes is";
echo "<br>";
echo  mb_strlen($data, '8bit');
echo "<br>";
$parsed = unserialize($data);

//foreach($parsed as $name => $link){
  //  echo $link ,' ',$name, ' ';
//}
var_dump($parsed);
?>

</body>
</html>