<script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script src="<?php echo site_url('assets/js/gmaps/jquery.geocomplete.js');?>"></script>
<h1 class="page-heading"><?php echo $module;?></h1>
<!-- Basic Tabs Example -->
    <div class="row">
        <div class="col-lg-12">
               <div class="the-box">    
                   <form role="form" id="form-hotels" name="form-hotels" enctype="multipart/form-data" method="post" action="<?php echo site_url('cms/hotel/pushdata/');?>">
                      <input type="hidden" name="action" value="<?php echo $action;?>">
                      <input type="hidden" name="id" id="id" value="<?php echo $id;?>">    
                      <div class="form-group">
                          <label><?php echo $this->lang->line('hotelname');?></label>
                          <input type="text" class="form-control" id='hotel_name' name="hotel_name" value="<?php echo $hotelname;?>" maxlength="100" required="required">                            
                      </div>
                      <div class="form-group">
                          <label><?php echo $this->lang->line('slug');?></label>
                          <input type="text" class="form-control" maxlength="200" id='slug' name="slug" value="<?php echo $slug;?>" required="required">                            
                      </div>  
                      <div class="form-group">
                            <label><?php echo $this->lang->line('shortdesc');?></label>
                            <textarea name="shortdesc" id='shortdesc' class="form-control redactorwysg" required="required"><?php echo $shortdesc;?></textarea>
                      </div>
                      <div class="form-group">
                            <label><?php echo $this->lang->line('maindesc');?></label>
                            <textarea name="maindesc" id='maindesc' class="form-control redactorwysg" required="required"><?php echo $main_description;?></textarea>
                      </div>  
                      <div class="form-group">
                          <label><?php echo $this->lang->line('stars');?></label>
                          <input id="star" name="star" value="<?php echo $stars;?>" type="number" class="rating" min=0 max=8 step=1 data-size="xs" data-stars="8">
                      </div>   
                     <div class="row">
                            <div class="col-sm-4">
                                  <label><?php echo $this->lang->line('owner');?></label>
                                  <select data-prefill="2" class="form-control" name="ownerid" id="ownerid" required="required">
                                  <option value="1">A</option>                            
                                  <option value="2">B</option>
                                  <option value="3">C</option>
                              </select>                           
                            </div>
                            <div class="col-sm-4">
                                <label><?php echo $this->lang->line('businessname');?></label>
                                <input type="text" class="form-control" id='businesname' maxlength="100" name="businesname" value="<?php echo $business_name;?>" required="required">                            
                            </div> 
                            <div class="col-sm-4">
                                <label><?php echo $this->lang->line('businessnumber');?></label>
                                <input type="text" class="form-control" id='businesnumber' name="businesnumber" maxlength="100" value="<?php echo $business_number;?>" required="required">                            
                            </div>   
                      </div>   
                      <h4 class="page-header"><?php echo $this->lang->line('address');?> :</h4>                        
                      <div class="row">
                            <div class="col-sm-6">                                                                           
                                 <div class="map_canvas"></div>                                   
                            </div>    
                      </div>
                      <div class="row">
                          <div class="col-sm-4">
                              <input id="geocomplete" type="text" class="form-control" placeholder="Type in an address" value="111 Broadway, New York, NY" />
                          </div>
                          <div class="col-sm-2">
                              <button class="btn btn-success" id="find" type="button"><?php echo $this->lang->line('find');?></button>
                              <a id="reset" class="btn btn-danger" href="#" style="display:none;"><?php echo $this->lang->line('resetmarker');?></a>
                          </div>                              
                      </div>    
                      
                      <div class="form-group">
                          <label><?php echo $this->lang->line('street1');?></label>
                          <input type="text" class="form-control" id='street1' name="street1" maxlength="100" value="<?php echo $street;?>" required="required">                            
                      </div> 
                      <div class="form-group">
                          <label><?php echo $this->lang->line('street2');?></label>
                          <input type="text" class="form-control" id='street2' name="street2" maxlength="100" value="<?php echo $street2;?>">                            
                      </div>     
                      <div class="row geo-details">
                              <div class="col-sm-4">
                                    <label><?php echo $this->lang->line('longitude');?></label>
                                    <input type="text" class="form-control" id="longitude" data-geo="lng" name="longitude" maxlength="50" value="<?php echo $longitude;?>" readonly="true">                         
                               </div>    
                               <div class="col-sm-4">
                                   <label><?php echo $this->lang->line('latitude');?></label>
                                   <input type="text" class="form-control" id="latitude" data-geo="lat" name="latitude" maxlength="50" value="<?php echo $latitude;?>" readonly="true">                         
                               </div>   
                               <div class="col-sm-4">
                                   <label><?php echo $this->lang->line('country');?></label>
                                   <input type="text" class="form-control" data-geo="country" name="country" id="country"  maxlength="100" required="required" value="<?php echo $country;?>">                            
                               </div>   
                                <div class="col-sm-4">
                                   <label><?php echo $this->lang->line('state');?></label>
                                   <input type="text" class="form-control" data-geo="administrative_area_level_1" id='state' name="state" maxlength="50" required="required" value="<?php echo $state;?>">                            
                               </div>    
                               <div class="col-sm-4">
                                   <label><?php echo $this->lang->line('poscode');?></label>
                                   <input type="text" class="form-control" id='postcode' name="postcode" maxlength="6" required="required" value="<?php echo $postcode;?>">                            
                               </div>                                                        
                      </div>    
     
                      <h4 class="page-header"><?php echo $this->lang->line('contactinfo');?> :</h4>  
                       <div class="form-group">
                          <label><?php echo $this->lang->line('phone1');?></label>
                          <input type="text" class="form-control" id='phone1' name="phone1" maxlength="20" required="required" value="<?php echo $phone1;?>">                            
                      </div> 
                        <div class="form-group">
                          <label><?php echo $this->lang->line('phone2');?></label>
                          <input type="text" class="form-control" id='phone2' name="phone2" maxlength="20" value="<?php echo $phone2;?>">                            
                      </div>  
                       <div class="form-group">
                          <label><?php echo $this->lang->line('email1');?></label>
                          <input type="text" class="form-control" id='email1' name="email1" maxlength="50" required="required" value="<?php echo $email1;?>">                            
                      </div> 
                      <div class="form-group">
                          <label><?php echo $this->lang->line('email2');?></label>
                          <input type="text" class="form-control" id='email2' name="email2" maxlength="50" value="<?php echo $email2;?>">                            
                      </div>    
                      <div class="form-group">
                          <label><?php echo $this->lang->line('fax');?></label>
                          <input type="text" class="form-control" id='fax' name="fax" maxlength="50" value="<?php echo $fax;?>">                            
                      </div> 
                      <div class="form-group">
                          <label><?php echo $this->lang->line('tra');?></label>
                          <input type="text" class="form-control" id='tra' name="tra" maxlength="4" value="<?php echo $total_rooms_active;?>" required="required">                            
                      </div> 
                      <div class="form-group">
                            <label><?php echo $this->lang->line('logo');?></label>
                            <input type="file" name='logo' id="logo">
                            <?php if(!empty($logo)){?>
                             <br>
                             <img id="logoimg" src="<?php echo $logo;?>" class="img-responsive thumb-article">
                            <?php } ?>
                      </div>
                      <div class="form-group">
                            <label><?php echo $this->lang->line('fi');?></label>
                             <input type="file" name='fimages' id="fimages"> 
                             <?php if(!empty($feature_image)){ ?>
                             <br>
                             <img id="featureimages" src="<?php echo $feature_image;?>" class="img-responsive thumb-article" >
                             <?php } ?>
                      </div>   

                       <div class="form-group">
                            <label><?php echo $this->lang->line('roomtotal');?></label>
                            <input type="text" class="form-control" id='roomtotal' name="roomtotal" value="<?php echo $rooms_total;?>" maxlength="4" required="required">                         
                      </div> 
                      <div class="form-group">
                            <label><?php echo $this->lang->line('timezone');?></label>
                            <input type="text" class="form-control" id='timezone' name="timezone" value="<?php echo $timezone;?>" maxlength="50" required="required">                         
                      </div>
                       <div class="row">
                          <div class="col-sm-6">
                              <label><?php echo $this->lang->line('deposit');?></label>
                              <input type="text" class="form-control" id='deposit' name="deposit" value="<?php echo $deposit;?>" maxlength="20" required="required">                         
                         </div>  
                         <div class="col-sm-6">
                              <label><?php echo $this->lang->line('currency');?></label>
                              <select data-prefill="2" class="form-control" name="currency" id="currency" required="required">
                              <option value="1">USD</option>                            
                              <option value="2">WON</option>
                              <option value="3">YEN</option>
                          </select>                           
                        </div>  
                      </div>   
                      <br />
                      <div class="form-group">
                        <button type="submit" name="btnSubmit" class="btn btn-danger"> <?php echo $this->lang->line('save');?></button>
                        <button type="reset" id="reset-hotel" class="btn btn-default">Cancel</button>
                      </div>
                    </form>
               </div>
        </div>
    </div>          
    <script type="text/javascript">
        "use strict";        
        $("#hotel_name").keyup(function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
            $("#slug").val(Text);        
        });  
         
        $(function(){
        $("#geocomplete").geocomplete({
          map: ".map_canvas",
          details: ".geo-details",
          detailsAttribute: "data-geo",
          markerOptions: {
            draggable: true
          }
        });
        
        $("#geocomplete").bind("geocode:dragged", function(event, latLng){
          $("input[name=longitude]").val(latLng.lat());
          $("input[name=latitude]").val(latLng.lng());
          $("#reset").show();
        });
        
        
        $("#reset").click(function(){
          $("#geocomplete").geocomplete("resetMarker");
          $("input[name=longitude]").val('');
          $("input[name=latitude]").val('');
          $("#reset").hide();
          return false;
        });
        
        $("#find").click(function(){
          $("#geocomplete").trigger("geocode");
        }).click();
      }); 
    </script>
