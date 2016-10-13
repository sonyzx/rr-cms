<!-- Begin page heading -->
<h1 class="page-heading"><?php echo $tittle;?></h1>
<!-- End page heading -->										
    <div class="the-box">
          <div class="row">
                    <div class="col-lg-12">
                        <div class="portlet portlet-default">
                            <div class="portlet-body">                               
                                <div id="userTabContent" class="tab-content">                                    
                                    <div class="tab-pane fade in active" id="profile-settings">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <ul id="userSettings" class="nav nav-pills nav-stacked">
                                                    <li class="active"><a href="#basicInformation" data-toggle="tab"><i class="fa fa-user fa-fw"></i> <?php echo $this->lang->line('tittle_form1');?></a>
                                                    </li>
                                                    <li><a href="#profilePicture" data-toggle="tab"><i class="fa fa-picture-o fa-fw"></i> <?php echo $this->lang->line('profilepicture');?></a>
                                                    </li>
                                                    <li><a href="#changePassword" data-toggle="tab"><i class="fa fa-lock fa-fw"></i> <?php echo $this->lang->line('changepassword');?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-9">
                                                <div id="userSettingsContent" class="tab-content">
                                                    <div class="tab-pane fade in active" id="basicInformation">
                                                        <form role="form" name="profileinfo" id="profileinfo" method="post" action="<?php echo site_url('cms/profile/submit_information');?>">
                                                            <h4 class="page-header"><?php echo $this->lang->line('tittle_form1');?>:</h4>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('firstname');?></label>
                                                                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $firstname;?>" placeholder="Your first name" required="required">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('lastname');?></label>
                                                                <input type="text"  name="lastname" id="lastname" value="<?php echo $lastname;?>" class="form-control" placeholder="Your last Name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('phonenumber');?></label>
                                                                <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Your phone number" value="<?php echo $phonenumber;?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('address');?></label>
                                                                <input type="text" id="address" name="address" class="form-control" placeholder="Your address" value="<?php echo $address;?>">
                                                            </div>
                                                            <div class="form-inline">
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line('city');?></label>
                                                                    <input type="text" id="city" name="city" class="form-control" placeholder="Your city" value="<?php echo $city;?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line('state');?></label>
                                                                    <input type="text" id="state" name="state" placeholder="Your state" class="form-control" value="<?php echo $state;?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label><?php echo $this->lang->line('zip');?></label>
                                                                    <input type="text" id="zip" name="zip" placeholder="Zip code" maxlength="5" class="form-control" value="<?php echo $zip;?>">
                                                                </div>
                                                            </div>
                                                            <h4 class="page-header"><?php echo $this->lang->line('contactdetail');?>:</h4>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-envelope-o fa-fw"></i> <?php echo $this->lang->line('emailaddress');?></label>
                                                                <input type="email" id="email" name="email" class="form-control" required="required" value="<?php echo $email;?>" disabled>
                                                            </div>                                                           
                                                            <h4 class="page-header"><?php echo $this->lang->line('profileinfo');?>:</h4>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-info fa-fw"></i> <?php echo $this->lang->line('about');?></label>
                                                                <textarea placeholder="Description about you" class="form-control redactorwysg" id="about" name="about" rows="3"><?php echo $about;?></textarea>
                                                            </div>                                                            
                                                            <h4 class="page-header"><?php echo $this->lang->line('socialprofile');?>:</h4>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-facebook fa-fw"></i> <?php echo $this->lang->line('social_fb');?></label>
                                                                <input type="url" id="facebook" name="facebook" class="form-control" placeholder="Your facebook url" value="<?php echo $soc_fb;?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-linkedin fa-fw"></i> <?php echo $this->lang->line('social_link');?></label>
                                                                <input type="url" id="linkedin" name="linkedin" placeholder="Your linkedin url" class="form-control" value="<?php echo $soc_in;?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-google-plus fa-fw"></i> <?php echo $this->lang->line('google_link');?></label>
                                                                <input type="url" id="googleplus" name="googleplus" placeholder="Your google+ url" class="form-control" value="<?php echo $soc_plus;?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><i class="fa fa-twitter fa-fw"></i> <?php echo $this->lang->line('twitter_link');?></label>
                                                                <input type="url" name="twitter" id="twitter" class="form-control" placeholder="Your twitter url" value="<?php echo $soc_twit;?>">
                                                            </div>
                                                            <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('updateprofile');?></button>
                                                            <button id="reset-profileinfo" class="btn btn-green"><?php echo $this->lang->line('cancel');?></button>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="profilePicture">
                                                        <h3><?php echo $this->lang->line('cancelpicture');?>:</h3>
                                                         <?php echo $profile_pic;?>
                                                        <br>
                                                        <form enctype="multipart/form-data" method="post" name="pictureprofile" id="pictureprofile" role="form" action="<?php echo site_url('cms/profile/update_profile_pic');?>">
                                                            <div class="form-group">                                                                
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('choosepicture');?></label>
                                                                <input type="file" name="pictureprofile" id="pictureprofile">
                                                                <p class="help-block"><i class="fa fa-warning"></i> <?php echo $this->lang->line('rulepicture');?></p>
                                                                <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('updatepicture');?></button>
                                                                <button id="reset-profilepicture" class="btn btn-green"><?php echo $this->lang->line('cancel');?></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade in" id="changePassword">
                                                        <h3><?php echo $this->lang->line('changepassword');?>:</h3>
                                                        <form name="changepassword" method="post" id="changepassword" role="form" action="<?php echo site_url('cms/profile/changepassword');?>">
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('username');?></label>
                                                                <input type="text" name="username" id="username" class="form-control" placeholder="User name" value="<?php echo $userName;?>" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('oldpassword');?></label>
                                                                <input type="password" name="oldpassword" id="oldpassword" maxlength="30" class="form-control" placeholder="Old password" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('newpassword');?></label>
                                                                <input type="password" name="newpassword" id="newpassword" maxlength="30" placeholder="New password" class="form-control" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo $this->lang->line('retypepassword');?></label>
                                                                <input type="password" name="retypepassword" id="retypepassword" maxlength="30" placeholder="Re-Type password" class="form-control" value="">
                                                            </div>
                                                            <button type="submit" id="submitchangepassword" class="btn btn-danger"><?php echo $this->lang->line('updatepassword');?></button>
                                                            <button id="reset-updatepassword" class="btn btn-green"><?php echo $this->lang->line('cancel');?></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.portlet-body -->
                        </div>
                        <!-- /.portlet -->


                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
    </div><!-- /.the-box -->
</div><!-- /.container-fluid -->
										
				