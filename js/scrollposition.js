var detectionScrollPosition;

(function ($) {

    $(document).ready(function () {



    detectionScrollPosition = function(){detectScroll();};

    var currentHome = false;
	var currentBio = false;
	var currentVideos = false;
	var currentPhotos = false;
	var currentBoutique = false;
	var currentFacebook = false;
	var currentContact = false;
	
	var currentBioImage = false;
	var currentBioImageOut = false;
	var currentFacebookImage = false;
	var currentFacebookImageOut = false;
	var currentContactImage = false;
	var currentContactImageOut = false;
        
	$(window).scroll(function(){
	    detectScroll();
    });

        function detectScroll(){
	    // On ajoute une fonction quand on défile dans le site
		// On récupère la position de la barre de défilement par rapport à notre fenêtre
		var scrollTop = $(window).scrollTop();

        // Deplacement du menu alternatif sur iPad
        var deviceAgent = navigator.userAgent.toLowerCase();
        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
        if (agentID) {
            $("#menu-alternatif").css("top",scrollTop);
        }

		
		/* ----- PARALLAX ----- */		
		
                // HOME
                if(scrollTop >= 0 && scrollTop < 960)
                {
                    if(currentHome == false)
                    {
                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:-55},180);
                        $("#menu-home").find("#rollHome img").css("cursor","default");

                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},200);
                        $(".menu-btn").find(".rollOver").css("cursor","pointer");
                        $(".menu-btn").find(".rollOut").css("cursor","pointer");


                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            // Mouse Over Home
                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            // Mouse Out Home
                            $("#menu-home").mouseleave(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });
                        }

                        currentHome = true;
                        currentBio = false;
                        currentVideos = false;
                        currentPhotos = false;
                        currentBoutique = false;
                        currentFacebook = false;
                        currentContact = false;

                    }
		    
			
		    }
                
                // BIOGRAPHIE
                else if(scrollTop >= 960 && scrollTop < 1960)
                {
			
                    if(currentBio == false){

                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},180);
                        $("#menu-biographie").find(".rollOver").stop().animate({marginTop:-2},180);
                        $("#menu-biographie").find(".rollOver").css("cursor","default");

                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:9},200);
                        $("#menu-home").find("#rollHome img").css("cursor","pointer");



                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });

                            // Mouse Over Biographie
                            $("#menu-biographie").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            $("#menu-home").mouseleave(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:9},200);
                            });

                            // Mouse Out Bio
                            $("#menu-biographie").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });
                        }


                        currentHome = false;
                        currentBio = true;
                        currentVideos = false;
                        currentPhotos = false;
                        currentBoutique = false;
                        currentFacebook = false;
                        currentContact = false;
                    }
			
                }
                
                // VIDEOS
                else if(scrollTop >= 1960 && scrollTop < 2960)
                {	
                    if(currentVideos == false){

                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},180);
                        $("#menu-videos").find(".rollOver").stop().animate({marginTop:-2},180);
                        $("#menu-videos").find(".rollOver").css("cursor","default");

                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:9},200);
                        $("#menu-home").find("#rollHome img").css("cursor","pointer");

                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });

                            // Mouse Over Vidéos
                            $("#menu-videos").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            $("#menu-home").mouseleave(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:9},200);
                            });

                            // Mouse Out Vidéos
                            $("#menu-videos").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });
                        }

                        currentHome = false;
                        currentBio = false;
                        currentVideos = true;
                        currentPhotos = false;
                        currentBoutique = false;
                        currentFacebook = false;
                        currentContact = false;
                    }
		    
                }
                
                // PHOTOS
                else if(scrollTop >= 2960 && scrollTop < 3960)
                {
                    if(currentPhotos == false){
                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},180);
                        $("#menu-photos").find(".rollOver").stop().animate({marginTop:-2},180);
                        $("#menu-photos").find(".rollOver").css("cursor","default");

                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:9},200);
                        $("#menu-home").find("#rollHome img").css("cursor","pointer");

                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });

                            // Mouse Over Photos
                            $("#menu-photos").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            $("#menu-home").mouseleave(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:9},200);
                            });

                            // Mouse Out Photos
                            $("#menu-photos").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });
                        }

                        currentHome = false;
                        currentBio = false;
                        currentVideos = false;
                        currentPhotos = true;
                        currentBoutique = false;
                        currentFacebook = false;
                        currentContact = false;

                    }
                }
                
                // BOUTIQUE
                else if(scrollTop >= 3960 && scrollTop < 4960)
                {
                    if(currentBoutique == false){
                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},180);
                        $("#menu-boutique").find(".rollOver").stop().animate({marginTop:-2},180);
                        $("#menu-boutique").find(".rollOver").css("cursor","default");

                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:9},200);
                        $("#menu-home").find("#rollHome img").css("cursor","pointer");

                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });

                            // Mouse Over boutique
                            $("#menu-boutique").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            $("#menu-home").mouseleave(function(){

                                $(this).find("#rollHome img").stop().animate({marginTop:9},200);

                            });

                            // Mouse Out boutique
                            $("#menu-boutique").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });
                        }

                        currentHome = false;
                        currentBio = false;
                        currentVideos = false;
                        currentPhotos = false;
                        currentBoutique = true;
                        currentFacebook = false;
                        currentContact = false;

                    }
                }
                
                // FACEBOOK
                else if(scrollTop >= 4960 && scrollTop < 5860)
                {
                    if(currentFacebook == false){

                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},180);
                        $("#menu-sina").find(".rollOver").stop().animate({marginTop:-2},180);
                        $("#menu-sina").find(".rollOver").css("cursor","default");

                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:9},200);
                        $("#menu-home").find("#rollHome img").css("cursor","pointer");

                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });

                            // Mouse Over sina
                            $("#menu-sina").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            $("#menu-home").mouseleave(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:9},200);
                            });

                            // Mouse Out sina
                            $("#menu-sina").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });
                        }

                        currentHome = false;
                        currentBio = false;
                        currentVideos = false;
                        currentPhotos = false;
                        currentBoutique = false;
                        currentFacebook = true;
                        currentContact = false;

                    }
                }
                
                // CONTACT
                 else if(scrollTop >= 5860 && scrollTop < 6396)
                {			
                    if(currentContact == false){

                        $(".menu-btn").find(".rollOver").stop().animate({marginTop:0},180);
                        $("#menu-contact").find(".rollOver").stop().animate({marginTop:-2},180);
                        $("#menu-contact").find(".rollOver").css("cursor","default");

                        $("#menu-home").find("#rollHome img").stop().animate({marginTop:9},200);
                        $("#menu-home").find("#rollHome img").css("cursor","pointer");

                        var deviceAgent = navigator.userAgent.toLowerCase();
                        var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
                        if (agentID) {
                        }
                        else
                        {
                            // Mouse Over
                            $(".menu-btn").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-60},200);
                            });

                            $("#menu-home").mouseenter(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:-55},200);
                            });

                            // Mouse Over contact
                            $("#menu-contact").mouseenter(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });


                            // Mouse Out
                            $(".menu-btn").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:0},200);
                            });

                            $("#menu-home").mouseleave(function(){
                                $(this).find("#rollHome img").stop().animate({marginTop:9},200);
                            });

                            // Mouse Out contact
                            $("#menu-contact").mouseleave(function(){
                                $(this).find(".rollOver").stop().animate({marginTop:-2},200);
                            });
                        }

                        currentHome = false;
                        currentBio = false;
                        currentVideos = false;
                        currentPhotos = false;
                        currentBoutique = false;
                        currentFacebook = false;
                        currentContact = true;

                        
                    }

                }
		
		
		/* ----- MODIF TAILLES IMAGES ----- */
		
		if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1))
		{
			// Do nothing
		}
		else
		{		
		
			// BIO
			if(scrollTop >= 960 && scrollTop <1480)
			{
				if(currentBioImage == false)
				{
					// Enter
					$("#image-bio-img").stop().animate({width:443, height:343, marginLeft: 0, marginTop:"50px"}, {duration:800, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginLeft:'easeOutExpo', marginTop:'easeOutExpo' } } );
					
					currentBioImage = true;
					currentBioImageOut = false;
					currentFacebookImage = false;
					currentFacebookImageOut = false;
					currentContactImage = false;					
					currentContactImageOut = false;
				}
			}
			else if(scrollTop < 959 || scrollTop > 1481)
			{
				if(currentBioImage == true && currentBioImageOut == false)
				{
					// Exit
					$("#image-bio-img").stop().animate({width:360, height:360, marginLeft: 91, marginTop:91}, {duration:800, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginLeft:'easeOutExpo', marginTop:'easeOutExpo' } } );
					
					currentBioImage = false;
					currentBioImageOut = true;
					currentFacebookImage = false;
					currentFacebookImageOut = false;
					currentContactImage = false;					
					currentContactImageOut = false;
				}
			}
			
			// FB
			if(scrollTop >= 4782 && scrollTop < 5286)
			{
				if(currentFacebookImage == false)
				{
					// Enter
					$("#sina-image-img").stop().animate({width:396, height:396, marginLeft: 0, marginTop:0}, {duration:800, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginLeft:'easeOutExpo', marginTop:'easeOutExpo' } } );
					
					currentBioImage = false;
					currentBioImageOut = false;
					currentFacebookImage = true;
					currentFacebookImageOut = false;
					currentContactImage = false;					
					currentContactImageOut = false;
				}
			}
			else if(scrollTop >= 5287 || scrollTop <= 4604 )
			{
				if(currentFacebookImage == true && currentFacebookImageOut == false)
				{
					// Exit
					$("#s-image-img").stop().animate({width:262, height:262, marginLeft: 67, marginTop:67}, {duration:800, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginLeft:'easeOutExpo', marginTop:'easeOutExpo' } } );
					
					currentBioImage = false;
					currentBioImageOut = false;
					currentFacebookImage = false;
					currentFacebookImageOut = true;
					currentContactImage = false;					
					currentContactImageOut = false;
				}
			}
			
			// CONTACT
			if(scrollTop >= 5860 && scrollTop <= 6600)
			{
				if(currentContactImage == false)
				{
					// Enter
					$("#contact-img-img").stop().animate({width:452, height:452, marginLeft: 0, marginTop:0}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginLeft:'easeOutExpo', marginTop:'easeOutExpo' } } );
					
					currentBioImage = false;
					currentBioImageOut = false;
					currentFacebookImage = false;
					currentFacebookImageOut = false;
					currentContactImage = true;					
					currentContactImageOut = false;
				}
			}
			else if(scrollTop > 6600 || scrollTop <= 5860)
			{
				if(currentContactImage == true && currentContactImageOut == false)
				{
					// Exit
					$("#contact-img-img").stop().animate({width:300, height:300, marginLeft: 76, marginTop:76}, {duration:800, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginLeft:'easeOutExpo', marginTop:'easeOutExpo' } } );
					
					currentBioImage = false;
					currentBioImageOut = false;
					currentFacebookImage = false;
					currentFacebookImageOut = false;
					currentContactImage = false;					
					currentContactImageOut = true;
				}
			}
			
		}
                


    }


        
     // On lance l'évènement scroll une première fois au chargement de la page
	$(window).scroll();

    }); // End Ready
}(jQuery));