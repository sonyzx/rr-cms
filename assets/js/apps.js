/* HIDE SHOW LOGIN FORM */
function show_reset_password(){
    $(".login_form").hide();
    $(".resetpassword").show();
}

function show_loginform(){
    $(".login_form").show();
    $(".resetpassword").hide();
}

/* END HIDE SHOW LOGIN FORM */

$(document).ready(function(){  
    
    /* LOGIN FORM  */
    $(".login_form").delay(2000).slideDown();
    $(".resetpassword").hide();
    /* END LOGIN FORM */
    
    /* CONFIGURATION REDACTOR */    
    
    $(function(){
        $('.redactorwysg').redactor();
    });
    /* END CONFIGURATION REDACTOR */
    
    
    /** CHANGE LANGUAGE SESSION **/ 
    $("#form-lang").on('change', 'select', function (e){
        e.preventDefault();        
        var url   = $("#form-lang").attr('action');
        var data  = $("#form-lang").serialize();
        $.ajax({
            url:url,
            type:'POST',
            data:data
        }).done(function (data){
           window.location.reload();                     
        });
    });    
     /** END LANGUAGE SESSION **/      
     
    
     
    $('#form-article')  
        // Add button click heading
        .on('click', '.add-heading', function() {
            var $template1 = $('#opt-heading'),
                $clone    = $template1
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template1),
                $option1   = $clone.find('[name="heading[]"]');

            // Add new field
            $('#form-article').formValidation('addField', $option1);
        })
        
        // Add button click text
        .on('click', '.add-text', function() {
            var $template2 = $('#opt-thetext'),
                $clone    = $template2
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template2),
                $option2   = $clone.find('[name="thetext[]"]');

            // Add new field
            $('#form-article').formValidation('addField', $option2);
        })
        
         // Add button click pull-quote
        .on('click', '.add-pullquote', function() {
            var $template3 = $('#opt-pullquote'),
                $clone    = $template3
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template3),
                $option3   = $clone.find('[name="pullquote[]"]');

            // Add new field
            $('#form-article').formValidation('addField', $option3);
        })

        // Add button click image
        .on('click', '.add-image', function() {
            var $template4 = $('#opt-image'),
                $clone    = $template4
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template4),
                $option4   = $clone.find('[name="image[]"]');

            // Add new field
            $('#form-article').formValidation('addField', $option4);
        })
        
        // Add button click quote
        .on('click', '.add-quote', function() {
            var $template5 = $('#opt-quote'),
                $clone    = $template5
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template5),
                $option5   = $clone.find('[name="image[]"]');

            // Add new field
            $('#form-article').formValidation('addField', $option5);
        })

        // Remove button click heading
        .on('click', '.removeheading', function() {
            var $row    = $(this).parents('.form-group'),
                $option1 = $row.find('[name="heading[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#form-article').formValidation('removeField', $option1);
        })
        
         // Remove button click thetext
        .on('click', '.removethetext', function() {
            var $row    = $(this).parents('.form-group'),
                $option2 = $row.find('[name="removethetext[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#form-article').formValidation('removeField', $option2);
        })
        
        
         // Remove button click removepullquote
        .on('click', '.removepullquote', function() {
            var $row    = $(this).parents('.form-group'),
                $option3 = $row.find('[name="removepullquote[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#form-article').formValidation('removeField', $option3);
        })
        
        
          // Remove button click removeimage
        .on('click', '.removeimage', function() {
            var $row    = $(this).parents('.form-group'),
                $option4 = $row.find('[name="removeimage[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#form-article').formValidation('removeField', $option4);
        })
        
         // Remove button click quote
        .on('click', '.removequote', function() {
            var $row    = $(this).parents('.form-group'),
                $option5 = $row.find('[name="quote[]"]');
            // Remove element containing the option
            $row.remove();
            // Remove field
            $('#form-article').formValidation('removeField', $option5);
        })
        
        $("#form-article")
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title_name: {
                    validators: {
                        notEmpty: {
                            message: 'The title name required and cannot be empty'
                        }
                    }
                },
                shortdesc: {
                    validators: {
                        notEmpty: {
                            message: 'The short description required and cannot be empty'
                        }
                    }
                },
                'heading[]': {
                    validators: {
                        notEmpty: {
                            message: 'The heading required and cannot be empty'
                        },
                        stringLength: {
                            max: 50,
                            message: 'The heading must be less than 50 characters long'
                        }
                    }
                },
                'pullquote[]': {
                    validators: {
                        notEmpty: {
                            message: 'The pull quote required and cannot be empty'
                        },
                        stringLength: {
                            max: 50,
                            message: 'The pull quote must be less than 50 characters long'
                        }
                    }
                },
                'quote[]': {
                    validators: {
                        notEmpty: {
                            message: 'The quote required and cannot be empty'
                        },
                        stringLength: {
                            max: 50,
                            message: 'The quote must be less than 50 characters long'
                        }
                    }
                },
                'thetext[]': {
                    validators: {
                        notEmpty: {
                            message: 'The text required and cannot be empty'
                        },
                        stringLength: {
                            max: 50,
                            message: 'The text must be less than 50 characters long'
                        }
                    }
                }
            }
        }) 
       .submit(function (e){                                                 
            e.preventDefault();     
            $("#response").show();
            var url =$('#form-article').attr('action');
            var data = $('#form-article').serialize();            
            $.ajax({
                url:url,
                type:'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false
            }).done(function (data){
                $("#response").html(data);
                $('#response').delay(5000).fadeOut('slow');
                 window.location.reload();                 
            });
            e.preventDefault();
        });
        
            /** SUBMIT ONE POST ARTICLE */             
            
            $('#onepostarticle').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                     fields: {
                        title_name: {
                            validators: {
                                notEmpty: {
                                    message: 'The title name required and cannot be empty'
                                }
                            }
                        },
                        shortdesc: {
                            validators: {
                                notEmpty: {
                                    message: 'The short description required and cannot be empty'
                                }
                            }
                        }
                    }
                })             
              .on('success.form.bv', function(e) {            
                    e.preventDefault();        
                    $("#response").show();                                               
                    var url = $('#onepostarticle').attr('action');
                    var data = $('#onepostarticle').serialize();                   
                  $.ajax({
                        url:url,
                        type:'POST',                        
                        data: new FormData( this ),
                        processData: false,
                        contentType: false
                    }).done(function (data){                            
                        $("#response").html(data.message);
                        if(data.urlimg != "") $("#previewold").attr("src", data.urlimg);
                        $('#response').delay(5000).fadeOut('slow');                                      
                    });
                    e.preventDefault();
                });
            /** END SUBMIT ONE POST ARTICLE */
            
            
             /** SUBMIT PAGES */             
            
            $('#form-pages').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                     fields: {
                        postTitle: {
                            validators: {
                                notEmpty: {
                                    message: 'The title name required and cannot be empty'
                                }
                            }
                        },
                        postDescription: {
                            validators: {
                                notEmpty: {
                                    message: 'The description required and cannot be empty'
                                }
                            }
                        }
                    }
                })             
              .on('success.form.bv', function(e) {            
                    e.preventDefault();        
                    $("#response").show();                                               
                    var url = $('#form-pages').attr('action');
                    var data = $('form-pages').serialize();                   
                  $.ajax({
                        url:url,
                        type:'POST',                        
                        data: new FormData( this ),
                        processData: false,
                        contentType: false
                    }).done(function (data){                            
                        $("#response").html(data);                        
                        $('#response').delay(5000).fadeOut('slow');                                      
                    });
                    e.preventDefault();
                });
            /** END SUBMIT PAGES */
        
    
            /** SUBMIT MAP */             
            
            $('#frmmap').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                     fields: {
                        longitude: {
                            validators: {
                                notEmpty: {
                                    message: 'The longitude required and cannot be empty'
                                }
                            }
                        },
                        latitude: {
                            validators: {
                                notEmpty: {
                                    message: 'The latitude required and cannot be empty'
                                }
                            }
                        }
                    }
                })             
              .on('success.form.bv', function(e) {            
                    e.preventDefault();        
                    $("#response").show();                                               
                    var url = $('#frmmap').attr('action');
                    var data = $('#frmmap').serialize();                   
                  $.ajax({
                        url:url,
                        type:'POST',                        
                        data: new FormData( this ),
                        processData: false,
                        contentType: false
                    }).done(function (data){                            
                        $("#response").html(data);                        
                        $('#response').delay(5000).fadeOut('slow');                                      
                    });
                    e.preventDefault();
                });
            /** END SUBMIT MAP */
    
    
             /** VALIDATION FORM FOOTER CONTENT **/
            // Add button click heading
            $('#frm-footercontent').on('click', '.add-heading', function() {
                    var $template1 = $('#opt-heading'),
                        $clone    = $template1
                                        .clone()
                                        .removeClass('hide')
                                        .removeAttr('id')
                                        .insertBefore($template1),
                        $option1   = $clone.find('[name="heading[]"]');

                    // Add new field
                    $('#frm-footercontent').formValidation('addField', $option1);
              });
                // Remove button click heading
              $('#frm-footercontent').on('click', '.removeheading', function() {
                  var $row    = $(this).parents('.form-group'),
                      $option1 = $row.find('[name="heading[]"]');
                  // Remove element containing the option
                  $row.remove();
                  // Remove field
                  $('#frm-footercontent').formValidation('removeField', $option1);
              });
          
           $('#frm-footercontent').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    titlesite: {
                        validators: {
                            notEmpty: {
                                message: 'The website title is required and cannot be empty'
                            },
                            stringLength: {                                
                                max: 50,
                                message: 'The website title mus less than 50 characters long'
                            }
                        }
                    },
                    metadata: {                     
                        validators: {
                            notEmpty: {
                                message: 'The metadata is required and cannot be empty'
                            }
                        }
                    },
                    copyright: {                     
                        validators: {
                            notEmpty: {
                                message: 'The copyright is required and cannot be empty'
                            }
                        }
                    },
                    contactUs: {
                        validators: {
                            notEmpty: {
                                message: 'The contact Us is required and cannot be empty'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'The email is required and cannot be empty'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {
                // Prevent submit form
                e.preventDefault();
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data: new FormData( this ),
                    processData: false,
                    contentType: false
                }).done(function (data){
                    $("#response").html(data.message);  
                    if(data.urlimg != "") $("#previewlogo").attr("src", data.urlimg);                       
                    $('#response').delay(5000).fadeOut('slow');
                });
            });
               
           /** END SAVE GLOBAL FORM **/
            
           /** VALIDATION ROOM LIST FORM */ 
           // Add button click url images
            $('#form-rooms').on('click', '.add-urllink', function() {
                    var $template1 = $('#opt-heading'),
                        $clone    = $template1
                                        .clone()
                                        .removeClass('hide')
                                        .removeAttr('id')
                                        .insertBefore($template1),
                        $option1   = $clone.find('[name="urlimages[]"]');

                    // Add new field
                    $('#form-rooms').formValidation('addField', $option1);
             });
                // Remove button click heading
            $('#form-rooms').on('click', '.removeheading', function() {
                  var $row    = $(this).parents('.form-group'),
                      $option1 = $row.find('[name="urlimages[]"]');
                  // Remove element containing the option
                  $row.remove();
                  // Remove field
                  $('#form-rooms').formValidation('removeField', $option1);
            });
          
           $('#form-rooms').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    roomnames: {
                        validators: {
                            notEmpty: {
                                message: 'The room name is required and cannot be empty'
                            },
                            stringLength: {                                
                                max: 50,
                                message: 'The room name must less than 50 characters long'
                            }
                        }
                    },
                    hotelid: {                     
                        validators: {
                            notEmpty: {
                                message: 'The hotel is required and cannot be empty'
                            }
                        }
                    },
                    short_description: {                     
                        validators: {
                            notEmpty: {
                                message: 'The short description is required and cannot be empty'
                            }
                        }
                    },
                    main_description: {                     
                        validators: {
                            notEmpty: {
                                message: 'The main description is required and cannot be empty'
                            }
                        }
                    },
                    colours: {
                        validators: {
                            notEmpty: {
                                message: 'The colours is required and cannot be empty'
                            }
                        }
                    },
                    hourly_rate: {
                        validators: {
                            notEmpty: {
                                message: 'The hourly rate is required and cannot be empty'
                            }
                        }
                    },
                    mon: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    tue: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    wed: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    thu: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    fri: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    sat: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    sun: {
                        validators: {
                            notEmpty: {
                                message: 'This is required and cannot be empty'
                            }
                        }
                    },
                    widget_footer: {
                        validators: {
                            notEmpty: {
                                message: 'The widget footer is required and cannot be empty'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {                
                // Prevent submit form
                e.preventDefault(); 
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data: new FormData( this ),
                    processData: false,
                    contentType: false
                }).done(function (data){
                    $("#response").html(data);                         
                    $('#response').delay(5000).fadeOut('slow');
                });
            });
               
           /** END VALIDATION ROOM LIST FORM */
            
            
            /** VALIDATION BLOCK CONFIGURATION **/
           $('#createblock').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    blocktype: {                     
                        validators: {
                            notEmpty: {
                                message: 'The block type is required and cannot be empty'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {                
                e.preventDefault();         
                $("#response").hide();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                var dataTable = $('#listblock').dataTable(); 
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){
                    $("#response").show();
                    $("#response").html(data);    
                    dataTable.fnDraw();
                    $('#response').delay(5000).fadeOut('slow'); 
                });
            });
               
           /** END SAVE GLOBAL FORM **/ 
            
           /** VALIDATION FORM AWS CONFIG **/
           $('#formawsconfig').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    key: {                        
                        validators: {
                            notEmpty: {
                                message: 'The key is required and cannot be empty'
                            }
                        }
                    },
                    secret: {
                        validators: {
                            notEmpty: {
                                message: 'The secret is required and cannot be empty'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {                
                e.preventDefault();      
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){
                    $("#response").html(data);
                    $('#response').delay(5000).fadeOut('slow');                  
                });
            });
            
             $('#reset-aws').click(function() {
                $('#formawsconfig').data('bootstrapValidator').resetForm(true);
            }); 
            
            /** END AWS CONFIG */
            
           /** VALIDATION BUCKET CONFIGURATION **/
           $('#frmaddbucket').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    bucketname: {                     
                        validators: {
                            notEmpty: {
                                message: 'The bucket name is required and cannot be empty'
                            }
                        }
                    },
                     blocktype: {                     
                        validators: {
                            notEmpty: {
                                message: 'The block type is required and cannot be empty'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {                
                e.preventDefault();   
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                var dataTable = $('#listbucket').dataTable(); 
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){
                    $("#response").html(data);    
                    $('#response').delay(5000).fadeOut('slow'); 
                    dataTable.fnDraw();                    
                });
            });
               
           /** END SAVE GLOBAL FORM **/ 
            
           
            
             /** VALIDATION HOTEL FORM **/
           $('#form-hotels').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    hotel_name: {                     
                        validators: {
                            notEmpty: {
                                message: 'The hotel name is required and cannot be empty'
                            }
                        }
                    },
                     slug: {                     
                        validators: {
                            notEmpty: {
                                message: 'The slug is required and cannot be empty'
                            }
                        }
                    },
                    shortdesc: {                     
                        validators: {
                            notEmpty: {
                                message: 'The short description is required and cannot be empty'
                            }
                        }
                    },
                    maindesc: {                     
                        validators: {
                            notEmpty: {
                                message: 'The main description is required and cannot be empty'
                            }
                        }
                    },
                    ownerid: {                     
                        validators: {
                            notEmpty: {
                                message: 'The owner is required and cannot be empty'
                            }
                        }
                    },
                    businesname: {                     
                        validators: {
                            notEmpty: {
                                message: 'The busines name is required and cannot be empty'
                            }
                        }
                    },
                    businessnumber: {                     
                        validators: {
                            notEmpty: {
                                message: 'The business number is required and cannot be empty'
                            }
                        }
                    },
                    street1: {                     
                        validators: {
                            notEmpty: {
                                message: 'The street is required and cannot be empty'
                            }
                        }
                    },
                    state: {                     
                        validators: {
                            notEmpty: {
                                message: 'The state is required and cannot be empty'
                            }
                        }
                    },
                    postcode: {                     
                        validators: {
                            notEmpty: {
                                message: 'The post code is required and cannot be empty'
                            }
                        },
                        stringLength: {
                            min: 5,
                            max: 6,
                            message: 'The post code must be more than 5 and less than 6 characters long'
                        }
                    },
                    country: {                     
                        validators: {
                            notEmpty: {
                                message: 'The state is required and cannot be empty'
                            }
                        }
                    },
                    phone1: {                     
                        validators: {
                            notEmpty: {
                                message: 'The phone number is required and cannot be empty'
                            }
                        }
                    },
                    email1: {                     
                        validators: {
                            notEmpty: {
                                message: 'The email is required and cannot be empty'
                            }, 
                            emailAddress: {
                                message: 'The input is not a valid email address'
                            }
                        }
                    },
                     email2: {                     
                        validators: {                          
                            emailAddress: {
                                message: 'The input is not a valid email address'
                            }
                        }
                    },
                    tra: {                     
                        validators: {
                            notEmpty: {
                                message: 'The total room active is required and cannot be empty'
                            }
                        }
                    },
                    roomtotal: {                     
                        validators: {
                            notEmpty: {
                                message: 'The room total is required and cannot be empty'
                            }
                        }
                    },
                    timezone: {                     
                        validators: {
                            notEmpty: {
                                message: 'The time zone is required and cannot be empty'
                            }
                        }
                    },
                    deposit: {                     
                        validators: {
                            notEmpty: {
                                message: 'The deposit is required and cannot be empty'
                            }
                        }
                    },
                    currency: {                     
                        validators: {
                            notEmpty: {
                                message: 'The currency is required and cannot be empty'
                            }
                        }
                    }
                    
                }
            }).on('success.form.bv', function(e) {            
                e.preventDefault();  
                $("#response").show();
                var url   = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data: new FormData(this ),
                    processData: false,
                    contentType: false
                }).done(function (data){
                    if(data.logourl != "") $("#logoimg").attr("src", data.logourl);
                    if(data.featureurl != "") $("#featureimages").attr("src", data.featureurl);
                    $("#response").html(data.message);
                    $('#response').delay(5000).fadeOut('slow');
                });
            });
            
            $('#reset-hotel').click(function() {
                $('#form-hotels').data('bootstrapValidator').resetForm(true);
            }); 
           
            
            /* END HOTEL FORM */
          
           
           /** VALIDATION TESTIMONIAL FORM **/
           $('#form-testimonial').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    postTitle: {                     
                        validators: {
                            notEmpty: {
                                message: 'The guest say is required and cannot be empty'
                            }
                        }
                    },
                     postDescription: {                     
                        validators: {
                            notEmpty: {
                                message: 'The testimonial is required and cannot be empty'
                            }
                        }
                    },
                    postHeading: {                     
                        validators: {
                            notEmpty: {
                                message: 'The guest name is required and cannot be empty'
                            }
                        }
                    } 
                }
            }).on('success.form.bv', function(e) {            
                e.preventDefault();  
                $("#response").show();
                var url   = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data: new FormData(this ),
                    processData: false,
                    contentType: false
                }).done(function (data){
                    if(data.logourl != "") $("#logoimg").attr("src", data.logourl);                    
                    $("#response").html(data.message);
                    $('#response').delay(5000).fadeOut('slow');
                });
            });
            
            $('#reset-hotel').click(function() {
                $('#form-hotels').data('bootstrapValidator').resetForm(true);
            }); 
           
            
            /* END TESTIMONIAL FORM */           
          
          
           /** VALIDATION FORM ADD BUCKET **/
           $('#frmaddbucket').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    bucketname : {                        
                        validators: {
                            notEmpty: {
                                message: 'The bucket name is required and cannot be empty'
                            }
                        }
                    }
                }
            }); 
            
            
            /** VALIDATION FORM PROFILE INFORMATION **/
            
           $('#profileinfo').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    firstname: {                     
                        validators: {
                            notEmpty: {
                                message: 'The first name is required and cannot be empty'
                            }
                        }
                    },
                    phonenumber: {                     
                        validators: {
                            notEmpty: {
                                message: 'The phone number is required and cannot be empty'
                            }
                        }
                    },
                    address: {                     
                        validators: {
                            notEmpty: {
                                message: 'The address is required and cannot be empty'
                            }
                        }
                    },
                    city: {
                        validators: {
                            notEmpty: {
                                message: 'The city is required and cannot be empty'
                            }
                        }
                    },
                    state: {
                        validators: {
                            notEmpty: {
                                message: 'The state is required and cannot be empty'
                            }
                        }
                    },
                    zip: {
                        validators: {
                            notEmpty: {
                                message: 'The zip is required and cannot be empty'
                            },
                            stringLength: {
                                min: 5,
                                max: 6,
                                message: 'The zip code must be more than 5 and less than 6 characters long'
                            }
                        }
                    },
                    about: {
                        validators: {
                            notEmpty: {
                                message: 'The about is required and cannot be empty'
                            }
                        }
                    }
                    
                }
            }).on('success.form.bv', function(e) {                             
                e.preventDefault();     
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){
                    $("#response").html(data);
                    $('#response').delay(5000).fadeOut('slow');                                    
                });
            });
            $('#reset-profileinfo').click(function() {
                $('#profileinfo').data('bootstrapValidator').resetForm(true);
            }); 
                
               
           /** END PROFIL INFO FORM **/ 
            
           /** SAVE PROFILE PICTURE FORM **/
            $('#pictureprofile').submit(function (e){
                e.preventDefault();   
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data: new FormData( this ),
                    processData: false,
                    contentType: false
                }).done(function (data){                    
                    if(data.urlavatar != "") $("#avatarprofile").attr("src", data.urlavatar);
                    if(data.urlavatar != "") $("#avatartop").attr("src", data.urlavatar);
                    $("#response").html(data.message);                     
                    $('#response').delay(5000).fadeOut('slow');                    
                });
            });
                          
               
           /** END SAVE PROFILE PICTURE FORM **/ 
           
           
            /** VALIDATION UPDATE PASSWORD **/
            
           $('#changepassword').bootstrapValidator({                
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    oldpassword: {                     
                        validators: {
                            notEmpty: {
                                message: 'The old password is required and cannot be empty'
                            }
                        }
                    },
                    newpassword: {                     
                        validators: {
                            notEmpty: {
                                message: 'The new password is required and cannot be empty'
                            },
                            stringLength: {
                                min: 8,
                                max: 30,
                                message: 'The password must be more than 8 and less than 30 characters long'
                            }
                        },
                        identical: {
                            field: 'retypepassword',
                            message: 'The password and its confirm are not the same'
                        },
                    },
                    retypepassword: {                     
                        validators: {
                            notEmpty: {
                                message: 'The retype password is required and cannot be empty'
                            },
                            identical: {
                                field: 'newpassword',
                                message: 'The password and its confirm are not the same'
                            }, 
                        }
                    }
                    
                }
            }).on('success.form.bv', function(e) {                             
                e.preventDefault();      
                $("#response").show();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){
                    $("#response").html(data);   
                    $('#response').delay(5000).fadeOut('slow');                                  
                });
            });
            
            $('#reset-updatepassword').click(function() {
                $('#changepassword').data('bootstrapValidator').resetForm(true);
            });
          
           /** END VALIDATION UPDATE PASSWORD **/
            
          /** LOGIN USER **/           
           $('#loginfrm').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {                        
                        validators: {
                            notEmpty: {
                                message: 'The email or username is required and cannot be empty'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required and cannot be empty'
                            }
                        }
                    }
                }
            }).on('success.form.bv', function(e) {                
                e.preventDefault();      
                $("#response").hide();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){
                    if(data.ok == 0){
                        $("#response").show();
                        $("#response").html(data.msg);
                        $('#response').delay(5000).fadeOut('slow');                  
                    }else{                    
                        window.location.href = 'main';
                    }
                });
            });
          /** END LOGIN USER **/
          
          /** RESET PASSWORD **/           
           $('#resetpass').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {                        
                        validators: {
                            notEmpty: {
                                message: 'The email or username is required and cannot be empty'
                            },                             
                            emailAddress: {
                                message: 'The input is not a valid email address'
                            }
                        }
                    }                   
                }
            }).on('success.form.bv', function(e) {                
                e.preventDefault();      
                $("#response").hide();
                var url = $(this).attr('action');
                var data = $(this).serialize();
                $.ajax({
                    url:url,
                    type:'POST',
                    data:data
                }).done(function (data){                   
                    $("#response").show();
                    $("#response").html(data);                                                    
                });
            });
          /** END RESET PASSWORD **/
          
            
	/** SIDEBAR FUNCTION **/
	$('.sidebar-left ul.sidebar-menu li a').click(function() {
		"use strict";
		$('.sidebar-left li').removeClass('active');
		$(this).closest('li').addClass('active');	
		var checkElement = $(this).next();
			if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
				$(this).closest('li').removeClass('active');
				checkElement.slideUp('fast');
			}
			if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
				$('.sidebar-left ul.sidebar-menu ul:visible').slideUp('fast');
				checkElement.slideDown('fast');
			}
			if($(this).closest('li').find('ul').children().length == 0) {
				return true;
				} else {
				return false;	
			}		
	});

	if ($(window).width() < 1025) {
		$(".sidebar-left").removeClass("sidebar-nicescroller");
		$(".sidebar-right").removeClass("right-sidebar-nicescroller");
		$(".nav-dropdown-content").removeClass("scroll-nav-dropdown");
	}
	/** END SIDEBAR FUNCTION **/
	
	
	/** BUTTON TOGGLE FUNCTION **/
	$(".btn-collapse-sidebar-left").click(function(){
		"use strict";
		$(".top-navbar").toggleClass("toggle");
		$(".sidebar-left").toggleClass("toggle");
		$(".page-content").toggleClass("toggle");
		$(".icon-dinamic").toggleClass("rotate-180");
		
		if ($(window).width() > 991) {
			if($(".sidebar-right").hasClass("toggle-left") === true){
				$(".sidebar-right").removeClass("toggle-left");
				$(".top-navbar").removeClass("toggle-left");
				$(".page-content").removeClass("toggle-left");
				$(".sidebar-left").removeClass("toggle-left");
				if($(".sidebar-left").hasClass("toggle") === true){
					$(".sidebar-left").removeClass("toggle");
				}
				if($(".page-content").hasClass("toggle") === true){
					$(".page-content").removeClass("toggle");
				}
			}
		}
	});
	$(".btn-collapse-sidebar-right").click(function(){
		"use strict";
		$(".top-navbar").toggleClass("toggle-left");
		$(".sidebar-left").toggleClass("toggle-left");
		$(".sidebar-right").toggleClass("toggle-left");
		$(".page-content").toggleClass("toggle-left");
	});
	$(".btn-collapse-nav").click(function(){
		"use strict";
		$(".icon-plus").toggleClass("rotate-45");
	});
	/** END BUTTON TOGGLE FUNCTION **/
	
	/** BEGIN BACK TO TOP **/
	$(function () {
		$("#back-top").hide();
	});
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
	/** END BACK TO TOP **/
	
	
	/** BEGIN PANEL HEADER BUTTON COLLAPSE **/
	$(function () {
		"use strict";
		$('.collapse').on('show.bs.collapse', function() {
			var id = $(this).attr('id');
			$('button.to-collapse[data-target="#' + id + '"]').html('<i class="fa fa-chevron-up"></i>');
		});
		$('.collapse').on('hide.bs.collapse', function() {
			var id = $(this).attr('id');
			$('button.to-collapse[data-target="#' + id + '"]').html('<i class="fa fa-chevron-down"></i>');
		});
		
		$('.collapse').on('show.bs.collapse', function() {
			var id = $(this).attr('id');
			$('a.block-collapse[href="#' + id + '"] span.right-icon').html('<i class="glyphicon glyphicon-minus icon-collapse"></i>');
		});
		$('.collapse').on('hide.bs.collapse', function() {
			var id = $(this).attr('id');
			$('a.block-collapse[href="#' + id + '"] span.right-icon').html('<i class="glyphicon glyphicon-plus icon-collapse"></i>');
		});
	});
	/** END PANEL HEADER BUTTON COLLAPSE **/
	
	
	
	
	/** BEGIN DATATABLE EXAMPLE **/
	if ($('#datatable-example').length > 0){
		$('#datatable-example').dataTable();
	}
	
	
         /** BEGIN SWITCH STYLER */
         $('#style-switch').animate({right:-212});		
         $('#switch-open').animate({right:0});
         var selector = 1;
         $('#switch-open').click(function(){										
            if (selector == 1) {	
             $('#style-switch').animate({right:0});		
             $('#switch-open').animate({right:212});	            	
                   selector = 0;	
               }
           else {		
               $('#style-switch').animate({right:-212});		
               $('#switch-open').animate({right:0});		
               selector = 1;
           }		
        });
         /** END SWITCH STYLER */
	
});