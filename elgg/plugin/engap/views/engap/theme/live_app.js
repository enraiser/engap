/*
 * all rights are reserved for enraiser.com
 *
 TBD
 elggentitylink
 elggpagelink
 
 */
function samaj_sharepage(){
    var msg = 'I love this mobile App.Lets build our Samaj on it.';
    var link = window.localStorage.getItem("group_url");
   // alert(link);
    window.plugins.socialsharing.share(msg, 'app for our Samaj',null, link);
}
function invite(to){
    var msg = 'I love this mobile App.Lets build our Samaj on it.';
	var ilink;
	user_name  = window.localStorage.getItem("username");
	
	if(to == 'friends'){
		ilink = site_url+'join/me/'+user_name;
	}else if(to == 'samaj'){
		ilink = site_url+'join/samaj/'+user_name;
	}else if(to = ''){
		ilink = site_url;
	}else{
		ilink = site_url;
	}
    //alert('path - '+ilink);
	//$('#relation').val("");
    window.plugins.socialsharing.share(msg, 'app for our Samaj',null, ilink);
}

function invite_family(){
	
	var relation;
	relation = $('#relation').val();
	var ilink1;
		if(!relation || relation == '' || relation== undefined){
			load_page("family_share");
				
		}else{
		ilink1 = site_url+'join/family/'+user_name+'/'+relation; 
		//engap_toast('you invite your '+relation);	
		window.plugins.socialsharing.share(msg, 'app for our Samaj',null, ilink1);
		}
 
}

function load_family(){
	var u_guid = window.localStorage.getItem("userguid");
	//alert(u_guid);
	load_page("family?guid="+u_guid);
}
function load_samaj_page(){
	var samaj_guid = window.localStorage.getItem("groupguid");
	//alert(u_guid);
	load_page("samaj_page?samaj_guid="+samaj_guid);
}