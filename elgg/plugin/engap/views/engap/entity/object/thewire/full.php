<?php
    $newsfeed_guid = $_GET['guid'];
    $newsfeed = get_entity($newsfeed_guid);
?>

<ons-page   style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon></div>
		<div class="center">Full View</div>
    </ons-toolbar>
<div >
<br>
<?php echo "Description    : ".$newsfeed->description; ?><br>

</ons-page>