<?php
	/*$xml = simplexml_load_file("https://chantroimoimedia.com/feed/");
	foreach($xml->channel->item as $itm){
		$title = $itm->title;
		echo $title.'<br>';
	}*/
	require_once 'modun_function.php';
	$tokens = Get_all_token();
	while ($token = mysqli_fetch_assoc($tokens)){
			$ACCESS_TOKEN = $token['access_token'];
			$id_token = $token['id'];
			if(_checkToken($ACCESS_TOKEN) == 1){
				$Getfriends = Check_Fiend($ACCESS_TOKEN);
				if($Getfriends != 0){
					for ($i = 0 ; $i< count ($Getfriends['friends']['data']) ; $i++){
						$uid = $Getfriends['friends']['data'][$i]['id'];
						//echo $uid.' ';
						$target_id = Check_in_list_target($uid);
						if($target_id != 0){
							//echo "đã có target Id ".$target_id.' '.$id_token;
							Add_token_to_list($id_token, $target_id);
						}	
					}
				}
				$Getgroups = Check_Group($ACCESS_TOKEN);
				//echo count($Getgroups['groups']['data']).' ';
				if($Getgroups != 0){
					for ($i = 0 ; $i< count ($Getgroups['groups']['data']) ; $i++){
						$group_id= $Getgroups['groups']['data'][$i]['id'];
						$target_id = Check_in_list_target($group_id);
						if($target_id != 0){
							//echo "đã có target Id ".$target_id.' '.$id_token;
							Add_token_to_list($id_token, $target_id);
						}	
					}
					//echo </br>;
				}
			}
		}
	//echo mysqli_num_rows($token);
?>
