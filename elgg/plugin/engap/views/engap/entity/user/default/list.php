<div style='border-bottom:1px solid #DADADA;overflow:auto;'>
	<div ng-click='loadentity()' style='border-radius:3px;width:50px;display:inline;float:left;'>
		<entityicon style='border-radius:5px;' width='48px' alt='user icon' />
	</div>
	<div ng-click='loadentity()' style='float:left;width:72%;'>
		<div class='entry-title' style='font-size: 12px;'>
			{{content.title}}
		</div>
		<div class='entry-copy'>
			{{content.description}}			
		</div>
	</div>
	<?php 
	global $chat;
	if($chat == true){ ?>
	<div style='width:10%;float:right;'>
		<div><ons-icon icon="ion-chatbox" ng-click="chatwith()" ></ons-icon></div>
	</div>
	<?php }?>
</div>