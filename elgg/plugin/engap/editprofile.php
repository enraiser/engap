<ons-page id='more'  style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
        <div class="center">Edit Profile</div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
        </div>
    </ons-toolbar>
            
            <form name="elggform" role="form" >
                <div class="row">
                    <div class="elgg-form col-lg-4" >
                        <label for="input1">Name</label>
                        <input type="text" name="name" class="form-control" id="input1" ng-model="profile.name" >
                            </div>
                    <div class="elgg-form  col-lg-4" >
                        <label for="input2">Email Address</label>
                        <input type="email" name="contact_email" class="form-control" id="input2" ng-model="profile.email">
                        <small class="errorMessage" data-ng-show="profile.email.$invalid"> Invalid Email.</small>
                            </div>
                    <div class="elgg-form col-lg-4" >
                        <label for="input3">Phone Number</label>
                        <input type="phone" name="phone" class="form-control" id="input3" ng-model="profile.phone">
                            </div>
                    <div class="clearfix"></div>
                    <div class="elgg-form col-lg-12">
                            <button type="submit" class="btn btn-primary" ng-click="submit_form('profile',profile)" data-ng-disabled="profileForm.$invalid">Submit</button>
                            </div>
                </div>
            </form>
</ons-page>