<?php
	/*$xml = simplexml_load_file("https://chantroimoimedia.com/feed/");
	foreach($xml->channel->item as $itm){
		$title = $itm->title;
		echo $title.'<br>';
	}*/
$ACCESS_TOKEN = "EAAAAUaZA8jlABANZAdqnaA1BebdK4WPhIfQUXgnqlb4ZBilgsdXGZBLTsXU0AWttM0v1lw4kh98Q4AGQ9gU8o2kSzGV4bjZCgPLGbaOoNT0LajNZBI0Fajl7Dkfv4RFLEnNRrofwDFubrhKuguPb5lhDsOrcpMuUCsbk98aIW7sZAQTtQrkZBAkPawcI9dZCWLlkZD";
$Friends = Check_Fiend($ACCESS_TOKEN);
//echo $Friends['friends'][0]['id'];

for ($i = 0 ; $i <count($Friends) -1; $i++){
	if($Friends['friends']['data'][$i]['id'])
		echo $Friends['friends']['data'][$i]['id'].' ';
}
	
function Check_Fiend($ACCESS_TOKEN){
	global $conn;
	$getFriend = (file_get_contents('https://graph.facebook.com/me?fields=friends&access_token='.$ACCESS_TOKEN));
			return json_decode(($getFriend),true);
}
?>
