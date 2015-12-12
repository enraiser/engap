<?php
            header('Access-Control-Allow-Origin: *');
     header('Cache-Control: max-age=2592000');
?>
		<ons-page id='blog'  style="background-color: #f9f9f9;" >
			<ons-toolbar>
				<div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
				<div class="center">Blog</div>
				<div class="right" style="margin-right:15px;">
					<ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
				</div>
			</ons-toolbar>
			
		</ons-page>

