<!-- Begin page heading -->
<h1 class="page-heading"><?php echo $module;?></h1>
<div class="row">
    <div class="col-lg-12">            
            <div class="portlet portlet-default">
                <div class="portlet-body">
                                <ul id="userTab" class="nav nav-tabs">
                                    <li class="active"><a href="#block-settings" data-toggle="tab"><?php echo $this->lang->line('blocks');?></a></li>
                                    <li><a href="#global" data-toggle="tab"><?php echo $this->lang->line('globals');?></a></li>                                    
                                </ul>
                                <div id="userTabContent" class="tab-content">                                   
                                    <div class="tab-pane fade in active" id="block-settings">
                                        <div class="row">
                                            <div class="col-sm-3">                                                
                                                <?php 
                                                 $maxblock=count($checkblock);
                                                 $disabled = ($maxblock==4)? '' : '';
                                                 echo $myblock;
                                                ?>
                                                
                                                <form id="frm-block" method="post" role="form" >
                                                    <div class="btn-group">                           
                                                        <button type="button" class="btn btn-default <?php echo $disabled;?>">+ <?php echo $this->lang->line('addblock');?></button>
                                                        <button type="button" class="btn btn-default dropdown-toggle <?php echo $disabled;?>" data-toggle="dropdown">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <?php echo $menu;?>
                                                    </div>
                                                </form>    
                                                <br />  
                                                
                                            </div>
                                            <div class="col-sm-9">
                                                <div id="userSettingsContent" class="tab-content">
                                                    <?php 
                                                    if ($maxblock==0) {
                                                       echo '<div class="tab-pane fade in active"><h4>'.$this->lang->line('createfirstblock').'</h4></div>';
                                                    } else {
                                                       foreach($checkblock as $blocktype=>$key):                                                           
                                                          if($key['blockID']=="1"){
                                                    ?>
                                                    <div class="tab-pane fade in active" id="article">
                                                        <div class="portlet portlet-default">
                                                            <div class="portlet-heading">
                                                                <div class="portlet-title">
                                                                    <h4><?php echo $this->lang->line('tittle_prof');?></h4>
                                                                </div>
                                                                <div class="portlet-widgets">                                                                                                  
                                                                    <a href="#" title="Remove this block" onclick="removeblock('<?php echo encode_url(1);?>')"><i class="glyphicon glyphicon-remove"></i></a>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div id="redPortlet3" class="panel-collapse collapse in">
                                                                <div class="portlet-body">
                                                                     <form enctype="multipart/form-data" id="onepostarticle"  role="form" method="post" action="<?php echo site_url("cms/entries/op_article_submit");?>" >                                                                                                                                               
                                                                     <div class="form-group">
                                                                         <label><?php echo $this->lang->line('title');?></label>
                                                                         <input type="text" class="form-control" id="title_name" maxlength="200" name="title_name" value="<?php echo $title_post;?>" >                            
                                                                     </div>                                                                                                                           
                                                                     <div class="form-group">
                                                                           <label><?php echo $this->lang->line('body');?></label>                          
                                                                           <textarea class="form-control redactorwysg" id="shortdesc" name="shortdesc" ><?php echo $content_post;?></textarea>
                                                                     </div>
                                                                      
                                                                     <div class="form-group">
                                                                            <label><?php echo $this->lang->line('image');?></label>
                                                                            <input type="file" name="picture" id="picture" /><br />                                                                                      
                                                                            <?php echo $picture; ?>
                                                                     </div>     
                                                                         
                                                                      <div class="form-group">  
                                                                        <label><?php echo $this->lang->line('position');?></label><br>
                                                                          <input type="radio" name="position_img" value="left" checked="checked"> <i class="glyphicon glyphicon-align-left" title="Left"></i>&nbsp;
                                                                          <input type="radio" name="position_img" value="right"> <i class="glyphicon glyphicon-align-right" title="Right"></i>
                                                                          <input type="radio" name="position_img" value="above"> <i class="glyphicon glyphicon-align-center" title="Above body text"></i>&nbsp;                                                                                                        				  
                                                                          <input type="radio" name="position_img" value="background"> <i class="glyphicon glyphicon-align-justify" title="Background Image"></i>                              
                                                                     </div>    
                                                                         
                                                                     <div class="btn-group">
                                                                         <button type="submit" id="submitarticle" class="btn btn-danger"><?php echo $this->lang->line('save');?></button> &nbsp;                                                                         
                                                                     </div>                                                             
                                                                    </form>
                                                                </div>                                                                                                                                
                                                            </div>
                                                       </div>                                                                     
                                                    </div>
                                                    <?php
                                                        }
                                                         if($key['blockID']=="2"){
                                                    ?>
                                                    <div class="tab-pane fade" id="imagegallery">
                                                       <div class="portlet portlet-default">
                                                            <div class="portlet-heading">
                                                                <div class="portlet-title">
                                                                    <h4><?php echo $this->lang->line('imagegallery');?></h4>
                                                                </div>
                                                                <div class="portlet-widgets">                                                                                                  
                                                                    <a href="#" title="Remove this block" onclick="removeblock('<?php echo encode_url(2);?>')"><i class="glyphicon glyphicon-remove"></i></a>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div id="redPortlet3" class="panel-collapse collapse in">
                                                                <div class="portlet-body">
                                                                    <form enctype="multipart/form-data" id="form-gallery"  role="form" method="post" action="<?php echo site_url("cms/assets/upload");?>" >                                                                                                                                               
                                                                        <div id="extraupload"><?php echo $this->lang->line('upload');?></div>
                                                                        <button type="button" id="extrabutton" class="btn btn-success"><i class="fa fa-cloud-upload"></i> <?php echo $this->lang->line('startupload');?></button>
                                                                    </form> 
                                                                    <br/>
                                                                    <div class="table-responsive">
                                                                        <table id="siteassets" class="table table-striped table-bordered table-hover table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><?php echo $this->lang->line('images');?></th>
                                                                                    <th><?php echo $this->lang->line('caption');?></th>
                                                                                    <th><?php echo $this->lang->line('updates');?></th>
                                                                                    <th><?php echo $this->lang->line('action');?></th>
                                                                                </tr>
                                                                            </thead>                                        
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                       </div> 
                                                    </div>
                                                    <?php
                                                         }
                                                        if($key['blockID']=="3"){
                                                    ?>
                                                    <div class="tab-pane fade" id="roomlist">
                                                        <div class="portlet portlet-default">
                                                            <div class="portlet-heading">
                                                                <div class="portlet-title">
                                                                    <h4><?php echo $this->lang->line('roomlist');?></h4>
                                                                </div>
                                                                <div class="portlet-widgets">                                                                                                  
                                                                    <a href="#" title="Remove this block" onclick="removeblock('<?php echo encode_url(3);?>')"><i class="glyphicon glyphicon-remove"></i></a>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div id="redPortlet3" class="panel-collapse collapse in">
                                                                <div class="portlet-body">
                                                                     
                                                                </div>
                                                            </div>
                                                       </div> 
                                                    </div>
                                                    <?php
                                                         }
                                                        if($key['blockID']=="4"){
                                                    ?>
                                                    <div class="tab-pane fade" id="hotelammenities">
                                                         <div class="portlet portlet-default">
                                                            <div class="portlet-heading">
                                                                <div class="portlet-title">
                                                                    <h4><?php echo $this->lang->line('hotelammenities');?></h4>
                                                                </div>
                                                                <div class="portlet-widgets">                                                                                                  
                                                                    <a href="#" title="Remove this block" onclick="removeblock('<?php echo encode_url(4);?>')"><i class="glyphicon glyphicon-remove"></i></a>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div id="redPortlet3" class="panel-collapse collapse in">
                                                                <div class="portlet-body">
                                                                    
                                                                </div>
                                                            </div>
                                                       </div>                                                        
                                                    </div>
                                                    <?php
                                                        }
                                                     
                                                      if($key['blockID']=="5"){
                                                    ?>
                                                    <!-- MAP SECTION -->
                                                    <div class="tab-pane fade in" id="map">
                                                        <div class="portlet portlet-default">
                                                            <div class="portlet-heading">
                                                                <div class="portlet-title">
                                                                    <h4><?php echo $this->lang->line('map');?></h4>
                                                                </div>
                                                                <div class="portlet-widgets">                                                                                                  
                                                                    <a href="#" title="Remove this block" onclick="removeblock('<?php echo encode_url(5);?>')"><i class="glyphicon glyphicon-remove"></i></a>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div id="redPortlet3" class="panel-collapse collapse in">
                                                                <div class="portlet-body">
                                                                     <form id="frmmap" role="form" method="post" action="<?php echo site_url("cms/globals/map");?>" >                                                                                                                                                                                                                    
                                                                      <script src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
                                                                      <script src="<?php echo site_url('assets/js/gmaps/jquery.geocomplete.js');?>"></script>                                                                                                                                                                                                                                                                                                   
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
                                                                          </div> 
                                                                          <div class="col-sm-2">                                                                              
                                                                              <a id="reset" class="btn btn-danger" href="#" style="display:none;"><?php echo $this->lang->line('resetmarker');?></a>
                                                                          </div>                             
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
                                                                      </div>                                                                              
                                                                     <div class="btn-group">
                                                                         <br />   
                                                                         <button type="submit" id="submitmap" class="btn btn-danger"><?php echo $this->lang->line('save');?></button> &nbsp;                                                                         
                                                                     </div>                                                             
                                                                    </form>                                                                     
                                                                     <script type="text/javascript">
                                                                        "use strict";                                                                                
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
                                                                    
                                                                </div>                                                                                                                                
                                                            </div>
                                                       </div>                                                                     
                                                    </div>
                                                    <!-- END MAP SECTION -->
                                                    <?php
                                                        }   
                                                        
                                                    endforeach;
                                                    } 
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="tab-pane fade" id="global">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form enctype="multipart/form-data" role="form" id="frm-footercontent" method="post" action="<?php echo site_url('cms/globals/footercontent');?>">                        
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('titlesite');?></label>
                                                        <input type="text" class="form-control" name="titlesite" id="titlesite" placeholder="Title your site" required="required" maxlength="50" value="<?php echo $titlesite;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('metadata');?></label>
                                                        <textarea class="form-control" name="metadata" id="metadata"><?php echo $metadata;?></textarea>
                                                    </div>  
                                                    <div class="form-group">                         
                                                        <label><?php echo $this->lang->line('introslidertext');?></label>
                                                        <input type="text" class="form-control" name="intro" placeholder="Introduction slider your site" maxlength="100" value="<?php echo $introtext;?>">                                                        
                                                        <br />    
                                                        <div class="btn-group">                           
                                                             <button type="button" class="btn btn-default add-heading">+ <?php echo $this->lang->line('addintrotext');?></button>                                                                                                                            
                                                        </div>
                                                   </div> 
                                                   <?php
                                                        echo $content_postbody;
                                                        $tpl = view_heading(true);                                                        
                                                        echo $tpl;
                                                   ?>  
                                                   <div class="form-group">
                                                        <label><?php echo $this->lang->line('copyright');?></label>
                                                        <input type="text" class="form-control" name="copyright" id="copyright" placeholder="© Copyright Your Site" required="required" value="<?php echo $copyright;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label><i class="fa fa-phone fa-fw"></i><?php echo $this->lang->line('phone');?></label>
                                                        <input type="text" class="form-control" name="contactUs" id="contactUs" placeholder="Phone" value="<?php echo $contactUs;?>" required="required">
                                                    </div>
                                                    <div class="form-group">
                                                        <label><i class="fa fa-envelope-o fa-fw"></i> <?php echo $this->lang->line('emailaddress');?></label>
                                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $email;?>" placeholder="Your email" required="required">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label><?php echo $this->lang->line('logo');?></label>
                                                        <input type="file" name="logoimg" id="logoimg"><br />          
                                                        <?php echo $logo; ?>
                                                    </div>   
                                                    <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('save');?></button>                        
                                                </form>     
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
 

<!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Update Image Gallery</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" name="imagesDescriptionold" >  
          <input type="hidden" value="" name="id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Caption</label>
              <div class="col-md-9">
                <input name="imagesCaption" placeholder="Caption Images" class="form-control" type="text">
              </div>
            </div>           
            <div class="form-group">
              <label class="control-label col-md-3">Short Description</label>
              <div class="col-md-9">
                  <input name="imagesDescription" id="imagesDescription" class="form-control" type="text" placeholder="Short Description" >                    
              </div>
            </div>            
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->


<script type="text/javascript">       
   
     /** ADD AND REMOVE BLOCK  **/      
    function addblock(id)
    {          
        var url   = $("#frm-block").attr('action');
        $.ajax({            
          url : "<?php echo site_url('cms/main/addblock');?>/"+id,
          type: "POST",
          dataType: "JSON"         
      }).done(function (data){
          $("#response").html(data);          
          window.location.reload();                     
        });;
    }
    
    function removeblock(id)
    {          
        var url   = $("#frm-block").attr('action');
        $.ajax({            
          url : "<?php echo site_url('cms/main/removeblock');?>/"+id,
          type: "POST",
          dataType: "JSON"         
      }).done(function (data){           
            $("#response").html(data);                                
            window.location.reload();   
        });;
    }
    
     /** END ADD BLOCK **/       

$(document).ready(function() {            
            var dataTable = $('#siteassets').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/assets/filldata/siteassets');?>", // json datasource
                            type: "post",  // method  , by default get
                            error: function(){  // error handling
                                    $(".siteassets-error").html("");
                                    $("#siteassets").append('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                                    $("#siteassets_processing").css("display","none");
                            }
                    }
            } );
            
            var data = $(this).serialize();
            var extraObj = $("#extraupload").uploadFile({
            url:"<?php echo site_url("cms/assets/upload");?>",
            fileName:"myfile",
            showPreview:true,
            extraHTML:function()
            {
                    var html   = "<div class='form-group'><label>Caption Image</label> <input type='text' name='caption' class='form-control' value='' /> </div>";
                        html += "<div class='form-group'><label>Short Desciption</label> <input type='text' name='desc_image' id='desc_image' class='form-control' value=''></div>"; 
                    return html;    		
            },
            autoSubmit:false
            });
            
            $("#extrabutton").click(function(data)
            {                 
                 extraObj.startUpload();                                   
                 $("#siteassets").dataTable().fnDraw();  
                 $('.ajax-file-upload-container').delay(5000).fadeOut('slow');                                            
            });  
        } );
                
        function delete_assets(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  url : "<?php echo site_url('cms/assets/delete_assets')?>/"+id,
                  type: "POST",
                  dataType: "JSON",
                  success: function(data)
                  {
                       $("#siteassets").dataTable().fnDraw();      
                       $("#response").show();
                       $("#response").html(data);                      
                       $('#response').delay(5000).fadeOut('slow');
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error adding / update data');
                  }
              });

            }
        }
            
            
        function update_asset(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            //Ajax Load data from ajax
            $.ajax({
              url : "<?php echo site_url('cms/assets/update_assets')?>/" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {                             
                  $('[name="id"]').val(data.id);
                  $('[name="imagesCaption"]').val(data.imagesCaption);
                  $('[name="imagesDescription"]').val(data.imagesDescription);             
                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Update Assets'); // Set title to Bootstrap modal title

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
            });
        }
        
        
        function save()
        {       
              $("#response").hide();  
              $.ajax({
                url :  "<?php echo site_url('cms/assets/push_update')?>",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                   //if success close modal and reload ajax table
                    $('#modal_form').modal('hide');
                    $("#siteassets").dataTable().fnDraw();  
                    $("#response").show();
                    $("#response").html(data);                        
                    $('#response').delay(5000).fadeOut('slow');                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {  
                    alert('Error adding / update data');
                }
            });
        }
  
      
</script>



                         