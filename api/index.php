<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
session_start();
if(isset($_SESSION["data"]) && !empty($_SESSION["data"])){ echo $_SESSION["data"];exit();}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.btpn.com/en/prime-lending-rate/kurs');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$page = preg_replace('/\r|\n/','',curl_exec($ch));
curl_close($ch);
preg_match_all('/<td>(.*?) \/ (.*?)<\/td>                                        <td>(.*?)<\/td>	                       				<td>(.*?)<\/td>/',$page,$data);
foreach($data[1] as $k => $v){
	if($data[2][$k] != 'IDR'){ continue; }
	$rate[] = array(
		'currency' => $data[1][$k],
		'buy' => ceil(preg_replace('/,/','',$data[3][$k])),
		'sell' => ceil(preg_replace('/,/','',$data[4][$k]))+500,
	);
}
$result = json_encode($rate);
$_SESSION["data"] = $result;
echo $result;
?>
