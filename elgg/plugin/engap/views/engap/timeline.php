<ons-page id='timeline'  style="background-color: #f9f9f9;" >
    <ons-toolbar>
<div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
        <div class="center">My Timeline</div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
        </div>
    </ons-toolbar>

<timeline limit='9'></timeline>

</ons-page>




