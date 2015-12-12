<?php
            header('Access-Control-Allow-Origin: *');
     header('Cache-Control: max-age=2592000');
?>
		<ons-tabbar>
			<ons-tabbar-item page="home" label="Home" icon="ion-home" active="true"></ons-tabbar-item>
		<ons-tabbar-item page='pages' label="Pages" icon="ion-clipboard"></ons-tabbar-item>
		<ons-tabbar-item page='bag' label="Portfolio" icon="ion-bag"></ons-tabbar-item>
		  <ons-tabbar-item page='more' label="More" icon="ion-android-more"></ons-tabbar-item>
		</ons-tabbar>

		<ons-template id="home">
			<ons-page id='home-page'  style="background-color: #f9f9f9;" >
				<ons-toolbar>
					<div class="center" >{{site_name}}</div>
					<div class="right" style="margin-right:15px;">
						<ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
						<ons-icon icon="ion-navicon-round" onclick="alert('123')"></ons-icon>
					</div>
				</ons-toolbar>
                               <postlist taxonomy='category' tagid='5' ></postlist>
			</ons-page>
		</ons-template>

