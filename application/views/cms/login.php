<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.gif');?>">
    <title>Login - <?php echo APP_TITLE;?></title>
    <!-- GLOBAL STYLES -->        
    <link href="<?php echo site_url('assets/css/bootstrap/bootstrap.min.css');?>" rel="stylesheet"/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">    
    <link href="<?php echo site_url('assets/font-awesome-4.1.0/css/font-awesome.min.css'); ?>" rel="stylesheet"/>    
    <link href="<?php echo site_url('assets/css/bootstrapValidator/bootstrapValidator.min.css');?>" rel="stylesheet" />
    <link href="<?php echo site_url('assets/css/main.css');?>" rel="stylesheet"/>    
</head>
<body class="login" onload="show_loginform();">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-banner text-center">
                    <h3><i class="fa fa-lock"></i> <span class="login_form"><?php echo $this->lang->line('loginadmin');?></span> <span class="resetpassword"><?php echo $this->lang->line('forgotpassword');?></span></h3>
                </div>
                <div class="portlet portlet-blue">
                    <div class="portlet-heading login-heading">
                        <div class="portlet-title"><h4></h4></div>
                        <div class="portlet-widgets">
                            <a href="<?php echo site_url();?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('newuser');?></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div id="response"></div>
                        <?php echo isset($activeuser)? $activeuser : ''; ?>
                        <div class="login_form">
                                <form role="form" name="loginfrm" id="loginfrm" method="post" action="<?php echo site_url("cms/login/check");?>">
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="E-mail or Username" name="email" id="email" type="text" maxlength="55">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="" maxlength="55">
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="remember" type="checkbox" value="Remember Me"><?php echo $this->lang->line('rememberme');?>
                                            </label>
                                        </div>
                                        <br>                                
                                        <button type="submit" class="btn btn-success btn-block btn-lg"><?php echo $this->lang->line('signin');?></button>
                                    </fieldset>
                                    <br>
                                    <p class="small"><a href="javascript:void(0)" onclick="show_reset_password();"><?php echo $this->lang->line('forgot');?></a></p>
                                </form>
                        </div>
                        <div class="resetpassword">
                                <form role="form" name="resetpass" id="resetpass" method="post" action="<?php echo site_url("cms/users/reset_password");?>">
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Your email" name="email" id="email" type="text" maxlength="100">
                                        </div>                                        
                                        <br>                                
                                        <button type="submit" class="btn btn-danger btn-block btn-lg"><?php echo $this->lang->line('reset');?></button>
                                    </fieldset>
                                    <br>
                                    <p class="small"><?php echo $this->lang->line('haveaccount');?><a href="javascript:void(0)" onclick="show_loginform();">&nbsp;<?php echo $this->lang->line('clicklogin');?></a></p>
                                </form>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GLOBAL SCRIPTS -->
    <script src="<?php echo site_url('assets/js/jQuery/jquery-2.1.1.min.js');?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrapValidator/formValidation.min.js');?>"></script>    
    <script src="<?php echo site_url('assets/js/bootstrapValidator/bootstrap.min.js');?>"></script>
    <script src="<?php echo site_url('assets/js/redactor/redactor.js');?>"></script>       
    <script src="<?php echo site_url('assets/js/apps.js');?>"></script>
</body>

</html>
