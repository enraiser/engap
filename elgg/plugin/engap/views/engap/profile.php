<?php
    $user = get_entity($_GET['guid']);
    //$channel = get_entity($channel_guid);
?>

<ons-page id='profile'  style="background-color: #f9f9f9;" modifier="shop-details">
        <ons-toolbar modifier="transparent">
		<div class="center elipsis"></div>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon></div>
        </ons-toolbar>

        <div class="card" style="background-image:url(<?php echo $user->getIconURL('master'); ?>);">

        <div class="card-name" style='padding-top:230px;padding-left:5px;color:#DADADA;text-align:left;'><?php echo ucwords($user->name);?></div>

        </div>
<!--		<ons-list style="border-top: none"><ons-list-item style="line-height: 1; padding: 0;">
          <ons-row class="action">

            <ons-col class="action-col">
              <div class="action-icon"><ons-icon icon="ion-edit" onclick='load_page("myphotos?user_name=<?php echo $user->username; ?>")'></ons-icon></div>
              <div class="action-label">Myphotos</div>
            </ons-col>
          </ons-row>
        </ons-list-item></ons-list>-->

        <ons-list>
          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-map-marker"></ons-icon>
              2-15-13 Hongo Bunkyo Tokyo
            </div>
          </ons-list-item>

          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-mobile"></ons-icon>
              (111) 123-4567
            </div>
          </ons-list-item>

          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-envelope"></ons-icon>
              <?php echo $user->email; ?>
            </div>
          </ons-list-item>

          <ons-list-item>
            <div class="prop-desc">
              <ons-icon icon="fa-clock-o"></ons-icon>
              Make a Reservation
            </div>
          </ons-list-item>
        </ons-list>
		<timeline  subjectguid='<?php echo $user->guid;?>'  ></timeline>
      </ons-page>

