<?if(isset($_GET['last'])){?>
<table><tbody>
<h3>&nbsp;&nbsp;Latest shortened URL's&nbsp;&nbsp;</h3>
<?
$files = array();
$handle = opendir($_SERVER['DOCUMENT_ROOT'].'/');
while ($file = readdir($handle)) {
          $files[filemtime($file)] = $file;
   }
   closedir($handle);
ksort($files);
$reallyLastModified = end($files);
$files=array_reverse($files,TRUE);$cr=0;
foreach($files as $file) {
if (filetype($file)=='dir' && $cr!=11){$cr++;
$lastModified = date('F d Y, H:i:s',filemtime($file));if($file!='.' || $file!='..'){
$f=file_get_contents($file.'/index.html');if(preg_match('/\./',$file)){}else{
echo '<tr><td><count><a target="_blank" href="'.$file.'">'.$file.'</a></td><td>  -  </td><td>'.date ("F d Y H:i:s", filemtime($file)).'</td></count></tr>';}
}}}?>
</tbody></table>
<?}else{?>
<html xmlns="//www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>My Short URL</title>  
<style>
@CHARSET "ISO-8859-1";@importurl(//fonts.googleapis.com/css?family=Droid+Sans&amp;subset=latin);body {font-family: 'Droid Sans', Arial;color: #333333;font-size: 13px;margin: 0px;}.noteOrange {background-color: #E07E1B;font-family: 'Droid Sans', Arial;font-size: 11px;text-transform: uppercase;padding: 1px 3px;color: #FFFFFF;font-weight: normal;-moz-border-radius: 3px;border-radius: 3px;}.noteGreen {background-color: #45A14D;font-family: 'Droid Sans', arial;font-size: 11px;text-transform: uppercase;padding: 0px 3px;color: #FFFFFF;font-weight: normal;-moz-border-radius: 3px;border-radius: 3px;}#altText {margin: 50px;width: 450px;font-family: 'Droid Sans', Arial;font-size: 14px;color: #666666;}#container {border:1px solid black;border-radius:10px;background:#EEE;color:black;margin: 10% auto;width: 425px;padding: 18px;display: none;}#heading {font-family: 'Droid Sans', Arial;_background-color: #000000;color:black;font-size: 18px;_padding: 10px;margin-bottom: 5px;}#heading sup {color: #CCCCCC;font-size: 12px;}#urlbox {border-width: 1px;border-color: #CCCCCC;border-style: solid;}#url {font-family: 'Droid Sans', Arial;font-size: 15px;font-weight: normal;border-width: 0px;padding: 5px;color: #999999;width: 405px;outline-style: none; outline-width: 0px;}#statusDiv {display: none;margin-top: 10px;}#footer {font-family: 'Droid Sans', Arial;font-size: 12px;color: black;margin-top: 30px;display: block;_text-transform: uppercase;}#footer a {color:blue;}#closeStatusDivBtn {color: #999999;text-decoration: underline;margin-left: 8px;cursor: pointer;}#successDiv {font-family: 'Droid Sans', Arial;font-size: 13px;margin-top: 10px;_line-height: 20px;display: none;}#successDiv div {margin-bottom: 2px;}#successDiv a {color:blue;font-size: 15px;}#errorContainer{margin: 50px;width: 450px;padding: 0px;display: block;}#errorHead{font-family: 'Droid Sans', Arial;font-size: 18px;font-weight: normal;color: #AAAAAA;margin-bottom: 10px;}#side{padding-right:10px;position:absolute;right:40px;top:100px;background:#EEE;padding-bottom:10px;border:2px solid black;border-radius:10px;padding-left: 20px;}count{line-height:2em;}
</style>
<script src="//cdn-subins.hp.af.cm/java/jquery.js"></script>	
<script src="//subins.hp.af.cm/files/java/js.php"></script>	
<script>
var defaultUrl = "Enter your URL here and press ENTER";$(document).ready(function(){$("#altText").hide();$("#url").val(defaultUrl);$("#container").fadeIn();$("#closeStatusDivBtn").click(function(){$("#statusDiv").fadeOut();});$("#urlClearBtn").click(function(){$("#statusDiv").hide();$("#successDiv").hide();$("#url").val(defaultUrl);$("#url").css("color", "#CCCCCC");});$("#url").focusin(function(){if ($(this).val() == defaultUrl) $(this).val("");$(this).css("color", "#000000");});$("#url").focusout(function(){if ($(this).val() == ""){ $(this).val(defaultUrl);$(this).css("color", "#CCCCCC");}});$("#url").keypress(function(event){if (13 == event.which){event.preventDefault();if (isValidUrl($("#url").val())){$("#successDiv").hide();$("#successMessage").hide();$("#shortenedUrl").hide();$("#statusMessage").html('Trying to shorten the URL. Please wait ...');$("#closeStatusDivBtn").hide();$("#statusMessage").show();$("#statusDiv").show();
$.post("add.php", {url : $("#url").val(), data : "json"},function(data){showUrlShorteningStatus(data);});}else {$("#successDiv").hide();$("#statusMessage").html('<span class="noteOrange">Error</span> Invalid URL. Please enter a valid HTTP, HTTPs or FTP URL');$("#statusDiv").show();}}});});function showUrlShorteningStatus(data){var json = eval("(" + data + ")");$("count").text(json.total);var message = "";var countStr = "";var shortenedUrl = "";if ("success" == json.status){$.get('index.php?last',function(data){$("#side").html(data);});messagecountStr = getRequestCount(json.requests);message = (json.message.length > 0)? json.message: "Your URL is shortened.";shortenedUrl = "Your shortened URL is &raquo; <a href=\"" + json.url + "\">" + json.url + "</a>";}else{message = (json.message.length > 0)? json.message: "<span class=\"noteOrange\">Error</span> Unable to shorten the URL. Please enter a valid URL &amp; try again!";}$("#statusDiv").hide();$("#successMessage").html(message);if (shortenedUrl.length > 0) {$("#shortenedUrl").html(shortenedUrl);$("#shortenedUrl").show();}$("#successMessage").show();$("#successDiv").show();}function getRequestCount(count){var countStr = (0 == count) ? "first" : "";if (count > 0){countStr = (1 == count) ? "2<sup>nd</sup>" : (2 == count) ? "3<sup>rd</sup>" : (count + 1) + "<sup>th</sup>";}return (countStr);}function isValidUrl(aUrl) {  var urlregex = new RegExp("^(http:\/\/|https:\/\/|ftp:\/\/){1}([0-9A-Za-z]+\.)");  return urlregex.test(aUrl);}setInterval(function(){$.get('index.php?last',function(data){if($("#side").html()!=data){$("#side").html(data);}});},10000);
</script>
</head>
<body>
	<div id="container" style="display: block; ">
	
		<div id="heading">My Short URL</div><br>
		<div id="urlbox">
			<div style="width: 305px; display: inline-block;"><input type="text" id="url" placeholder="Enter your URL here and press ENTER" value="" style="color: rgb(0, 0, 0); "></div>
			<div style="padding: 6px 5px; float:right; display: inline-block;width:12px;">
				<img src="close.png" id="urlClearBtn" border="0" title="Clear the URL" width="16" height="16" style="cursor: pointer;">
			</div>
		</div>
		<div id="statusDiv" style="display: none; ">
			<span id="statusMessage" style="">Trying to shorten the URL. Please wait ...</span> 
			<span id="closeStatusDivBtn" style="display: none; ">Hide</span>
		</div>
		<div id="successDiv" style="display: block; ">
			<div id="successMessage" style="display: block; "></div>
			<div id="shortenedUrl" style="display: block; "></div>
		</div>
<div id="side"><table><tbody>
<h3>&nbsp;&nbsp;Latest shortened URL's&nbsp;&nbsp;</h3>
<?
$files = array();
$handle = opendir($_SERVER['DOCUMENT_ROOT'].'/');
while ($file = readdir($handle)) {
          $files[filemtime($file)] = $file;
   }
   closedir($handle);
ksort($files);
$reallyLastModified = end($files);
$files=array_reverse($files,TRUE);$cr=0;
foreach($files as $file) {
if (filetype($file)=='dir' && $cr!=11){$cr++;
$lastModified = date('F d Y, H:i:s',filemtime($file));if($file!='.' || $file!='..'){
$f=file_get_contents($file.'/index.html');if(preg_match('/\./',$file)){}else{
echo '<tr><td><count><a target="_blank" href="'.$file.'">'.$file.'</a></td><td>  -  </td><td>'.date ("F d Y H:i:s", filemtime($file)).'</td></count></tr>';}
}}}?>
</tbody></table>
</div>
		<div id="footer">
			<a href="//msurl.tk">My Short URL</a> created by <a href="//subins.hp.af.cm">Subins</a>  | 
			What is <a href="//en.wikipedia.org/wiki/URL_shortening">URL shortening</a>?
		</div>
<h2>Over <count><?echo count(glob($_SERVER['DOCUMENT_ROOT'].'/*'))-4;?></count> shortened URL's</h2>
	</div>
	<div id="altText" style="display: none; ">Loading external JS libs...</div>
</body></html><?}?>
