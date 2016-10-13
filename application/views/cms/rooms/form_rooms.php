<h1 class="page-heading"><?php echo $module;?></h1>
<!-- Basic Tabs Example -->
    <div class="row">
        <div class="col-lg-12">
               <div class="the-box">   
                   <form role="form" id="form-rooms" name="form-rooms" enctype="multipart/form-data" method="post" action="<?php echo site_url('cms/rooms/pushdata/');?>">
                      <input type="hidden" name="action" value="<?php echo $action;?>">
                      <input type="hidden" name="id" id="id" value="<?php echo $id;?>">  
                      <div class="form-group">
                          <label><?php echo $this->lang->line('roomnames');?></label>
                          <input type="text" class="form-control" id='roomnames' name="roomnames" value="<?php echo $roomname;?>" maxlength="100" required="required">                            
                      </div>
                      <div class="form-group">
                          <label><?php echo $this->lang->line('hotelname');?></label>                          
                          <select name="hotelid" id="hotelid" class="form-control">      
                              <?php echo $cmbhotel;?>
                          </select>    
                      </div>  
                      <div class="form-group">
                            <label><?php echo $this->lang->line('shortdesc');?></label>
                            <textarea name="short_description" id='short_description' class="form-control redactorwysg" required="required"><?php echo $short_description;?></textarea>
                      </div>
                      <div class="form-group">
                            <label><?php echo $this->lang->line('maindesc');?></label>
                            <textarea name="main_description" id='main_description' class="form-control redactorwysg" required="required"><?php echo $main_description;?></textarea>
                      </div>  
                      <div class="form-group">
                        <label><?php echo $this->lang->line('active');?></label>   
                        <br>                        
                        <input type="checkbox" class="form-control" name="enabled" <?php echo (empty($active)||($active==1))? "checked" : ""; ?>>
                      </div> 
                      
                      <div class="row">
                            <div class="col-sm-2">
                                <label><?php echo $this->lang->line('colours');?></label>
                                <input type="text" class="form-control" id='colours' name="colours" value="<?php echo $colour;?>" maxlength="50" required="required" >                            
                            </div>
                            <div class="col-sm-2">
                                <label><?php echo $this->lang->line('hourly_rate');?></label>
                                <div class="input-group">  
                                    <input type="text" class="form-control" id='hourly_rate' name="hourly_rate" value="<?php echo $hourly_rate;?>" maxlength="50" required="required" >                            
                                    <span class="input-group-addon">.00</span>
                                </div>    
                            </div>
                            <div class="col-sm-2">
                                <label><?php echo $this->lang->line('private_room');?></label>
                                <input type="text" class="form-control" id='private_room' name="private_room" value="<?php echo $private_room;?>" maxlength="50" required="required" >                            
                            </div>
                            <div class="col-sm-2">
                                <label><?php echo $this->lang->line('widget_minimum_stay');?></label>
                                <input type="text" class="form-control" id='widget_minimum_stay' name="widget_minimum_stay" value="<?php echo $widget_minimum_stay;?>" maxlength="50" required="required" >                            
                            </div>
                            <div class="col-sm-2">
                                <label><?php echo $this->lang->line('gender');?></label>
                                <select class="form-control" name="gender" id="gender" required="required">
                                    <option value="all">All</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>                                    
                                </select>
                            </div>
                             <div class="col-sm-2">
                                <label><?php echo $this->lang->line('occupancy');?></label>
                                <input type="text" class="form-control" id='occupancy' name="occupancy" value="<?php echo $occupancy;?>" maxlength="5" >                            
                            </div>
                          <!--occupancy-->
                      </div>   
                      <h4 class="page-header"><?php echo $this->lang->line('price');?>:</h4>
                       <div class="row">
                            <div class="col-sm-1">
                                <label><?php echo $this->lang->line('mon');?></label>                                                       
                                <input type="text" class="form-control" id="mon" name="mon" value="<?php echo $mon;?>" maxlength="5" required="required">   
                            </div>    
                            <div class="col-sm-1">
                                <label><?php echo $this->lang->line('tue');?></label>
                                <input type="text" class="form-control" id="tue" name="tue" value="<?php echo $tue;?>" maxlength="5" required="required">                            
                            </div>
                            <div class="col-sm-1">
                                <label><?php echo $this->lang->line('wed');?></label>
                                <input type="text" class="form-control" id="wed" name="wed" value="<?php echo $wed;?>" maxlength="5" required="required">                            
                            </div>
                            <div class="col-sm-1">
                                <label><?php echo $this->lang->line('thu');?></label>
                                <input type="text" class="form-control" id="thu" name="thu" value="<?php echo $thu;?>" maxlength="5" required="required">                            
                            </div>
                            <div class="col-sm-1">
                                <label><?php echo $this->lang->line('fri');?></label>
                                <input type="text" class="form-control" id="fri" name="fri" value="<?php echo $fri;?>" maxlength="5" required="required">                            
                            </div>
                            <div class="col-sm-1">
                                <label><?php echo $this->lang->line('sat');?></label>
                                <input type="text" class="form-control" id="sat" name="sat" value="<?php echo $sat;?>" maxlength="5" required="required">                            
                            </div>
                             <div class="col-sm-1">
                                <label><?php echo $this->lang->line('sun');?></label>
                                <input type="text" class="form-control" id="sun" name="sun" value="<?php echo $sun;?>" maxlength="5" required="required">                            
                            </div>
                      </div>  
                      <br/>
                      <div class="form-group">
                            <label><?php echo $this->lang->line('widget_footer');?></label>
                            <textarea name="widget_footer" id='widget_footer' class="form-control" required="required"><?php echo $widget_footer;?></textarea>
                      </div>
                      <div class="form-group">
                          <label><?php echo $this->lang->line('linkimage');?></label>
                          <?php if(!empty($image_url)){ ?>
                          <div class="row">
                                <div class="col-sm-2">
                                    <img class="thumb-images rooms_thumb" src="<?php echo $image_url;?>" >
                                </div>
                                <div class="col-sm-10">
                                    <input class="form-control" type="url" name="image_url" id="image_url" value="<?php echo $image_url;?>">
                                </div>
                         </div>    
                         <?php } else { ?>
                          <input class="form-control" type="url" name="image_url" id="image_url" value="<?php echo $image_url;?>">
                         <?php } ?> 
                            <br />    
                            <div class="btn-group">                           
                                 <button type="button" class="btn btn-default add-urllink">+ <?php echo $this->lang->line("addlink");?></button>                                                                                                                            
                            </div>
                      </div> 
                      <?php
                            echo $room_types_photos;
                            $tpl = view_urlImages(true);                                                        
                            echo $tpl;
                      ?>  
                      <br />
                      <div class="form-group">
                        <button type="submit" name="btnSubmit" class="btn btn-danger"> <?php echo $this->lang->line('save');?></button>
                        <button type="reset" id="reset-room" class="btn btn-default"><?php echo $this->lang->line('cancel');?></button>
                      </div>
                    </form>
               </div>
        </div>
    </div>          
    <script type="text/javascript">
        "use strict";        
        $("[name='enabled']").bootstrapSwitch();
    </script>
