<!-- Begin page heading -->
<h1 class="page-heading"><?php echo $module;?></h1>
<!-- End page heading -->     
<div class="the-box">
<div class="row">            
        <div class="col-sm-12">
             <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i> <?php echo $this->lang->line("newentry");?> <span class="caret"></span></button>                
                <ul class="dropdown-menu" role="menu">                    
                    <li><a href="<?php echo site_url('cms/testimonial/post/add');?>"> Testimonial</a></li>                     
                </ul>
            </div>            
            <div id="userSettingsContent" class="tab-content">                
                        <div class="table-responsive">
                            <br />
                            <table id="list-testimonial" class="table table-striped table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>                                                
                                        <th>Guest Name</th>
                                        <th><?php echo $this->lang->line("postdate");?></th>                                        
                                        <th><?php echo $this->lang->line("action");?></th>
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
            var dataTable = $('#list-testimonial').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/testimonial/filldata')?>", 
                            type: "post",  
                            error: function(){  
                            }
                    }
            } );
                                      
        } );
        
        
        
        function delete_testimonial(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  url : "<?php echo site_url('cms/testimonial/delete')?>/"+id,
                  type: "POST",
                  dataType: "JSON",
                  success: function(data)
                  {
                     $("#list-testimonial").dataTable().fnDraw();                          
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
              

	