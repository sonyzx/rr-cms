<h1 class="page-heading"><?php echo $module;?></h1>
<!-- Basic Tabs Example -->
    <div class="row">
       <form id="form-pages" role="form" method="post" action="<?php echo site_url("cms/pages/update");?>" enctype="multipart/form-data">
        <input type="hidden" name="module" id="module" value="<?php echo $this->uri->segment(4);?>" />       
        <div class="col-lg-8">
               <div class="the-box">                      
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="postTitle" name="postTitle" value="<?php echo $postTitle;?>" >                            
                    </div>                                                                         
                    <div class="form-group">
                          <label>Description</label>                          
                          <textarea class="form-control redactorwysg" rows="30" id="postDescription" name="postDescription" ><?php echo $postDescription;?></textarea>
                    </div>  
                                  
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Save</button> 
                </div>
            </div>
        </div>    
        </form>   
        <div class="col-lg-4">
            <div class="the-box">
                <div class="form-group">  
                    <form enctype="multipart/form-data" id="form-gallery"  role="form" method="post" action="<?php echo site_url("cms/pages/update_pic");?>" >                                                
                          <div id="extraupload"><?php echo $this->lang->line('upload');?></div>
                          <button type="button" id="doupload" class="btn btn-success"><i class="fa fa-cloud-upload"></i> <?php echo $this->lang->line('startupload');?></button>
                    </form>           
                </div>   
                <div class="table-responsive">
                    <table id="listpictures" class="table table-striped table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('images');?></th>                                                                                                                  
                            </tr>
                        </thead>                                        
                    </table>
                </div>
            </div>
        </div>     
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
 
    <script type="text/javascript">
        $(document).ready(function() {  
            
             var dataTable = $('#listpictures').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/pages/filldata/'.strtolower($module));?>", // json datasource
                            type: "post",  // method  , by default get
                            error: function(){  // error handling
                                    $(".siteassets-error").html("");
                                    $("#siteassets").append('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                                    $("#siteassets_processing").css("display","none");
                            }
                    }
            } );
            
            
            var extraObj = $("#extraupload").uploadFile({
                    url:"<?php echo site_url("cms/pages/update_pic/".strtolower($module));?>",
                    fileName:"myfile",
                    showPreview:true,
                    autoSubmit:false
                });
                
             $("#doupload").click(function()
             {
                extraObj.startUpload();                 
                $("#listpictures").dataTable().fnDraw();  
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
                       $("#listpictures").dataTable().fnDraw();      
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
                    
    </script>

