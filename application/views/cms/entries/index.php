<!-- Begin page heading -->
<h1 class="page-heading"><?php echo $module;?></h1>
<!-- End page heading -->     
<div class="the-box">
<div class="row">    
        <div class="col-sm-3">
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i> New Entry <span class="caret"></span></button>                
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo site_url('cms/entries/post/add');?>"> Articles</a></li>               
                    <li><a href="<?php echo site_url('cms/entries/post/add');?>"> Hotels</a></li>
                </ul>
            </div>
            <br><br>
            <ul id="userSettings" class="nav nav-pills nav-stacked">
                <li class="active"><a href="#listarticle" data-toggle="tab">Articles</a></li>          
                <li><a href="#listhotels" data-toggle="tab">Hotels</a></li>          
            </ul>
        </div>
        <div class="col-sm-9">
            <div id="userSettingsContent" class="tab-content">
                <div class="tab-pane fade in active" id="listarticle">                    
                        <div class="table-responsive">
                            <table id="entries-article" class="table table-striped table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Article Title</th>                                                
                                        <th>Post Date</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                                        
                            </table>
                        </div>
                        <!-- /.table-responsive -->                        
                     <!-- /.portlet-body -->
                </div>
                
                <div class="tab-pane fade" id="listhotels">
                    <div class="table-responsive">
                            <table id="entries-hotels" class="table table-striped table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Hotel Title</th>                                                
                                        <th>Post Date</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                                        
                            </table>
                        </div>
                        <!-- /.table-responsive -->  
                </div>     
                
                
            </div>
        </div>
    </div>    
</div>

 <script type="text/javascript" language="javascript" >
        $(document).ready(function() {            
            var dataTable = $('#entries-article').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/entries/filldata/articles')?>", 
                            type: "post",  
                            error: function(){  
                            }
                    }
            } );
            
             var dataHotels = $('#entries-hotels').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/entries/filldata/hotels')?>", 
                            type: "post",  
                            error: function(){  
                            }
                    }
            } );
              
        } );
        
        function reload_table()
        {
          dataTable.ajax.reload(null,false); //reload datatable ajax
        }
        
        function delete_entries(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
              // ajax delete data to database
                $.ajax({
                  url : "<?php echo site_url('cms/entries/delete')?>/"+id,
                  type: "POST",
                  dataType: "JSON",
                  success: function(data)
                  {
                     $("#entries-hotels").dataTable().fnDraw();      
                     $("#entries-article").dataTable().fnDraw();
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error adding / update data');
                  }
              });

            }
        }
            
       
</script>      
              

	