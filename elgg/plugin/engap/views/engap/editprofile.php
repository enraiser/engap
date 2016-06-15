<ons-page id='more'  style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
        <div class="center elipsis">Edit Profile</div>
        <div class="right">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
        </div>
    </ons-toolbar>
            
            <center>
			<br><form name="elggform" role="form" style="width:90%;">
                <div class="row">
                    <div class="elgg-form col-lg-4" >
                        <input type="text" name="name" class="form-control text-input text-input--underbar" placeholder="Name" id="input1" ng-model="profile.name" >
                    </div>
                    <div class="elgg-form  col-lg-4" >
                        <input type="email" name="contact_email" class="form-control text-input text-input--underbar" placeholder="Email Address" id="input2" ng-model="profile.email">
                        <small class="errorMessage" data-ng-show="profile.email.$invalid"> Invalid Email.</small>
					</div>
                    <div class="elgg-form col-lg-4" >
                        <input type="phone" name="phone" class="form-control text-input text-input--underbar" placeholder="Phone Number" id="input3" ng-model="profile.phone">
					</div>
                    <div class="elgg-form col-lg-4" >
                        <input type="city" name="city" class="form-control text-input text-input--underbar" placeholder="City" id="input4" ng-model="profile.city">
					</div>
                    <div class="clearfix"></div>
                    <!--<div class="elgg-form col-lg-12">
                            <button type="submit" class="btn btn-primary" ng-click="submit_form('profile',profile)" data-ng-disabled="profileForm.$invalid">Submit</button>
					</div>-->
					<button type="submit" class="button button--large" ng-click="submit_form('profile',profile)" data-ng-disabled="profileForm.$invalid">Submit</button>
                </div>
            </form>
			</center>
</ons-page>