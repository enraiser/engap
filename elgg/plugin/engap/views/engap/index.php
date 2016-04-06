<?php
    $site_url = elgg_get_site_url();
?>
<ons-page id='index'  style="background-color: #f9f9f9;" >
<ons-tabbar>
	<ons-tabbar-item page="home" label="Home" icon="ion-home" active="true"></ons-tabbar-item>
  <ons-tabbar-item page='groups' label="Groups" icon="ion-ios-people"></ons-tabbar-item>
  <ons-tabbar-item page='members' label="Members" icon="ion-person"></ons-tabbar-item>
  <ons-tabbar-item page='more' label="More" icon="ion-android-more-vertical"></ons-tabbar-item>
</ons-tabbar>

<ons-template id="home">
  <ons-page id='home-page'  style="background-color: #f9f9f9;" >
    <ons-toolbar>
        
		<div class="center" >{{site_name}}</div>
        <div class="right">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
            <ons-icon icon="ion-navicon-round" onclick="sidebar();"></ons-icon>
        </div>
    </ons-toolbar>
	<thewire></thewire>
   <newsfeed limit='11'></newsfeed>
   <sidebar>
        <ons-list>
            <ons-list-header>ELGG Sidebar</ons-list-header>
            <ons-list-item onclick='load_page("timeline");'>My Timeline</ons-list-item>
            <ons-list-item onclick='load_page("editprofile");'>Edit My Profile</ons-list-item>
        </ons-list>
   </sidebar>
</ons-page>

</ons-template>
</ons-page>
