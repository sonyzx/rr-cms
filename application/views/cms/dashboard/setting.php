<!-- Begin page heading -->
<h1 class="page-heading"><?php echo $module;?></h1>
<div class="row">
    <div class="col-lg-12">            
            <div class="portlet portlet-default">
                <div class="portlet-body">
                                <ul id="userTab" class="nav nav-tabs">
                                    <li class="active"><a href="#block" data-toggle="tab"><?php echo $this->lang->line('blocks');?></a></li>
                                    <li><a href="#aws" data-toggle="tab">AWS Config</a></li> 
                                    <li><a href="#bucket" data-toggle="tab">Bucket</a></li>
                                </ul>
                                <div id="userTabContent" class="tab-content">                                   
                                    <div class="tab-pane fade in active" id="block">
                                       <div class="row">                           
                                            <div class="col-lg-12">
                                               <div class="portlet-title">
                                                   <h4>Create Block</h4>
                                               </div>                                                
                                                <form  role="form" id="createblock" name="createblock" method="post" action="<?php echo site_url('cms/settings/addblock');?>" >
                                                    <div class="form-inline">  
                                                        <div class="form-group">
                                                            <input type="text" name="blocktype" id="buckettype" class="form-control" required="required" maxlength="30">
                                                            <button type="submit" name="addblock" id="addblock" class="btn btn-danger"> <?php echo $this->lang->line('save');?></button>
                                                        </div>
                                                    </div>    
                                                </form>
                                                <br/>
                                               <div class="table-responsive">
                                                       <table id="listblock" class="table table-striped table-bordered table-hover table-striped">
                                                           <thead>
                                                               <tr>
                                                                   <th>Block ID</th>
                                                                   <th>Block Type</th>
                                                                   <th>Date Create</th> 
                                                                   <th>Action</th>
                                                               </tr>
                                                           </thead>                                        
                                                       </table>
                                                   </div>
                                                   <!-- /.table-responsive -->
                                           </div>
                                       </div>

                                    </div>
                                    
                                    <div class="tab-pane fade" id="aws">
                                         <div class="row">
                                            <div class="col-lg-12">
                                                <form role="form" action="<?php echo site_url('cms/settings/setconnection');?>" id="formawsconfig" name="formawsconfig">                                                            
                                                    <div class="form-group">
                                                        <label>Key</label>
                                                        <input type="text" id="key" name="key" maxlength="50" class="form-control" value="<?php echo $key;?>" placeholder="Fill Key" required="required">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Secret</label>
                                                        <input type="text" id="secret" name="secret" maxlength="50" class="form-control" value="<?php echo $secret;?>" placeholder="Fill Secret" required="required">
                                                    </div>     
                                                    <div class="form-group">
                                                        <label>Region</label>
                                                        <input type="text" id="region" name="region" maxlength="50" class="form-control" value="<?php echo $region;?>" placeholder="us-west-1" required="required">
                                                    </div>     
                                                    <button type="submit" class="btn btn-danger">Connect</button>
                                                    <button type="reset" id="reset-aws" class="btn btn-default">Cancel</button>
                                                </form>
                                            </div>                                            
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="bucket">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <br />
                                                <form id="frmaddbucket" role="form" class="form-inline" method="post" action="<?php echo site_url('cms/settings/addbucket');?>"   >                                                
                                                        <div class="form-group">
                                                             <label  for="bucketname">Bucket Name</label>
                                                             <input type="text" name="bucketname" id="bucketname" class="form-control" value="" placeholder="Bucket Name" required="required">
                                                         </div>                                                        
                                                        <div class="form-group">
                                                            <label for="blocktype">Block Type</label>
                                                            <select name="blocktype" id="blocktype" class="form-control" required="required">
                                                               <?php echo $theblocks;?>
                                                            </select>
                                                        </div>    
                                                         <div class="form-group">
                                                             <button type="submit" class="btn btn-danger" >Add Bucket</button>
                                                         </div>                                           
                                                 </form>      
                                                <br />
                                                 <table id="listbucket" class="table table-striped table-bordered table-hover table-green">
                                                        <thead>
                                                            <tr>
                                                                <th>Bucket Name</th>
                                                                <th>Block Type</th>
                                                                <th>Date Create</th>
                                                                <th>Action</th>                                                
                                                            </tr>
                                                        </thead>                                                    
                                                 </table>
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
      <input type="hidden" value="" name="id"/>
      <div class="form-body">
        <div class="form-group">
          <label class="control-label col-md-3">Block Type</label>
          <div class="col-md-9">
            <input name="blockType" placeholder="Caption Images" class="form-control" type="text">
          </div>
        </div>                           
      </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="saveblock()" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_bucket" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Update Bucket</h3>
          </div>
          <div class="modal-body form">
            <form action="#" id="formbucket" class="form-horizontal">          
              <input type="hidden" value="" name="id"/>
              <div class="form-body">
                <div class="form-group">
                  <label class="control-label col-md-3">Bucket Name</label>
                  <div class="col-md-9">
                    <input name="bucketName" placeholder="Bucket Name" class="form-control" type="text">
                  </div>
                </div>      
                <div class="form-group">
                  <label class="control-label col-md-3">Bucket Name</label>
                  <div class="col-md-9">
                    <select name="blocktype" id="blocktype" class="form-control" required="required">
                          <?php echo $theblocks;?>
                    </select>
                  </div>
                </div>        
              </div>
            </form>
              </div>
              <div class="modal-footer">
                <button type="button" id="btnSave" onclick="savebucket()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script type="text/javascript">   
      $(document).ready(function() {            
            var dataTable = $('#listblock').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/settings/datablock')?>", // json datasource
                            type: "post",  // method  , by default get
                            error: function(){  // error handling
                                    $(".siteassets-error").html("");
                                    $("#siteassets").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                    $("#siteassets_processing").css("display","none");
                            }
                    }
            } );
            
             var dataTable = $('#listbucket').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                            url :"<?php echo site_url('cms/settings/databucket')?>", // json datasource
                            type: "post",  // method  , by default get
                            error: function(){  // error handling
                                    $(".siteassets-error").html("");
                                    $("#siteassets").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                    $("#siteassets_processing").css("display","none");
                            }
                    }
            } );
              
    } );
    
     /** REMOVE BLOCK  **/      

    function delete_block(id)
    {     
       var dataTable = $('#listblock').dataTable(); 
       $.ajax({            
          url : "<?php echo site_url('cms/settings/deleteblock');?>/"+id,
          type: "POST",
          dataType: "JSON"         
      }).done(function (data){           
            $("#response").html(data);  
            dataTable.fnDraw();
            $('#response').delay(5000).fadeOut('slow');
        });;
    }
    
    
   function update_block(id)
   {            
            $('#form')[0].reset();             
            $.ajax({
              url : "<?php echo site_url('cms/settings/update_block')?>/" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                  $('[name="id"]').val(data.id);
                  $('[name="blockType"]').val(data.blockType);                          
                  $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Update Block'); // Set title to Bootstrap modal title

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
            });
    }
     
     
    function saveblock()
   {        
          var dataTable = $('#listblock').dataTable();   
          $.ajax({
            url :  "<?php echo site_url('cms/settings/push_update')?>",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');  
                dataTable.fnDraw();
               $("#response").html(data);
               $('#response').delay(5000).fadeOut('slow');
            }
        });
    } 
    
    function delete_bucket(id)
    {     
       var dataTable = $('#listbucket').dataTable(); 
       $.ajax({            
          url : "<?php echo site_url('cms/settings/deletebucket');?>/"+id,
          type: "POST",
          dataType: "JSON"         
      }).done(function (data){           
            $("#response").html(data);  
            dataTable.fnDraw();
            $('#response').delay(5000).fadeOut('slow');
        });;
    }
    
    
    /** END ADD BLOCK **/       
    
      function update_bucket(id)
      {            
            $('#formbucket')[0].reset();             
            $.ajax({
              url : "<?php echo site_url('cms/settings/update_bucket')?>/" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                  $('[name="id"]').val(data.id);
                  $('[name="bucketName"]').val(data.bucketName);                          
                  $('[name="blockID"]').val(data.blockID);
                  $('#modal_bucket').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Update Bucket'); // Set title to Bootstrap modal title

              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
            });
       }
    
     
        
       function savebucket()
       {        
              var dataTable = $('#listbucket').dataTable();   
              $.ajax({
                url :  "<?php echo site_url('cms/settings/push_updatebucket')?>",
                type: "POST",
                data: $('#formbucket').serialize(),
                dataType: "JSON",
                success: function(data)
                {
                   //if success close modal and reload ajax table
                   $('#modal_bucket').modal('hide');  
                    dataTable.fnDraw();
                   $("#response").html(data);
                   $('#response').delay(5000).fadeOut('slow');
                }
            });
        }

</script>



                         