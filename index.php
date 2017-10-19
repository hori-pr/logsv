<?php
$host = "localhost";
$user = "hoge";
$pass = "";
$db = "test";
$tb = "log";

echo "<html>\n";
echo "<head>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n";
echo "<title>log</title>\n";
echo "</head>\n";

echo "<body>\n";

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno)
{
	die($mysqli->connect_error);
}
$mysqli->query("set names utf8") or die($mysqli->error);


$self = $_SERVER['PHP_SELF'];
echo "<a href=\"$self\">[all]</a>\n";
$query = "SELECT tag FROM tag GROUP BY tag";
$result = $mysqli->query($query) or die($mysqli->error);
while($row = $result->fetch_row())
{
	$tag = $row[0];
	echo "<a href=\"$self?tag=$tag\">[$tag]</a>\n";
}

if(empty($_GET['tag']))
{
	$query = "SELECT * FROM $tb ORDER BY id DESC LIMIT 32";
}
else
{
	$tag = $_GET['tag'];
	$query = "SELECT * FROM $tb INNER JOIN tag ON log.id=tag.id WHERE tag.tag='$tag' ORDER BY $tb.id DESC LIMIT 32";
}

$result = $mysqli->query($query) or die($mysqli->error);
echo "<table border=1>";
while($row = $result->fetch_row())
{
	$cnt = count($row);
	if($row[2] <= 8)
	{
		echo "<tr>";
	}
	else
	{
		echo "<tr>";
	}
	for($i = 0; $i < $cnt; $i++)
	{
		echo "<td><pre>";
		echo rawurldecode(str_replace('+', ' ', $row[$i]));
		echo "</pre></td>";
	}
	echo "</tr>";
}
echo "</table>";

$mysqli->close();

echo "</body>\n";
echo "</html>\n";
?>
