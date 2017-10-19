<?php
require "./define.php";

$input = file_get_contents('php://input');
if(empty($input))
{
	echo "error";
}

$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno)
{
	die($mysqli->connect_error);
}
$mysqli->set_charset("utf8");
//$mysqli->query("set names utf8") or die($mysqli->error);

$ip = $_SERVER['REMOTE_ADDR'];
$data = explode("\n", $input);
$cnt = count($data);
$id = (int)$data[0];
$type = (int)$data[1];

$_len_str="len:".strlen($input);

if(empty($data[2]))
{
	$msg = "** empty **";
}
else
{
	$msg = $data[2];
}

if(empty($data[3]))
{
	$tag = "** empty **";
	$msg = "$msg($tag)$last_id";
}
else
{
	$tag = $data[3];
	$msg = "$msg($tag)$last_id";
}
//$query = "INSERT INTO $db.$tb(id,ip,type,msg) VALUES($id,'$ip',$type,'$msg')";
$query = "INSERT INTO $db.$tb(ip,type,msg) VALUES('$ip',$type,'$msg')";
$result = $mysqli->query($query) or die($mysqli->error);

if($cnt >= 4)
{
	$query = "select last_insert_id()";
	$result = $mysqli->query($query) or die($mysqli->error);
	if($row = $result->fetch_row())
	{
		$last_id = $row[0];
	}
	else
	{
		$last_id = "0";
	}

	$tags = explode(";", $data[3]);
	foreach($tags as $val)
	{
		$query = "INSERT INTO tag(id,tag) VALUES($last_id,'$val')";
		$result = $mysqli->query($query) or die($mysqli->error);
	}
}

$mysqli->close();

?>
