<?php
    $user_guid = $_GET['guid'];
    $user = get_entity($user_guid);
?>

<ons-page   style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
<div class="center"><?php echo $user->username;?></div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
        </div>
    </ons-toolbar>
<div >
<img src="<?php echo $user->getIconURL(); ?>" width='100px' alt='entry photo' /><br>
<?php echo "Name      : ".$user->name; ?><br>
<?php echo "E-mail    : ".$user->email; ?><br>

<timeline  subjectguid='<?php echo $user_guid;?>'  ></timeline>
</ons-page>