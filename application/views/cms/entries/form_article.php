<?php        
    $mode   = $this->uri->segment(4,'add'); 
    $codeID  = $this->uri->segment(5,0);    
?>
<h1 class="page-heading"><?php echo $title;?></h1>
<!-- Basic Tabs Example -->
    <div class="row">
       <form id="form-article" role="form" method="post" action="<?php echo site_url("cms/entries/pushdata/".$mode);?>" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $codeID;?>" name="postID">  
        <div class="col-lg-8">
               <div class="the-box">                      
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title_name" name="title_name" value="<?php echo $postTitle;?>" >                            
                    </div>                                                      
                    <div class="form-group">
                        <label>Featured Images</label><br />
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#uploadfile">+ Add an asset</button>
                    </div>
                    <div class="form-group">
                          <label>Short Description</label>                          
                          <textarea class="form-control" id="shortdesc" name="shortdesc" ><?php echo $shortdesc;?></textarea>
                    </div>
                     <div class="form-group">
                        <label>Heading</label>
                        <input type="text" class="form-control" id="mainheading" name="mainheading" value="<?php echo $mainheading;?>">                            
                    </div>
                    <div class="form-group">
                        <label>Sub Heading</label>
                        <input type="text" class="form-control" id="subheading" name="subheading" value="<?php echo $subheading;?>" >                            
                    </div>   
                   
                   <div class="form-group">                         
                     <label>Article Body</label><br/>                         
                        <div class="btn-group">                           
                            <button type="button" class="btn btn-default">+ Add a block</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="#" class="add-heading">Heading</a>
                                </li>
                                <li>
                                    <a href="#" class="add-text">Text</a>
                                </li>
                                <li>
                                    <a href="#" class="add-pullquote">Pull Quote</a>
                                </li>
                                 <li>
                                     <a href="#" class="add-image">Gallery</a>
                                </li>                                
                                 <li>
                                     <a href="#" class="add-quote">Quote</a>
                                </li>
                            </ul>
                        </div>
                    </div>   
                   <!-- SHOW POST BODY ON UPDATE -->
                     <?php
                       echo $content_postbody;
                       $tpl = view_heading(true);
                       $tpl .= view_text(true,'');
                       $tpl .= view_pullquote(true,'');
                       $tpl .= view_images(true,'');
                       $tpl .= view_quote(true, '');
                       echo $tpl;
                     ?>
                   <!-- END SHOW POST BODY -->

               </div>    
                <!-- /.portlet-body -->
        </div>
        <div class="col-lg-4">
            <div class="the-box">
<!--                <div class="form-group">
                    <a href="#" class="button btn-default"><i class="fa fa-eye"></i> Live Preview </a>
                </div>    -->
                 <div class="form-group">
                        <label>Entry Type</label>                      
                        <select data-prefill="2" class="form-control" name="entrytype">
                            <option value="articles" <?php echo ($postModule=="articles")? "selected='selected'" : "";?>>Articles</option>
                            <option value="hotels" <?php echo ($postModule=="hotels")? "selected='selected'" : "";?>>Hotels</option>                           
                        </select>                           
                 </div>
                 <div class="form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $postSlug;?>" >                            
                 </div>
                <div class="form-group">
                        <label>Post Date</label><br>                           
                        <div class="col-md-8" id="sandbox-container">
                            <input name="postdate" type="text" id="postdate" value="" class="form-control" placeholder="Post Date" value="<?php echo $postDate;?>" />   
                        </div>                                            
                        <div class="col-md-4 input-append bootstrap-timepicker input-group">
                            <input id="timepicker1" name="timepicker1" class="form-control" type="text" value="<?php echo $postTime;?>" />
                            <span class="input-group-btn">
                                <button class="btn btn-default add-on" type="button"><i class="fa fa-clock-o"></i>
                                </button>
                            </span>
                        </div>                        
                </div>
                <div class="form-group">
                    <label>Expiration Date</label><br>
                    <div class="clearfix visible-xs"></div>
                    <div class="col-md-8" id="sandbox-container">
                        <input name="expirationdate" type="text" id="expirationdate" value="<?php echo $ExDate;?>" class="form-control" placeholder="Expiration Date"/>                          
                    </div>
                    <div class="col-md-4 input-append bootstrap-timepicker input-group">
                            <input id="timepicker2" name="timepicker2" class="form-control" type="text" value="<?php echo $ExTime;?>" />
                            <span class="input-group-btn">
                                <button class="btn btn-default add-on" type="button"><i class="fa fa-clock-o"></i>
                                </button>
                            </span>
                   </div>
                </div>
                 <div class="form-group">
                        <label>Enable</label>   
                        <br>                        
                        <input type="checkbox" class="form-control" name="enabled" <?php echo ($publish==1)? "checked" : ""; ?>>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Save</button> 
                </div>
            </div>
        </div>    
        </form>    
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    
  
<!-- Bootstrap Model -->
    <div class="modal fade" id="uploadfile" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Upload File</h4>
                </div>
                <div class="modal-body text-center">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Select</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bootstrap Modal -->  
    
 <link href="<?php echo site_url('assets/css/bootstrap-datepicker/datepicker3.css');?>" rel="stylesheet">
 <link href="<?php echo site_url('assets/css/bootstrap-timepicker/bootstrap-timepicker.min.css');?>" rel="stylesheet">   
 <script src="<?php echo site_url('assets/js/bootstrap-timepicker/bootstrap-timepicker.min.js');?>"></script>
 <script src="<?php echo site_url('assets/js/bootstrap-datepicker/bootstrap-datepicker.js');?>"></script>
 <script src="<?php echo site_url('assets/js/tinymce/tinymce.min.js');?>"></script>

<script type="text/javascript">
    "use strict";    
    $("[name='enabled']").bootstrapSwitch();
    
    $("#title_name").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $("#slug").val(Text);        
    });   
    
    $(document).ready(function(){                          
       $('#timepicker1').timepicker();
       $('#timepicker2').timepicker();
        
        setTimeout(function() {
            $('#timeDisplay').text($('#timepicker1').val());
            $('#timeDisplay').text($('#timepicker2').val());
        }, 100);

        $('#timepicker1').on('changeTime.timepicker', function(e) {
            $('#timeDisplay').text(e.time.value);
        });             
        $('#timepicker2').on('changeTime.timepicker', function(e) {
            $('#timeDisplay').text(e.time.value);
        });
    });
    
    $('#sandbox-container input').datepicker({
        autoclose: true,
        todayHighlight: true
    });
      
    tinymce.init({
    selector: "#shortdesc",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
  
      
</script>


