<?php
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
		'sell' => ceil(preg_replace('/,/','',$data[4][$k])),
	);
}
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($rate,JSON_PRETTY_PRINT);
?>