<?php 

header('Access-Control-Allow-Origin: http://sofology.localhost.com');

$url = str_replace("http://api.localhost.com/","",$_SERVER['REQUEST_URI']);

$header = array('Referer: http://test.com',
        'Origin: http://www.uat.sofology.co.uk',
        'Connection: keep-alive',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
		'Accept-Encoding: gzip, deflate, sdch',
        'Accept: application/json, text/plain, */*',
        'Cache-Control: no-cache',
        'Except:');
		

		

function getWebPage($url)
{
	global $header;
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	$text = curl_exec($ch);
	return $text;
}

function getWebPage2($url) {	
global $header;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	$text = curl_exec($ch);
	return $text;
}

	
	if($url=="/catalog/sddsd")
	{
		//die;
		$string = file_get_contents("ExpressSofas.json");
		echo $string;
		
	}
	else {
		//die;
		echo getWebPage("http://api.uat.sofology.co.uk/api".$url);
	}





?>
