<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.gif');?>">
    <title><?php echo APP_TITLE;?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap.min.css');?>"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery-ui.min.css');?>"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/ekko-lightbox.min.css');?>"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/main.css');?>"/>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/parsley/parsley.css');?>"/>      
    <link rel="stylesheet" href="<?php echo site_url('assets/css/polyglot-switcher/polyglot-language-switcher.css');?>"/>    
</head>
<body>
<!-- SECTION NAVBAR -->
<div class="nav-wrapper">
    <div class="row">
        <div class="col-xs-12">
            <nav class="container navbar">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#mainNav">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">                        
                        <img class="img-responsive" src="<?php echo $logoimg;?>" alt=""/>                        
                        <img class="opaque-img img-responsive" src="<?php echo $opaqueimg; ?>" alt=""/>                        
                    </a>
                </div>
                <div id="mainNav" class="collapse navbar-collapse">
                    <a href="#rooms" class="btn btn-default btn-book pull-right" style="margin-top:15px;"><?php echo $this->lang->line("booknow");?></a>
                    <ul class="nav navbar-nav pull-right">
                        <li class="active"><a href="#about"><?php echo $this->lang->line("about");?></a></li>
                        <li><a href="#rooms"><?php echo $this->lang->line("rooms");?></a></li>
                        <li><a href="#services"><?php echo $this->lang->line("services");?></a></li>
                        <li><a href="#facilities"><?php echo $this->lang->line("facilities");?></a></li>
                        <li><a href="#location"><?php echo $this->lang->line("location");?></a></li>
                        <li><a href="#contact"><?php echo $this->lang->line("contact");?></a></li>                                            
                        <li class="dropdown">                            
                            <a class="dropdown-toggle language-select" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                               <span class="flag-<?php echo $flags;?>"></span><span class="caret"></span>                               
                            </a>
                            <ul class="dropdown-menu">  
                            <form id="form-lang" method="post" action="<?php echo site_url('home/language/');?>">                              
                               <li class="en"><a href="#"><span class="flag-en"></span> <em>English</em></a></li>
                               <li class="es"><a href="#"><span class="flag-es"></span> <em>Español</em></a></li>
                            </form>   							                                  
                            </ul>                                                         
                        </li>                     
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- SECTION BANNER -->
<section id="banner" class="container-fluid banner">
    <div class="content">
        <div class="col-xs-6 col-xs-offset-6 heading">
            <h1><?php echo $titlesite;?></h1>
            <p><?php echo $introtext;?></p>
        </div>
        <form class="col-xs-12 form-inline book-form" action="">
            <div class="form-group">
                <input class="form-control date" name="checkIn" id="checkIn" type="text" placeholder="<?php echo $this->lang->line('checkin');?>"/>
                <i class="fa fa-calendar"></i>
            </div>
            <div class="form-group">
                    <input class="form-control date" name="checkOut" id="checkOut" type="text" placeholder="<?php echo $this->lang->line('checkout');?>"/>
                    <i class="fa fa-calendar"></i>
            </div>
            <button type="submit" class="btn btn-default btn-book"><?php echo $this->lang->line("booknow");?></button>
        </form>
    </div>
</section>
<!-- SECTION ABOUT -->
<section id="about" class="container about">
    <div class="row">
        <div class="col-xs-12"><h1><?php echo $title_about;?></h1></div>
        <div class="col-sm-6">
            <p><?php echo $content_about;?></p>
        </div>
        <div class="col-sm-6">
            <div id="aboutCarousel" class="carousel slide" data-ride="carousel">
                <?php echo $images_about;?>
            </div>
        </div>
    </div>
</section>
<!-- SECTION ROOMS -->
<section id="rooms" class="container-fluid rooms grey">
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><h2><?php echo $this->lang->line('roomtype');?></h2></div>
           <!--- Cop and page this for each room type to go here-->
            <?php echo $listphoto;?>
            <!--end copy and paste -->           
        </div>
    </div>
</section>
<section class="container-fluid testimonial-banner">
    <div class="row">
        <div class="col-xs-12 content text-center">
            <blockquote><?php echo $this->lang->line("testimonialbanner");?></blockquote>
            <img class="img-responsive img-circle" src="<?php echo site_url("assets/images/testimonial-portrait.jpg");?>" alt=""/>
            <span>Sally Bishop <br>36, Australia</span>
        </div>
    </div>
</section>
<!-- Our Hotel Facilities section -->
<section id="facilities" class="container-fluid grey facilities">
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><h1><?php echo $this->lang->line("hostelfacilities");?></h1></div>
            <div class="col-sm-6">
                <div id="facilitiesCarousel" class="carousel slide" data-ride="carousel">
                    <?php echo $facilities_section;?>
                </div>
            </div>
            <div class="col-sm-6">
               <p><?php echo $content_facilities;?></p>
            </div>
        </div>
    </div>
</section>
<!-- SECTION SERVICES -->
<section id="services" class="container services">
    <div class="row">
        <div class="col-xs-12">
            <h1><?php echo $this->lang->line("services");?></h1>
            <div id="servicesCarousel" class="carousel slide" data-ride="carousel">
                <?php echo $services_section;?>
                <a class="left carousel-control" href="#servicesCarousel" role="button" data-slide="prev">
                    <img class="img-responsive" src="<?php echo site_url("assets/images/carousel-left.png");?>" alt="Previous"/>
                </a>
                <a class="right carousel-control" href="#servicesCarousel" role="button" data-slide="next">
                    <img class="img-responsive" src="<?php echo site_url("assets/images/carousel-right.png");?>" alt="Next"/>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- SECTION GALLERY -->
<?php if(!empty($listgallery)):?>
<section class="gallery container-fluid grey">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1><?php echo $this->lang->line('imagegallery');?></h1>
                <!-- copy and paste for the images in ths area, it is one row of images. -->
                <?php echo $listgallery;?>                
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- SECTION TESTIMONIALS -->
<section class="testimonials container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1><?php echo $this->lang->line("introtestimoni");?></h1>
                <?php echo $testimonial;?>
            </div>
        </div>
    </div>
</section>
<!-- SECTION MAP -->
<section id="location" class="container-fluid grey">
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><h1><?php echo $this->lang->line("location");?></h1></div>
            <div class="col-sm-6">
               <p><?php echo $content_location;?></p>
            </div>
            <div class="col-sm-6">
                <div id="locationCarousel" class="carousel slide" data-ride="carousel">
                    <?php echo $location_section;?>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="location" class="container-fluid map">
    <div class="row">
        <div id="map"></div>
        <input type="hidden" value="<?php echo $latitude;?>" id="latitude" />
        <input type="hidden" value="<?php echo $longitude?>" id="longitude" />
        <input type="hidden" value="<?php echo strval($titlesite);?>" id="titlesite" />
    </div>
</section>
<!-- SECTION CONTACT -->
<section id="contact" class="container-fluid contact grey">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1><?php echo $this->lang->line('contactus');?></h1>
                <p><?php echo $this->lang->line('phone');?>: +51 84 232233 / +51 84 260502<br /><?php echo $this->lang->line('youremail');?>: hostal@corihausi.com</p>
                <div id="response"></div>
                <form id="contact-form" data-parsley-validate="" action="<?php echo site_url("home/contactus");?>" method="post">
                    <div class="form-group">
                        <label for="name"><?php echo $this->lang->line('yourname');?></label>
                        <input id="name" name="name" class="form-control" type="text" required="" />
                    </div>
                    <div class="form-group">
                        <label for="email"><?php echo $this->lang->line('youremail');?></label>
                        <input id="email" name="email" class="form-control" type="email" data-parsley-type="email" data-parsley-trigger="change" required="" />
                    </div>
                    <div class="form-group">
                        <label for="phone"><?php echo $this->lang->line('phone');?></label>
                        <input id="phone" name="phone" class="form-control" type="text" type="number" data-parsley-type="integer" />
                    </div>
                    <div class="form-group">
                        <label for="comment"><?php echo $this->lang->line('message');?></label>
                        <textarea id="comment" name="comment" required="" class="form-control" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.." data-parsley-validation-threshold="10"></textarea>
                    </div>
                    <button class="btn btn-default" type="submit"><?php echo $this->lang->line("submit");?></button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- SECTION FOOTER -->
<section class="container-fluid footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center">
                <p>Copyright &copy; 2016</p>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo site_url('assets/js/jquery-1.12.0.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/parsley/parsley.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/bootstrap.min.js');?>"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script> 
<script src="<?php echo site_url('assets/js/markerwithlabel.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/jquery-ui.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/ekko-lightbox.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/jquery.mobile.custom.min.js');?>"></script>
<script src="<?php echo site_url('assets/js/polyglot-switcher/jquery.polyglot.language.switcher.js');?>"></script>
<script src="<?php echo site_url('assets/js/main.js');?>"></script>
</body>
</html>