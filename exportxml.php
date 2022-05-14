<?php
$data = file_get_contents('php://input');
$data = json_decode($data, true);
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
foreach($data as $v)
{
	$xml .= "\n<tile>";
	$xml .= "\n<tile_class>". $v['class']."</tile_class>";
	$xml .= "\n <tile_state>". $v['solid_state']. "</tile_state>";
	$xml .= "\n</tile>";

}

$file = "savedmap.xml";
$fh = fopen($file, 'w');
fwrite($fh, $xml);
fclose($fh);
?>