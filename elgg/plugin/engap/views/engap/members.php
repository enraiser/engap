<ons-page id='members'  style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="center">Members</div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
            <ons-icon icon="ion-navicon-round" onclick="sidebar();"></ons-icon>
        </div>
    </ons-toolbar>

  <elggentitylist  type='user'  subtype='default'  limit='11'></elggentitylist>
<sidebar>
<ons-list>
<ons-list-header>ELGG Sidebar</ons-list-header>
<ons-list-item onclick=''>My Friends</ons-list-item>
</ons-list>
</sidebar>
</ons-page>




