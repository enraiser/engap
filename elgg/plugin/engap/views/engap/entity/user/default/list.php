<ons-list-item style='border-bottom:1px solid #DADADA;overflow:auto;line-height:25px;'>
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
	<div style='width:10%;float:right;'>
    <div style='font-size:35px;'><ons-icon icon="ion-chatboxes" ng-click="chatwith()" style='font-size:35px;margin-top:0px;color:rgba(0, 114, 255, 0.59);'></ons-icon></div>
    </div>
</ons-list-item>