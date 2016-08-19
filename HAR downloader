<?php 

// HAR file is more-data.json
// Just download files associated with a webpage

$string = file_get_contents("more-data.json");
$domain = "https://www.example.co.uk/";

//set domain to site you want to download files from

$json_a = json_decode($string, true);
$urls = array();
$location = getcwd();
for($i = 0; $i<count($json_a['log']['entries']); $i++)
{
	
	$ph = $json_a['log']['entries'][$i]['request']['url'];
	if(strpos($ph,$domain) === 0)
	{
		 $url[$ph]=1;
	}
	
}
foreach($url as $key => $item)
{
	$pieces = explode("/",str_replace($domain,"",$key));
	if(count($pieces)>1)
	{
		$filename = explode("?",$pieces[count($pieces)-1])[0];
    //remove query string
		unset($pieces[count($pieces)-1]);
		$path = $location;
		foreach($pieces as $folder)
		{
			$path .= "\\".$folder;
			if (!file_exists(platformSlashes($path))) {
				mkdir(platformSlashes($path), 0775, true);
			}
			
			
		}
		getWebPage($key,platformSlashes($path."\\".$filename));
		
		
	}
}




function getWebPage($url,$location)
{
	$fp = fopen($location, 'w+');
	$username = "";
	$password = "";
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FILE, $fp); 
	//curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	//curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);	
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}

function platformSlashes($path) {
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
        $path = str_replace('/', '\\', $path);
    }
    return $path;
}

?>
