<?php
	//"../ripple/"
	$path = elgg_get_site_url().'face/';
?>
<ons-page id='edit_avatar'  style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="center elipsis">Avatar Change</div>
		<div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon></div>
    </ons-toolbar>
	<div style='background-color:white;padding:5px;border-radius:5px;width:90%;margin:0px auto;border:1px solid #ddd;margin:10px;'>
		<div style='width:100%;border-radius:5px;background-image:url({{avatar_path}});background-size:100% 100%;min-height:250px;height:100%;'></div>
		<button class="button button--quiet" onclick="upload_face_from_gallery('0');"><ons-icon icon="ion-images"></ons-icon> &nbsp;&nbsp;Gallery</button> 
		<button class="button button--quiet" onclick="upload_face_from_camera('0');" style="float:right;"><ons-icon icon="ion-ios-camera"></ons-icon>&nbsp;&nbsp;Camera</button>
	</div>
</ons-page>




