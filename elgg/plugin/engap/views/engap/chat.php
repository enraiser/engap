<ons-page id='chat' ng-controller="DetailController">
      <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
        <div class="center">{{chatuser}}</div>
        <div class="right">
        </div>
      </ons-toolbar>
      <div style='width:100%;z-index:999;position:fixed;background-color:#A51EC5;height:35px;padding-bottom:3px;'>
      <textarea id='chatbox' style='padding-left:10px;height:25px;font-size:18px;margin: 3px 0px 2px 1px;border-radius:5px 1px 5px 5px;' placeholder='Start Chating'></textarea>
      <ons-icon icon='ion-android-send' onclick='sendchatmessage();' size="25px" fixed-width="false" style="position: relative;top: -14px;"></ons-icon>
      </div>
        <div id='chathistory' style='overflow-y:scroll;width:100%;padding-left:10px;margin-top:35px;'></div>
</ons-page>