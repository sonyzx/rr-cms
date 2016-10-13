<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('assets/bootstrap/favicon.ico');?>">
    <title>Users Registration - <?php echo APP_TITLE;?></title>
    <!-- GLOBAL STYLES -->    
    <link href="<?php echo site_url('assets/css/bootstrap/bootstrap.min.css');?>" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="<?php echo site_url('assets/font-awesome-4.1.0/css/font-awesome.min.css'); ?>" rel="stylesheet">
   
    <!-- THEME STYLES -->
    <link href="<?php echo site_url('assets/css/bootstrapValidator/bootstrapValidator.min.css');?>" rel="stylesheet" />
    <link href="<?php echo site_url('assets/css/registration.css');?>" rel="stylesheet">
</head>
<body>
      <div class="header">            
            <div class="row">
                <div class="logo col-sm-8">
                    <h1><a href=""><?php echo $this->lang->line('createyour');?> <span class="red"><?php echo $this->lang->line('site');?></span></a></h1>
                </div>
                <div class="links col-sm-4">
                    <a class="home" href="<?php echo site_url('home/mysite/admin');?>" rel="tooltip" data-placement="bottom" data-original-title="<?php echo $this->lang->line('seeexamplesite');?>"></a>                    
                </div>
            </div>            
        </div>

        <div class="register-container container">
            <div class="row">                 
                <div class="register col-sm-6">
                    <form role="form" name="frmregistration" id="frmregistration" method="post" action="<?php echo site_url("cms/users/signup");?>">
                        <h2><?php echo $this->lang->line('userreg');?></h2>
                        <div id="response"></div>
                        <div class="form-group">
                            <label for="firstname"><?php echo $this->lang->line('firstname');?></label>
                            <input type="text" id="firstname" name="firstname" class="form-control" maxlength="100" placeholder="enter your first name..." required="required">
                        </div>
                        <div class="form-group">
                            <label for="lastname"><?php echo $this->lang->line('lastname');?></label>
                            <input type="text" id="lastname"  name="lastname" class="form-control" maxlength="100" placeholder="enter your first name...">
                        </div>
                        <div class="form-group">
                            <label for="username"><?php echo $this->lang->line('username');?></label>
                            <input type="text" id="username" name="username" class="form-control" maxlength="55" placeholder="choose a username..." required="required">
                        </div> 
                        <div class="form-group">
                            <label for="email"><?php echo $this->lang->line('emailaddress');?>Email</label>
                            <input type="text" id="email" name="email" class="form-control" maxlength="100" placeholder="enter your email...">
                        </div>
                        <div class="form-group">
                            <label for="password"><?php echo $this->lang->line('password');?></label>
                            <input type="password" id="password" name="password" class="form-control" maxlength="41" placeholder="choose a password...">
                        </div>
                        <div class="form-group">
                            <label for="password"><?php echo $this->lang->line('retypepass');?></label>
                            <input type="password" id="retypepassword" name="retypepassword" class="form-control" placeholder="retype your password...">
                        </div>
                        <div class="form-group">
                            <label for="password"><?php echo $this->lang->line('correctanswer');?></label>
                        </div> 
                         <div class="row">
                            <div class="col-sm-3">
                                <label class="control-label" id="captchaOperation"></label>     
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="captcha" />                                                                        
                            </div>    
                        </div>   
                        <br/>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('register');?></button>
                            <button type="reset" id="resetreg" class="btn btn-default"><?php echo $this->lang->line('reset');?></button>
                        </div>
                        <br>
                        <p class="small"><?php echo $this->lang->line('haveaccount');?> <?php echo anchor(site_url("cms/login"),"&nbsp;".$this->lang->line('clicklogin')); ?></p>
                    </form>
                </div>
            </div>
    </div>
  
    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo site_url('assets/js/jQuery/jquery-2.1.1.min.js');?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>   
    <script src="<?php echo site_url('assets/js/bootstrapValidator/formValidation.min.js');?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrapValidator/bootstrap.min.js');?>"></script>  
    <script src="<?php echo site_url('assets/js/jquery.backstretch.min.js');?>"></script>        
    <script src="<?php echo site_url('assets/js/registration.js');?>"></script>
</body>
</html>
