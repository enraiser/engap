<div style='border-bottom:1px solid #DADADA;overflow:auto;' ng-click='loadentity()'>
	<img ng-src='img/1.png' style='float:right;margin-top: 20px;position: absolute;right: 16px;' width='10px'/>
	<div style='border-radius:3px;width:50px;display:inline;'>
		<entityicon style='border-radius:5px;' width='15%' alt='group icon' />
	</div>
	<div style='float:right;width:82%;'>
		<div class='entry-title' style='font-size: 12px;'>
			{{content.title}}
		</div>
		<div class='entry-copy'>
			{{content.description}}
		</div>
	</div>
</div>