<?php
            header('Access-Control-Allow-Origin: *');
     header('Cache-Control: max-age=2592000');
?>
		<ons-page id='more'  style="background-color: #f9f9f9;" >
			<ons-toolbar>
				<div class="center">More</div>
				<div class="right" style="margin-right:15px;">
					<ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
				</div>
			</ons-toolbar>
		<ons-list>
			<ons-list-header>Favorites</ons-list-header>
			<ons-list-item onclick='load_page("blog");'>Blogs</ons-list-item>
		</ons-list>
		<ons-list-header>Help and Setting</ons-list-header>
		<ons-list-item onclick='load_page("configur.html",true);'>Re-configure</ons-list-item>
		</ons-list>

		</ons-page>
