<?php
/**
 * Describe plugin here
 
 */

elgg_register_event_handler('init', 'system', 'engape_init');

function engape_init() {
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

    elgg_register_page_handler('engap', 'engap_page_handler');

 }

function engap_gettoken($username, $password) {
	//error_log("user".$username);
	
    if (is_email_address($username)) {
		$users = get_user_by_email($username);
        if (is_array($users) && (count($users) == 1)) {
            $user = $users[0];
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
            $token = create_user_token($username,1440); //60 minutes
            if ($token) {
                $return['token'] = $token;
                $return['username'] = $user->username;
                $return['email'] = $user->email;
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
            echo "<ons-page id='no-page'><ons-toolbar><div class='left' style='color: #1284ff;' onclick='handle_go_back()'><ons-icon icon='ion-android-arrow-back'></ons-icon>Back</div><div class='center'>Not Found</div></ons-toolbar><br>";
            
            echo "<p>The View '".$view_path."' is not found at engap_page_handler()</p>";
            echo"</ons-page>";
        }
    return true;
}
    
    
function eg_reg_user($email,$password){
	$ar=split("@",$email);
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
                          OR rv.subject_guid IN (SELECT guid_two FROM {$db_prefix}entity_relationships WHERE guid_one=$owner_guid AND relationship='follower')
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
		$objsubtype = $obj->subtype ? $obj->subtype : 'default';			
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
if($refguid!=0){
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
        $subtype = $entity->subtype ? $riverobj->subtype : 'default';
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