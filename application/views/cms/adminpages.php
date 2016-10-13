<!DOCTYPE html>
<html lang="en">
	<head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <meta name="description" content="">
            <meta name="keywords" content="">
            <meta name="author" content="">
            <link rel="icon" href="<?php echo base_url('assets/images/favicon.gif');?>">
            <title>CMS - <?php echo APP_TITLE;?></title>
            <!-- BOOTSTRAP CSS (REQUIRED ALL PAGE)-->
            <link href="<?php echo site_url('assets/css/bootstrap/bootstrap.min.css');?>" rel="stylesheet">
            <!-- MAIN CSS (REQUIRED ALL PAGE)-->
            <link href="<?php echo site_url('assets/font-awesome-4.1.0/css/font-awesome.min.css'); ?>" rel="stylesheet">
            <link href="<?php echo site_url('assets/css/admin.css');?>" rel="stylesheet">
            <link href="<?php echo site_url('assets/css/admin-responsive.css');?>" rel="stylesheet">            
            <link href="<?php echo site_url('assets/css/bootstrapValidator/bootstrapValidator.min.css');?>" rel="stylesheet" />   
            <link href="<?php echo site_url('assets/css/datatables/datatables.css');?>" rel="stylesheet">
            <link href="<?php echo site_url('assets/css/bootstrap-switch/bootstrap-switch.min.css');?>" rel="stylesheet" />             
            <link href="<?php echo site_url('assets/css/jqueryupload/uploadfile.css');?>" rel="stylesheet">
            <link href="<?php echo site_url('assets/css/stars/star-rating.css');?>" rel="stylesheet">
            <link href="<?php echo site_url('assets/css/gmaps/jquery-gmaps-latlon-picker.css');?>" rel="stylesheet" />
            <link href="<?php echo site_url('assets/js/redactor/redactor.css');?>" rel="stylesheet">
            
            <script src="<?php echo site_url('assets/js/jQuery/jquery-2.1.1.min.js');?>"></script>
            <script src="<?php echo site_url('assets/js/jQuery/jquery.min.js');?>"></script>
            <script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>
            <script src="<?php echo site_url('assets/js/bootstrapValidator/formValidation.min.js');?>"></script>
            <script src="<?php echo site_url('assets/js/bootstrapValidator/bootstrap.min.js');?>"></script>            
            <script src="<?php echo site_url('assets/js/jqueryupload/jquery.uploadfile.min.js');?>"></script>
            
            <script src="<?php echo site_url('assets/js/datatables/jquery.dataTables.js');?>"></script>
            <script src="<?php echo site_url('assets/js/datatables/datatables-bs3.js');?>"></script>
            <script src="<?php echo site_url('assets/js/bootstrap-switch/bootstrap-switch.min.js');?>"></script>  
            <script src="<?php echo site_url('assets/js/stars/star-rating.js');?>"></script>              
            	  
            <script src="<?php echo site_url('assets/js/redactor/redactor.js');?>"></script>
            <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
            <script src="<?php echo site_url('assets/js/apps.js');?>"></script>    
            <!-- PAGE LEVEL PLUGIN SCRIPTS -->
	</head>
	<body class="tooltips">
                <!-- BEGIN PAGE -->
                <div class="wrapper">
                    	<!-- BEGIN TOP NAV -->
		  <div class="top-navbar">
				<div class="top-navbar-inner">					
					<!-- Begin Logo brand -->
					<div class="logo-brand">
						<a href="<?php echo site_url('cms/main');?>"><img class="img-responsive" src="<?php echo site_url('assets/images/flex-admin-logo@1x.png');?>" alt="Logo"></a>
					</div><!-- /.logo-brand -->
					<!-- End Logo brand -->
					
					<div class="top-nav-content no-left-sidebar">
						<!-- Begin button nav toggle -->
						<div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav">							
						</div><!-- /.btn-collapse-sidebar-right -->
						<!-- End button nav toggle -->
												
						<!-- Begin user session nav -->
						<ul class="nav-user navbar-right full">
							<li class="dropdown">
                                <a href="<?php echo site_url('cms/profile');?>" class="dropdown-toggle" data-toggle="dropdown">                                                                                
                                    <img id="avatartop" src="<?php echo $avatar;?>" class="avatar img-circle" alt="p Avatar">
                                    <span class="username username-hide-on-mobile"><?php echo $username;?></span>
                                    <i class="fa fa-caret-down"></i>
                                 </a>
                                    <ul class="dropdown-menu dropdown-user">                                                                
                                        <li><a target="_blank" href="<?php echo site_url('home/mysite/'.$username);?>"><i class="fa fa-eye"></i> <?php echo $this->lang->line('previewsite');?></a> </li>
                                        <li><a href="<?php echo site_url('cms/profile');?>"><i class="fa fa-user"></i> <?php echo $this->lang->line('myprofile');?></a></li>    
                                        <li><a href="<?php echo site_url('cms/testimonial');?>"><i class="fa fa-ticket"></i> Testimonial</a></li>                                       
                                        <?php 
                                            $access=$this->session->userdata('levelaccess'); 
                                            if($access=="admin"):
                                        ?>                                                                                
                                                <li class="divider"></li>
                                                <li><a href="<?php echo site_url('cms/users');?>"><i class="fa fa-users"></i> <?php echo $this->lang->line('user');?></a></li>
                                                <li><a href="<?php echo site_url('cms/settings');?>"><i class="fa fa-gear"></i> <?php echo $this->lang->line('setting');?></a></li>
                                        <?php
                                            endif;
                                        ?>
                                                <li><a class="logout_open" href="<?php echo site_url('cms/users/logout');?>"><i class="fa fa-sign-out"></i> <?php echo $this->lang->line('logout');?></a></li>
                                    </ul>
                                <!-- /.dropdown-menu -->
                            </li>
						</ul>
						<!-- End user session nav -->
						
						<!-- Begin Collapse menu nav -->
						<div class="collapse navbar-collapse" id="main-fixed-nav">
							
							
						</div><!-- /.navbar-collapse -->
						<!-- End Collapse menu nav -->
					</div><!-- /.top-nav-content -->
				</div><!-- /.top-navbar-inner -->
			</div><!-- /.top-navbar -->
			<!-- END TOP NAV -->
		
			<!-- BEGIN PAGE CONTENT -->
                                <div class="page-content no-left-sidebar">                           
                                        <div class="container-fluid">                                             
                                            <!-- BEGIN PAGE CONTENT -->                            
                                            <div id="response"></div>                                            
                                            <?php echo $contents;?>
                                            <!-- END PAGE CONTENT -->
                                        </div>
                                </div><!-- /.container-fluid -->
                        
                                <!-- BEGIN FOOTER -->
                                <footer>
                                        &copy; 2015 <a href="#"> <?php echo APP_TITLE;?>.</a>
                                </footer>
                                <!-- END FOOTER -->
                        
                </div>                            
    </div><!-- /.wrapper -->
    <!-- END PAGE CONTENT -->
		    
    <!-- BEGIN BACK TO TOP BUTTON -->
    <div id="back-top">
            <a href="#top"><i class="fa fa-chevron-up"></i></a>
    </div>
    <!-- END BACK TO TOP -->
    <!-- BEGIN SWITCH STYLER -->
    <div id="style-switch">
          <form id="form-lang" role="form" action="<?php echo site_url('cms/main/language');?>"> 
  	         <div class="title"><?php echo $this->lang->line('language');?></div> 
                <div class="skin-colors"><?php echo $this->mytemplate->changeLanguage();?></div>                   
         </form> 
         <br />
    </div>
    <div id="switch-open"><i class="fa fa-cog"></i></div>
    <!-- END SWITCH STYLER -->
    
</body>
</html>             