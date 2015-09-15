<?php
    $group_guid = $_GET['guid'];
    $group = get_entity($group_guid);
    
?>

<ons-page   style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
<div class="center"><?php echo $group->name;?></div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
        </div>
    </ons-toolbar>
</div >
<img src="<?php echo $group->getIconURL(); ?>" width='100px'  />

<p>Owner:</p>
<elggentity  guid='<?php echo  $group->owner_guid;?>'></elggentity>


</ons-page>