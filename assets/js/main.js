
function initMap() {
    var nmsite = document.getElementById('titlesite').value;
    var lati = document.getElementById('latitude').value;
    var longi = document.getElementById('longitude').value;
    var hostelLatLng = {lat: parseFloat(lati), lng: parseFloat(longi)};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        center: hostelLatLng,
        disableDefaultUI: true,
        scrollwheel: false
    });

    var marker = new MarkerWithLabel({
        position: hostelLatLng,
        map: map,
        labelContent: String(nmsite),
        labelAnchor: new google.maps.Point(0, 10),
        labelClass: 'label',
        title: String(nmsite)
    })
    
    
}

initMap();


$(function() {
    $('a[href*="#"]:not([href="#"]):not([href*="Carousel"])').click(function() {
        if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

    $(".carousel").swiperight(function() {
        $(this).carousel('prev');
    });
    $(".carousel").swipeleft(function() {
        $(this).carousel('next');
    });

    $('#checkIn, #checkOut').datepicker({
        nextText: '',
        prevText: ''
    });

});

$(document).scroll(function(e){
    if($(window).scrollTop() + $('.navbar').height() >= $('#banner').height()){
        $('.nav-wrapper').addClass('opaque');
    }else{
        $('.nav-wrapper').removeClass('opaque');
    }

    $('#banner').css({
        backgroundPositionY: $(window).scrollTop()/3
    });
});

$(document).on('click', '[data-toggle="lightbox"]', function(e){
    e.preventDefault();
    $(this).ekkoLightbox({
        left_arrow_class: '.fa .fa-chevron-left',
        right_arrow_class: '.fa .fa-chevron-right'
    });
});


/* Contact Form */

$(document).ready(function() {
    $("#contact-form").parsley();
    $("#contact-form").on('submit', function(e) {
        var f = $(this);
        f.parsley().validate();
        if (f.parsley().isValid()) {            
            $.ajax({
                url: f.attr('action'),
                data: f.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(response) {                    
                    $("#response").html(response);    
                    $('#response').delay(5000).fadeOut('slow'); 
                }
            });
        } else {
            alert('This form is not valid');
        }

        e.preventDefault();
    });
});

/* End Contact Form */

/** CHANGE LANGUAGE SESSION **/ 
 $(document).ready(function() {
    var $languageSelected = $(".language-select");
    
    $(".dropdown-menu li a").click(function() {        
		var clickedValue = $(this).parent().attr("class");
		var clickedTitle = $(this).find("em").html();
        var url;

        $.ajax({    
            url : "home/language/"+clickedValue,
            type: "POST",            
            success: function(data)
            {      
                window.location.reload();  
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Cannot load '+clickedTitle);
            }
        });
        
	});
            
}); 
/** END LANGUAGE SESSION **/ 
