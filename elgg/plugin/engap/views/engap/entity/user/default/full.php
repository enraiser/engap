<?php
    $user_guid = $_GET['guid'];
    $user = get_entity($user_guid);
?>

<ons-page>
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
<div class="center"><?php echo $user->username;?></div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
			<ons-icon icon="ion-navicon-round" onclick="sidebar();"></ons-icon>
        </div>
    </ons-toolbar>
<div >
<img src="<?php echo $user->getIconURL(); ?>" width='100px' alt='entry photo' /><br>
<?php echo "Name      : ".$user->name; ?><br>
<?php echo "E-mail    : ".$user->email; ?><br>

<br><timeline  subjectguid='<?php echo $user_guid;?>'  pagination='true'></timeline>
	<sidebar>
		<ons-list>
			<ons-list-header>ELGG Sidebar</ons-list-header>
			<ons-list-item onclick='load_page("family");'>My Family</ons-list-item>
		</ons-list>
	</sidebar>
</ons-page>