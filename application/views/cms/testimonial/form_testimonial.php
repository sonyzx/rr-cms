<h1 class="page-heading"><?php echo $module;?></h1>
<!-- Basic Tabs Example -->
    <div class="row">
        <div class="col-lg-12">
               <div class="the-box">    
                   <form role="form" id="form-testimonial" name="form-testimonial" enctype="multipart/form-data" method="post" action="<?php echo site_url('cms/testimonial/pushdata/');?>">
                      <input type="hidden" name="action" value="<?php echo $action;?>" />
                      <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />    
                      <div class="form-group">
                          <label>Guest Say</label>
                          <input type="text" class="form-control" id='postTitle' name="postTitle" value="<?php echo $postTitle;?>" maxlength="100" required="required">                            
                      </div>                      
                      <div class="form-group">
                          <label><?php echo $this->lang->line('stars');?></label>
                          <input id="star" name="postSubheading" value="<?php echo $postSubheading;?>" type="number" class="rating" min=0 max=5 step=1 data-size="xs" data-stars="5">
                      </div>                       
                      <div class="form-group">
                            <label>Testimonial</label>
                            <textarea name="postDescription" id='postDescription' class="form-control redactorwysg" required="required"><?php echo $postDescription;?></textarea>
                      </div> 
                      <div class="form-group">
                          <label>Guest Name</label>
                          <input type="text" class="form-control" maxlength="20" id='postHeading' name="postHeading" value="<?php echo $postHeading;?>" required="required">                            
                      </div> 
                      <div class="form-group">
                            <label>Picture</label>
                            <input type="file" name='logo' id="logo"/>
                            <?php if(!empty($logo)){?>
                             <br />
                             <img id="logoimg" src="<?php echo $logo;?>" class="img-responsive thumb-article"/>
                            <?php } ?>
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
   
