<?php
/*PATHS*/
$path = '';
$php_self = explode("/",$_SERVER['PHP_SELF']);
$dir ='';
for($i=1;$i<count($php_self);$i++){
	$dir .= "/".$php_self[$i];
	$root = $_SERVER['DOCUMENT_ROOT'].$dir;
	if(is_dir($root)){
		$scan = scandir($root);
		if(in_array("application.php",$scan)){
			$path = $dir;
		}
	}
}

$self_path = "";
for($i=1;$i<count($php_self)-1;$i++){
	$self_path .= "/".$php_self[$i];
}
define("SELF_PATH","http://".$_SERVER['HTTP_HOST'].$self_path."/");
define("SELF_PAGE",end($php_self));
