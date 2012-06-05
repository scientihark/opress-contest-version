<?php
function api_docstopdf($docsfilepath)
{
	$tempnow="java -jar ./jodconverter-core-3.0-beta-4.jar ".$docsfilepath." ".$docsfilepath.".pdf";
	echo $tempnow;
echo "<!--".exec($tempnow)."!-->";
}
?>
