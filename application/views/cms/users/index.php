<!-- Begin page heading -->
<h1 class="page-heading"><?php echo $module;?></h1>
<!-- End page heading -->     
<div class="the-box">
<div class="row">            
        <div class="col-sm-12">
             <div class="btn-group">
                 <a href="<?php echo site_url('cms/users/post/add');?>" class="btn btn-danger"><i class="fa fa-plus"></i> Add Users</a>                                
            </div>            
            <div id="userSettingsContent" class="tab-content">                
                        <div class="table-responsive">
                            <br />
                            <table id="list-users" class="table table-striped table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Full name</th>                                                
                                        <th>Username</th>
                                        <th>Email</th>                                        
                                        <th>Last Login</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>                                        
                            </table>
                        </div>
                        <!-- /.table-responsive -->                        
                     <!-- /.portlet-body -->
                </div>
        </div>
    </div>    
</div>

 <script type="text/javascript" language="javascript" >
        $(document).ready(function() {            
            var dataTable = $('#list-users').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/users/filldata')?>", 
                            type: "post",  
                            error: function(){  
                            }
                    }
            } );
                                      
        } );
        
        
        
        function delete_users(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  url : "<?php echo site_url('cms/users/delete')?>/"+id,
                  type: "POST",
                  dataType: "JSON",
                  success: function(data)
                  {
                     $("#list-users").dataTable().fnDraw();                          
                     $("#response").html(data);
                     $('#response').delay(5000).fadeOut('slow');
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      $("#response").html(data);
                      $('#response').delay(5000).fadeOut('slow');
                  }
              });

            }
        }   
</script>      
              

	