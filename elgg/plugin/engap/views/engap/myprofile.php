<?php
    //$user = get_user_by_username($_GET['user_name']);
    //$channel = get_entity($channel_guid);
?>

<ons-page id='profile'  style="background-color: #f9f9f9;" modifier="shop-details">
        <ons-toolbar modifier="transparent">
		<div class="center elipsis"></div>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon></div>
        </ons-toolbar>

        <div class="card" style="background-image:url({{avatar_path}});">

        <div class="card-name" style='padding-top:230px;padding-left:5px;color:#DADADA;text-align:left;'>{{profile.name}}</div>

        </div>
		<ons-list style="border-top: none"><ons-list-item style="line-height: 1; padding: 0;">
          <ons-row class="action">

            <ons-col class="action-col">
              <div class="action-icon"><ons-icon icon="ion-edit" onclick='load_page("editprofile")'></ons-icon></div>
              <div class="action-label">Edit</div>
            </ons-col>

            <ons-col class="action-col">
              <div class="action-icon"><ons-icon icon="ion-ios-person" onclick="load_page('edit_avatar')"></ons-icon></div>
              <div class="action-label">Avatar</div>
            </ons-col>

          </ons-row>
        </ons-list-item></ons-list>


        <ons-list>
          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-map-marker"></ons-icon>
              {{profile.city}}
            </div>
          </ons-list-item>

          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-mobile"></ons-icon>
              {{profile.phone}}
            </div>
          </ons-list-item>

          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-envelope"></ons-icon>
              {{profile.email}}
            </div>
          </ons-list-item>
        </ons-list>

      </ons-page>

