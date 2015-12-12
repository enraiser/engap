<?php
            header('Access-Control-Allow-Origin: *');
     header('Cache-Control: max-age=2592000');
?>
			<ons-page id='portfolio-page'  style="background-color: #f9f9f9;" >
				<ons-toolbar>
					<div class="center">Portfolio</div>
					<div class="right" style="margin-right:15px;">
						<ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
						<ons-icon icon="ion-navicon-round" onclick="alert('123')"></ons-icon>
					</div>
				</ons-toolbar>
				<posts></posts>
			</ons-page>

