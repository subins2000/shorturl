<?header('Content-Type: text/html');
function rand_string( $length ) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}
$url=$_POST['url'];
$name = rand_string( 5 );
if (file_exists($name)){
$name = rand_string( 6 );
}else{
mkdir($name);
$ourFileHandle = fopen($name.'/index.html', 'x') or die("can't open file");
}
if(fwrite($ourFileHandle,'<!DOCTYPE html><html><head><meta http-equiv="refresh" content="0;url=$url"></head><html>')){
echo "{ action: 'shorten', status: 'success', url: '//msurl.tk/$name', total: '".(count(glob($_SERVER['DOCUMENT_ROOT'].'/*'))-3)."', message: '' }";
}
fclose($ourFileHandle);
?>
