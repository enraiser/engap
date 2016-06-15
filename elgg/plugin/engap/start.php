<?php
/**
 * Describe plugin here
 
 */

elgg_register_event_handler('init', 'system', 'engape_init');

function engape_init() {
	elgg_register_page_handler('face_upload', 'engap_faceupload_page_handler');
	expose_function("reg.user",
                "eg_reg_user",
                 array("email" => array('type' => 'string'),"password" => array('type' => 'string')),
                 'Register a new Users',
                 'GET',
                 false,
                 false
                );
	expose_function("list.river",
                "eg_list_river",
                 array("refid" => array('type' => 'string'),"type" => array('type' => 'string'),"extra" => array('type' => 'string'),"optr" => array('type' => 'string'),"limit" => array('type' => 'string')),
                 'Provide List of activity',
                 'GET',
                 false,
                 true
                );
	expose_function("list.entity",
                "eg_list_entity",
                 array("type" => array('type' => 'string'),"subtype" => array('type' => 'string'),"refguid" => array('type' => 'string'),"limit" => array('type' => 'string'),"extra" => array('type' => 'string'),"optr" => array('type' => 'string')),
                 'provide list of entity',
                 'GET',
                 false,
                 true
                );
    expose_function("get.entity",
                    "eg_get_entity",
                    array("guid" => array('type' => 'string')),
                    'Get the properties of an Entity',
                    'GET',
                    false,
                    false
                    );
    expose_function("refresh.icons",
                    "eg_refresh_entity_icons",
                    array("refreshlist" => array('type' => 'string')),
                    'returns icontimes for given  set of icons',
                    'GET',
                    false,
                    true
                    );
    expose_function("sync.entities",
                    "eg_sync_entities",
                    array("guids" => array('type' => 'string'),"iconguids" => array('type' => 'string')),
                    'returns icontimes for given  set of icons',
                    'GET',
                    false,
                    true
                    );

	expose_function("wire.post",
                "eg_wire_post",
                 array("wire_post" => array('type' => 'string'),),
                 'Wire Post',
                 'POST',
                 false,
                 true
                );
	expose_function(
		"engap.gettoken",
		"engap_gettoken",
		array(
			'username' => array ('type' => 'string'),
			'password' => array ('type' => 'string'),
		),
		elgg_echo('engap.gettoken'),
		'POST',
		false,
		false
	);
    expose_function(
		"engap.refreshtoken",
		"engap_refreshtoken",
		array(),
		elgg_echo('engap.refreshtoken'),
		'GET',
		false,
		true
	);
    expose_function("chat.post",
    "eg_chat_post",
    array("cp_guid" => array('type' => 'string'),"chat_post" => array('type' => 'string'),),
    'Chat Post',
    'POST',
    false,
    true
    );
	expose_function("chat.get",
    "eg_chat_get",
    array("cp_guid" => array('type' => 'string'),"refid" => array('type' => 'string'),"optr" => array('type' => 'string'),),
    'Chat Get',
    'GET',
    false,
    true
    );
    expose_function("submit.form",
                "eg_submit_form",
                 array("formname" => array('type' => 'string'),"formdata" => array('type' => 'string'),),
                 'html form',
                 'POST',
                 false,
                 true
                );
    elgg_register_page_handler('engap', 'engap_page_handler');
    elgg_register_plugin_hook_handler('rest', 'init', 'engape_rest_init');
 }
 function eg_chat_post($chatp_guid,$chat_post){
   
	error_log('here is chatpost - '.$chat_post);
	$userid = elgg_get_logged_in_user_guid();
	$query = "insert into  `chathistory` (`to_guid`,`from_guid`,`message`,`date`) values('".$chatp_guid."','".$userid."','".$chat_post."','".date('Y-m-d H:i')."')";
	insert_data($query);
	$last_record_id = "select `id` from `chathistory` where `from_guid`=".$userid." order by id desc limit 1";
	$aj = get_data($last_record_id);
	return json_encode($aj);
} 
function eg_chat_get($chatp_guid,$refid,$optr){
	if($optr = "gt")  $myoptr =">";
	elseif($optr = "lt")  $myoptr ="<";
	$userid = elgg_get_logged_in_user_guid();
	$query2 = "SELECT * FROM `chathistory` where id ".$myoptr.$refid." AND((to_guid= ".$chatp_guid." AND from_guid = ".$userid.") OR (to_guid= ".$userid." AND from_guid = ".$chatp_guid."))";//may be limit 10 needed  - Aj
	$aj = get_data($query2);
	$data = json_encode($aj);
	return $data; 
}
function engape_rest_init($hook, $type, $returnvalue, $params) {
    //TBD $method = get_input('method');  do only if method is engap related
     header('Access-Control-Allow-Origin: *');
    return false;
}
function engap_refreshtoken(){
    $token = create_user_token($username,1440);
    $return['token'] = $token;
    return $return;
}

function engap_gettoken($username, $password) {
    
	//error_log("user".$username);
	
    if (is_email_address($username)) {
		$users = get_user_by_email($username);
        if (is_array($users) && (count($users) == 1)) {
            $user = $users[0];
            $username = $user->username;
		}
    }else{
        $user = get_user_by_username($username);
    }
    
    	// validate username and password
    if($user instanceof ELGGUser){
        if (true === elgg_authenticate($username, $password)) {
            //expiry in minute
            //1 hour = 60
            //24 hours = 1440
            $token = create_user_token($username,1440); //1 day
            if ($token) {
                $return['token'] = $token;
                $return['username'] = $user->username;
				$return['user_guid'] = $user->guid;
                $return['email'] = $user->email;
                $return['phone'] = $user->phone;
                $return['city'] = $user->city;
				$return['avatar_path'] = $user->getIconURL('large');
                $plugin = elgg_get_plugin_from_id("engap");
                $return['plugin_version'] = $plugin->getManifest()->getVersion();
    
                return $return;
            }
        }
    }
    throw new SecurityException(elgg_echo('SecurityException:authenticationfailed'));

}
 
function engap_page_handler($segments)
{
    header('Access-Control-Allow-Origin: *');
    header('Cache-Control: max-age=2592000');
    elgg_set_viewtype('engap');
        $view_path  = implode("/", $segments);
		$aj = elgg_view($view_path,array());
        //echo elgg_view($view_path,array());
		if($aj) echo $aj;
		else  {
            header("HTTP/1.1 404 Not Found");
            echo "The View '".$view_path."' is not found at engap_page_handler()";
        }
    return true;
}
    
function eg_submit_form($formname,$formdata){
    error_log("the form".$formdata);
    if($formname =='profile'){
        $form_obj = json_decode($formdata);
        error_log("form phone  ".$form_obj->phone);
        $owner = elgg_get_logged_in_user_entity();
        error_log($owner->name." phone  ".$owner->phone);
        $owner->phone = $form_obj->phone;
        $owner->email = $form_obj->email;
        $owner->name = $form_obj->name;
        $owner->save();
    }
  return "success";
}

function eg_reg_user($email,$password){
    
	//$ar=str_split("@",$email);
	$ar=explode("@",$email);
    $username = $ar[0];
    $access_status = access_get_show_hidden_status();
    access_show_hidden_entities(true);
    if ($user = get_user_by_username($username)) {
        for($tmp=2;$tmp<1000;$tmp++){
            if (!($user = get_user_by_username($username.$tmp))) {
                $username .=$tmp;
                break;
            }
        }
    }
    access_show_hidden_entities($access_status);
    $ia = elgg_set_ignore_access(true);
    $guid1 = register_user($username,$password,$username,$email);

	elgg_set_user_validation_status($guid1, true, 'manual');
	elgg_set_ignore_access($ia);
	return $username;
}
    
function eg_refresh_entity_icons($refreshlist){
    $return = array();
    if($refreshlist!='none')
        $refresharr=explode(",", $refreshlist);
    else $refresharr = array();
    foreach( $refresharr as $objid){
        $obj = get_entity($objid);
        if($obj instanceof ElggEntity){
            $return[$objid]['iconurl'] = $obj->getIconURL();
            $it = $obj->icontime; if ($obj->icontime==null)$it='null';
            $return[$objid]['icontime']= $it;
        }
    }
    return $return;
}
function eg_sync_entities($guids,$iconguids){
   
    $return = array();
    if($iconguids!='none')
        $refresharr=explode(",", $iconguids);
    else $refresharr = array();
    foreach( $refresharr as $objid){
        $obj = get_entity($objid);
        if($obj instanceof ElggEntity){
            $return['icons'][$objid] = $obj->getIconURL();
        }
    }
    if($guids!='none')
        $guidsarr=explode(",", $guids);
    else $guidsarr = array();
    foreach( $guidsarr as $objid){
        $obj = get_entity($objid);
        if($obj instanceof ElggEntity){
                $entity_title = $obj->title ? $obj->title : $obj->name;
                $description = $obj->briefdescription ? $obj->briefdescription : elgg_get_excerpt($obj->description);

                $return['entities'][$objid]=array("title"=>$entity_title,'description'=>$description);
            

        }
    }
    return $return;
}
function eg_list_river($refid,$type,$extra,$optr,$limit){
   
    $owner_guid = elgg_get_logged_in_user_guid();

    $db_prefix = elgg_get_config('dbprefix');
    if($optr=='gt')$optr='>';else $optr='<';
    if($type=='newsfeed'){
    //newsfeed is the river where subjet_guid is self or friend
		$option = array(
			'limit' =>$limit,
			'joins' => array("JOIN {$db_prefix}entities object ON object.guid = rv.object_guid"),
			'wheres' => array("
                          rv.id $optr $refid AND (
                          rv.subject_guid = $owner_guid
                          OR rv.subject_guid IN (SELECT guid_two FROM {$db_prefix}entity_relationships WHERE guid_one=$owner_guid AND relationship='friend')
                          OR rv.subject_guid IN (SELECT guid_one FROM {$db_prefix}entity_relationships WHERE guid_two=$owner_guid AND relationship='friend'))
                      "),
        );

        $river_list= elgg_get_river($option);
 
	}elseif ($type='timeline'){
        if($extra == 'self')$extra = $owner_guid ;
        $sql = " FROM {$db_prefix}river rv ";
        $sql .= " WHERE (rv.object_guid = $extra)";
        $sql .= " OR    (rv.subject_guid = $extra)";
        //TBD I need rv.id $optr $refid

        //$total = get_data_row("SELECT count(DISTINCT rv.id) as total".$sql2);

        $river_list = get_data("SELECT DISTINCT rv.* ".$sql." ORDER BY rv.posted desc LIMIT $limit", 'elgg_row_to_elgg_river_item');
    }

    // Here you can chage site version to force the devices to cleanup the cached pages
    //Please note that its not version of engap.but its  just a string to command to client to delete all cached pages.
    //However you can use it like version for your files, related to engap. or version of your work.
    $return['site_version'] = '001';
    //TBD what if there is no data
    if($river_list and count($river_list) >0){
        error_log('river list size' . count($river_list));                    
	foreach($river_list as $riverobj){
		$subject = $riverobj->getSubjectEntity();
		$obj = $riverobj->getObjectEntity();
		//$summary = elgg_extract('summary', $vars, elgg_view('river/elements/summary',array('item'=>$vars['item'])));
		$action = $riverobj->action_type;
        $type = $riverobj->type;
         $subtype = $riverobj->subtype ? $riverobj->subtype : 'default';
        if($riverobj->type =='comment'){
            $key = "river:comment:$type:$subtype";
            $summary = elgg_echo($key, array($subject->name, "junk"));
        }elseif($riverobj->type =='user' and $action =='update'){
  
                    if($riverobj->view == 'river/user/default/profileiconupdate'){
                     //elgg_echo('river:update:user:avatar', array($subject_link));
                        $key = 'river:update:user:avatar';
                        $summary = elgg_echo($key , array($subject->name));
                    }
        }elseif($riverobj->type =='user' and $action =='friend'){
                        $key = 'river:friend:user:default';
                        $summary=$summary = elgg_echo($key, array($subject->name, $obj->name));
                

        }else{
                $key = "river:$action:$type:$subtype";
                $object_text = $obj->title ? $obj->title : $obj->name;
                $summary = elgg_echo($key, array($subject->name, $object_text));
        }
		$objsubtype = $obj->getSubtype();
		if(!$objsubtype) $objsubtype = 'default';
		//$objsubtype = $obj->subtype ? $obj->subtype : 'default';			
		$objectpath = "entity/".$obj->type."/".$objsubtype."/";//TBD shall we remove entity from object path.
        $description = $obj->briefdescription ? $obj->briefdescription : elgg_get_excerpt($obj->description);
		$return['fresh'][] = array("id"=>$riverobj->id,"title"=>$summary,"description"=>$description,"subject"=>$subject->getGUID(),"object"=>$obj->getGUID(),"objectpath"=>$objectpath);
	}
 	}else{
        $return['message'] = "No rever Item to display.";
    }
    return $return;
}
function eg_list_entity($type,$subtype,$refguid,$limit,$extra,$optr){
   
    if($refguid=='none')$refguid=0;
    if($refguid=='undefined')$refguid=0;
    
if($optr == 'gt'){
    error_log('refguid = '.$refguid.',  operator = '.$optr);
    
    $option = array(
                    'type'=>$type,
                    'limit'=>$limit,
          			'wheres' => array("e.guid  > $refguid "),
                    );
    if($subtype !='default')$option['subtype'] =$subtype;
    $entity_list= elgg_get_entities($option);
    $return['gt'] = array();
    foreach($entity_list as $entity){
        $entity_title = $entity->title ? $entity->title : $entity->name;
        $description = $entity->briefdescription ? $entity->briefdescription : elgg_get_excerpt($entity->description);
	$it = $entity->icontime; if ($entity->icontime==null)$it='null';
        $return['gt'][]=array("title"=>$entity_title,"guid"=>$entity->guid,"iconurl"=>$entity->getIconURL(),'description'=>$description,"icontime"=>$it,"time"=>$entity->time_updated);
    }
}
if($refguid!=0){//DOWBT shall we add   'and $optr!='lt''
    error_log('checking sync');

    $option = array(
                'type'=>$type,
                'limit'=>$limit,
                'wheres' => array("e.guid  <= $refguid "),
            );
    if($subtype !='default')$option['subtype'] =$subtype;
    //avoid entity list since we  just want guid and time
    $entity_list= elgg_get_entities($option);
    $return['sync'] = array();
    foreach($entity_list as $entity){
        $it = $entity->icontime; if ($entity->icontime==null)$it='null';
        $return['sync'][$entity->guid]=array('time'=>$entity->time_updated,"icontime"=>$it);
    }
}
                        
if($optr == 'lt'){
        error_log('refguid = '.$refguid.',  operator = '.$optr);
                        
        $option = array(
                    'type'=>$type,
                    'limit'=>$limit,
                    'wheres' => array("e.guid  < $refguid "),
                    );
        if($subtype !='default')$option['subtype'] =$subtype;
        $entity_list= elgg_get_entities($option);
        $return['lt'] = array();
        foreach($entity_list as $entity){
            $entity_title = $entity->title ? $entity->title : $entity->name;
            $description = $entity->briefdescription ? $entity->briefdescription : elgg_get_excerpt($entity->description);
            $it = $entity->icontime; if ($entity->icontime==null)$it='null';
            $return['lt'][]=array("title"=>$entity_title,"guid"=>$entity->guid,"iconurl"=>$entity->getIconURL(),'description'=>$description,"icontime"=>$it,"time"=>$entity->time_updated);
        }
}
	return $return;
}

function eg_get_entity($guid){
       
        $entity = get_entity($guid);
        $entity_title = $entity->title ? $entity->title : $entity->name;
        $subtype = $entity->subtype ? $entity->subtype : 'default';
        $description = $entity->briefdescription ? $entity->briefdescription : elgg_get_excerpt($entity->description);
        return array("title"=>$entity_title,"guid"=>$entity->guid,"iconurl"=>$entity->getIconURL(),"type"=>$entity->type,"subtype"=>$subtype,'description'=>$description);
}
function eg_wire_post($wire_post){
   
	error_log('here is wirepost - '.$wire_post);
	$userid = elgg_get_logged_in_user_guid();
	$access_id = "public";
	 $return['guid']  =  thewire_save_post($wire_post,$userid,$access_id);
	return $return;
} 
function engap_faceupload_page_handler($page) {
//elgg_load_library('elgg:facepp');
$ia = elgg_set_ignore_access(true);
	header('Access-Control-Allow-Origin: *');

	$image_title = $_POST['image_title'];
	$image_pos = $_POST['image_pos'];
    $user = get_user_by_username($_POST['username']);

    login($user);



	if($image_pos == 0){
        $guid = $user->guid;

        $icon_sizes = elgg_get_config('icon_sizes');

        $tfiles = array();
        foreach ($icon_sizes as $name => $size_info) {

			$resized = get_resized_image_from_uploaded_file('file', $size_info['w'], $size_info['h'], $size_info['square'], $size_info['upscale']);
            if ($resized) {
                //@todo Make these actual entities.  See exts #348.
                $file = new ElggFile();
                $file->owner_guid = $guid;
                $file->setFilename("profile/{$guid}{$name}.jpg");
                $file->open('write');
                $file->write($resized);
                $file->close();
                $tmpfiles[] = $file;
            } else {
                // cleanup on fail
                foreach ($tmpfiles as $tfile) {
                    $tfile->delete();
                }
            }
        }

        $user->icontime = time();
        if (elgg_trigger_event('profileiconupdate', $user->type, $user)) {
            error_log(elgg_echo("avatar:upload:success"));

            $view = 'river/user/default/profileiconupdate';
            elgg_delete_river(array('subject_guid' => $user->guid, 'view' => $view));
            elgg_create_river_item(array(
                'view' => $view,
                'action_type' => 'update',
                'subject_guid' => $user->guid,
                'object_guid' => $user->guid,
            ));
        }
	}


    elgg_set_ignore_access($ia);
	echo $user->getIconURL('large');
       
    return true;
}
