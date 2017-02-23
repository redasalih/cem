jQuery(document).ready(function(){


        // jQuery(".date_timer")
        // .countdown("2016/02/25", function(event) {
        //   jQuery(this).text(
        //     event.strftime('%Dj . %Hh . %Mmin')
        //   );
        // });


        //==>   date to seconde converter  => http://www.timeanddate.com/date/durationresult.html?d1=29&m1=01&y1=2016&d2=25&m2=02&y2=2016&h1=&i1=&s1=&h2=&i2=&s2=
        // var clock = jQuery('.timer_home').FlipClock(1456358400, {
        //     countdown: true
        // });
        var date = new Date("may 26, 2016 09:30:00"); //Month Days, Year HH:MM:SS
        var now = new Date();
        var diff = (date.getTime()/1000) - (now.getTime()/1000);

        var clock = jQuery('.timer_home').FlipClock(diff, {
            clockFace: 'DailyCounter',
            countdown: true,
            language: 'fr',
        });



	    /*
	    ****** =>  afficher le message d'information dans la page je m'inscris
	    */
        var autoHeight = jQuery('.form_contact7 .visible').height();

        salon = '' ;
        codeValide = '' ;
        jQuery('.form_contact7 select#section').on('change', function(){
            selected = jQuery(this).children('option:selected').text();
            if(selected.toLowerCase().indexOf("salon") >= 0){
                jQuery('.form_contact7 .visible').animate({
                    opacity: 1,
                    height: autoHeight
                  }, 500, function() {
                    jQuery('.form_contact7 .visible').css('overflow','hidden');
                  });
                jQuery('.form_contact7 .messageError').css('display','none');
                jQuery('.form_contact7 .redirect').css('display','none');
                salon = "Vide";

            }
            // debut
            //else if(selected.toLowerCase().indexOf("rabat") >= 0){
              //  jQuery('.form_contact7 .visible').animate({
                //    opacity: 1,
                  //  height: autoHeight
                  //}, 500, function() {
                    //jQuery('.form_contact7 .visible').css('overflow','visible');
                  //});
                //jQuery('.form_contact7 .messageError').css('display','none');
               // jQuery('.form_contact7 .redirect').css('display','none');
                //salon = "Rabat";
           // } 
            // fin
            else{
                if(selected.toLowerCase().indexOf("marrakech") >= 0){
                    jQuery('.form_contact7 .messageError').css('display','none');
                    jQuery('.form_contact7 .redirect').css('display','block');
                    salon = "Marrakech";
                } 
                if(selected.toLowerCase().indexOf("fès") >= 0){
                    jQuery('.form_contact7 .messageError').css('display','none');
                    jQuery('.form_contact7 .redirect').css('display','block');
                    salon = "Fès";
                } 
                if(selected.toLowerCase().indexOf("tanger") >= 0){
                    jQuery('.form_contact7 .messageError').css('display','none');
                    jQuery('.form_contact7 .redirect').css('display','block');
                    salon = "Tanger";
                }
                if(selected.toLowerCase().indexOf("rabat") >= 0){
                    jQuery('.form_contact7 .messageError').css('display','none');
                    jQuery('.form_contact7 .redirect').css('display','block');
                    salon = "Rabat";
                }  
                // if(selected.toLowerCase().indexOf("tanger") >= 0){
                //     jQuery('.form_contact7 .messageError').css('display','none');
                //     jQuery('.form_contact7 .redirect').css('display','none');
                //    jQuery('.form_contact7 .messageError.tanger').css('display','block');
                //     salon = "Tanger";
                // } 
                // if(selected.toLowerCase().indexOf("rabat") >= 0){
                //     jQuery('.form_contact7 .messageError').css('display','none');
                //     jQuery('.form_contact7 .redirect').css('display','none');
                //    jQuery('.form_contact7 .messageError.rabat').css('display','block');
                //     salon = "Rabat";
                // } 
                if(selected.toLowerCase().indexOf("casablanca") >= 0){
                    jQuery('.form_contact7 .messageError').css('display','none');
                    jQuery('.form_contact7 .redirect').css('display','none');
                   jQuery('.form_contact7 .messageError.casablanca').css('display','block');
                    salon = "Casablanca";
                }

                jQuery('.form_contact7 .visible').animate({
                    opacity: 0.25,
                    height: "0"
                  }, 500, function() {
                    jQuery('.form_contact7 .visible').css('overflow','hidden');
                });

                // console.log(selected);
            }

            email = jQuery('input#email[name=VAdressEmail]').val();

            // codeValid = sha256_digest(email);
            dataString = "email="+encodeURIComponent(email);
            jQuery.ajax({
                type    : "POST",
                data    : dataString,
                url     : "http://caravaneemploi.com/wp-content/themes/banda_old/pdf/code_valid.php",
                success : function(response){
                    console.log('code valide : '+response);
                    console.log('Email : '+email + ' - Code Valid : ' + response);

                }
            });
            

            jQuery('input#CodeValid').val(email);

            jQuery('input#villesalon').val(salon);
        });



        /***************
        ***   generer le codeValide
        ***************/
        jQuery('input#email[name=VAdressEmail]').on('change', function(){
            email = jQuery(this).val();

            // codeValid = sha256_digest(email);
            dataString = "email="+encodeURIComponent(email);
            jQuery.ajax({
                type    : "POST",
                data    : dataString,
                url     : "http://caravaneemploi.com/wp-content/themes/banda_old/pdf/code_valid.php",
                success : function(response){
                    console.log('code valide : '+response);
                    console.log('Email : '+email + ' - Code Valid : ' + response);
                    jQuery('input#CodeValid').val(response);
                    console.log('code valide 2 : ' + jQuery('input#CodeValid').val());

                }
            });
        });





		/*
		****  ==> ajouter la classe de responsive dans le sidebare right
		*/
		jQuery('.sidebar.col-md-4.right-sidebar').addClass('col-xs-12 col-sm-4');




		/*
		***** ==> supprimer les premier mot des articles dans la page Accueil
		*/
		var text = jQuery('.home content .blog-layout-element section').first().children('p').text();
		var res = text.substring(13);
		jQuery('.home content .blog-layout-element section').first().children('p').text(res);

		var text = jQuery('.home content .blog-layout-element section').last().children('p').text();
		var res = text.substring(17);
		jQuery('.home content .blog-layout-element section').last().children('p').text(res);




        /*
        ****  =>> afficher le formulaire après le chargement des elements de la page 
        */
        jQuery(window).load(function() {
          jQuery('.form_contact7').css('display','block');
        });

        




/*
**** rediriger le candidat vers la page de questionnaire après l'inscription
*/
   /*===    Formulaire inscription      ===*/
        redirect = 0;
        window.setInterval(function(){
            if(jQuery('#wpcf7-f528-p78-o1 .wpcf7-mail-sent-ok').length){
                if(redirect == 0){
                    console.log('redirection');
                    document.location.href="http://caravaneemploi.com/enquete-amaljob-2015/";
                    redirect = 1;
                }
            }
        }, 2000);


    /*===    Formulaire pré-inscription      ===*/
        window.setInterval(function(){
            if(jQuery('#wpcf7-f757-p1549-o1 .wpcf7-mail-sent-ok').length){
                if(redirect == 0){
                    console.log('redirection');
                    document.location.href="http://caravaneemploi.com/enquete-amaljob-2015/";
                    redirect = 1;
                }
            }
        }, 1000);


    /*===    Formulaire inscription sur place     ===*/
        window.setInterval(function(){
            if(jQuery('#wpcf7-f1552-p1470-o1 .wpcf7-mail-sent-ok').length){
                if(redirect == 0){
                    console.log('redirection');
                    jQuery('.form_contact').animate({
                        opacity: 0,
                        height: "0"
                      }, 500, function() {
                        document.location.href="http://caravaneemploi.com/formulaire-pre-enregistrement/";
                        redirect = 1;
                        // jQuery('.form_contact7 .visible').css('overflow','hidden');
                    });
                }
            }
        }, 1000);

        


    /*===========   WHEN IMAGES LOADED  =============*/
    jQuery('body').imagesLoaded( function() {
      // images have loaded
        var style = '\
            <style type="text/css">\
                .sliderHeader {\
                    background-image: url(http://caravaneemploi.com/wp-content/themes/banda_old/images/slider6.jpg);\
                }\
            </style>\
        ';
        setTimeout(function(){
            jQuery('.sliderHeader .content_slider').append(style);
            console.log('images loaded2');
        }, 2000);

    });




});