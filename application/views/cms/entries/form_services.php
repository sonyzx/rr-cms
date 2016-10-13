<h1 class="page-heading"><?php echo $module;?></h1>
<!-- Basic Tabs Example -->
    <div class="row">     
        <div class="col-lg-12">
            <div class="the-box">
                <div class="form-group">  
                    <form enctype="multipart/form-data" id="form-gallery"  role="form" method="post" action="<?php echo site_url("cms/pages/update_pic");?>" >                                                
                          <div id="serviceupload"><?php echo $this->lang->line('upload');?></div>
                          <button type="button" id="dosubmit" class="btn btn-success"><i class="fa fa-cloud-upload"></i> <?php echo $this->lang->line('startupload');?></button>
                    </form>           
                </div>   
                <div class="table-responsive">
                    <table id="listservices" class="table table-striped table-bordered table-hover table-striped">
                        <thead>
                            <tr>                                  
                                <th><?php echo $this->lang->line('images');?></th>
                                <th>Service Name</th>
                                <th><?php echo $this->lang->line('updates');?></th>
                                <th><?php echo $this->lang->line('action');?></th>                                                                                                              
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
            
             var dataTable = $('#listservices').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/assets/filldata/'.strtolower($module));?>", // json datasource
                            type: "post",  // method  , by default get
                            error: function(){  // error handling
                                    $(".listservices-error").html("");
                                    $("#listservices").append('<tbody class="employee-grid-error"><tr><th colspan="4">No data found in the server</th></tr></tbody>');
                                    $("#listservices").css("display","none");
                            }
                    }
            } );
            
            
            var extraObj = $("#serviceupload").uploadFile({
                    url:"<?php echo site_url("cms/assets/upload/".strtolower($module));?>",
                    fileName:"myfile",
                    showPreview:true,
                    extraHTML:function()
                    {
                            var html   = "<div class='form-group'><label>Service Name</label> <input type='text' name='caption' class='form-control' value='' /> </div>";
                                html += "<div class='form-group'><label>Short Desciption</label> <input type='text' name='desc_image' id='desc_image' class='form-control' value=''></div>"; 
                            return html;    		
                    },
                    autoSubmit:false
                });
                
             $("#dosubmit").click(function()
             {
                extraObj.startUpload();                 
                $("#listservices").dataTable().fnDraw();  
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
                       $("#listservices").dataTable().fnDraw();      
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
                    
    </script>

