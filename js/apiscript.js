

$(document).ready(function(){
		
		resizefenetre();
		
		formValidate();
		
		contactSuccess();


        openVideos();
		
		
		// LOADING
		var width = $(window).width();
		//$('#percent').css({'margin-top':443});  /* (height/2)+100 */
		$('#percent').css({'margin-left':(width/2)-10});  /* (height/2)+100 */				
		//$('body').css({'overflow-y':'hidden'});		
		var loadingValue = 0;
		
		changeValueLoading();
		var _height = 396;
		var _width = 396;
		function changeValueLoading()
		{		
				setTimeout(function(){
						
						if (loadingValue<=100)
						{						
								$("#percent").text(loadingValue + "%");
								
								loadingValue = loadingValue + 1;
								_width +=1;
								_height +=1;
								$('#loader img,#chargement_ctn').css({'width':_width,'height':_height});
								$('#chargement_ctn').css({'left':($(window).width()-($('#chargement_ctn').width() + 2))/2});
								
								changeValueLoading();					
						}						
						else
						{
								quitLoading();
								bienvenue();								
						}
						
				}, 61)
				
		}
		
		function quitLoading(){
				
				$('body').scrollTo(0);
				
				$('#loader').stop().animate({opacity:0}, 600);
				
				setTimeout(function(){
						
						$('#loader').stop().hide();
						
				}, 1000)
				
				//$('body').css({'overflow-y':'visible'});
				
		}
		
		
		
		$(window).resize(function() {
				resizefenetre();				  
		})
		
		if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1))
		{
				$('#btnDownHome').css({'margin-top':'-21px'});
				$('#btnDownBiographie').css({'margin-top':'-150px'});
				$('#btnDownVideos').css({'margin-top':'-150px'});
				$('#btnDownPhotos').css({'margin-top':'-150px'});
				$('#btnDownBiographie').css({'margin-top':'-150px'});
				$('#btnDownBoutique').css({'margin-top':'-150px'});
				$('#btnDownFacebook').css({'margin-top':'-150px'});
				$('#btnDownContact').css({'margin-top':'-150px'});

                $('#menu-alternatif').show();
		}
		else{
				
				initBtnBack();
				
				initBtnPhotos();
				
				initBtnAcheter();
				
				initBtnContact();
		
		}
		 
		scrollingParallax();		
		
		$.localScroll();

        $("#slides-video").slides({
            slideEasing: "easeOutExpo",
            slideSpeed: 500,
            preload:true
        });
		
		$("#slides").slides({
			slideEasing: "easeOutExpo",
			slideSpeed: 500,
			preload:true
		});


        var widthPaginationVideos = $("#slides-video").find('.pagination').width();
        $("#slides-video").find('.pagination').css({marginLeft: -(widthPaginationVideos/2)});

        var widthPaginationPhotos = $("#slides").find('.pagination').width();
        $("#slides").find('.pagination').css({marginLeft: -(widthPaginationPhotos/2)});

		
		
		$('#textBio').jScrollPane(
			{
				showArrows: true,
				arrowScrollOnHover: true
			}
		);
		
	$('#chargement_ctn').css({'left':($(window).width()-$('#chargement_ctn').width())/2});
		
});
function gotomainsite(){
	window.location="/chc/";
}
function bienvenue(){
	// animation des trois blocs de la home page
	var _duration = 1000;
	var _easing = 'easeOutQuad';
		$('#welcome h2:first').animate({'margin-left':0}, {
		  duration: _duration,
		  step: function(now, fx){
			if(now>-200 && now<0){
				$('#welcome h3').animate({'margin-left':'120px'}, {
				  duration: _duration,
				  step: function(now, fx){
					if(now>-200 && now<0){
						$('#welcome h2#welcome-officiel').animate({'margin-left':'-55px'}, {
						  duration: _duration,easing:_easing});
						 
					}
				  },easing:_easing});
			}
		  },easing:_easing});
	
}
function resizefenetre(){
	
	var navwidth =400;
	var lemarginleft = ($(window).width()/2)-navwidth-116/2;
	//alert(navwidth/2);
	$("nav").css("marginLeft",lemarginleft);
    $("#menu-alternatif").css("marginLeft",lemarginleft);
	if(navwidth+$(window).width()/2>$(window).width()){
		$("nav").width($(window).width()-(navwidth+$(window).width()/2));
	}
	
}

function formValidate(){
		
		var valueNom;
		var valueEmail;
		var valueSujet;
		var valueMessage;
		
		// FOCUS IN		
		$("input#nom").focusin(function(){				
				$("#label-nom").stop().animate({opacity:0},600);
				$("#label-nom").hide();
		});
		
		$("input#email").focusin(function(){			
				$("#label-email").stop().animate({opacity:0},600);
				$("#label-email").hide();
		});
		
		$("input#sujet").focusin(function(){			
				$("#label-sujet").stop().animate({opacity:0},600);
				$("#label-sujet").hide();
		});
		
		$("textarea#message").focusin(function(){			
				$("#label-message").stop().animate({opacity:0},600);
				$("#label-message").hide();
		});		
		
		
		// FOCUS OUT
		$("input#nom").focusout(function(){						
				
				valueNom = $("input#nom").val();		
				//console.log("Nom : " +valueNom);						
						
				if(valueNom == ''){
						
						$("#label-nom").show();
						$("#label-nom").stop().animate({opacity:1},600);
						
				}				
		});
		
		$("input#email").focusout(function(){						
				
				valueEmail = $("input#email").val();						
						
				if(valueEmail == ''){
						
						$("#label-email").show();
						$("#label-email").stop().animate({opacity:1},600);
						
				}				
		});
		
		$("input#sujet").focusout(function(){						
				
				valueSujet = $("input#sujet").val();						
						
				if(valueSujet == ''){
						
						$("#label-sujet").show();
						$("#label-sujet").stop().animate({opacity:1},600);
						
				}				
		});
		
		$("textarea#message").focusout(function(){						
				
				valueMessage = $("textarea#message").val();						
						
				if(valueMessage == ''){
						
						$("#label-message").show();
						$("#label-message").stop().animate({opacity:1},600);
						
				}				
		});
		
		
		
		$("#formulaire-contact").validate({
		  messages: {
		    required:'Ce champ est obligatoire',
		    nom: {
		      required: 'Ce champ est obligatoire'
		    },
		    email: {
		      required: 'Ce champ est obligatoire',
		      email: 'Veuillez entrez une adresse e-mail valide'
		    },
		    sujet: {
		      required: 'Ce champ est obligatoire'
		    },
		    message: {
		      required: 'Ce champ est obligatoire'
		    }
		  }		
		});   
	
}


function getQueryVariable(variable){
				var query = window.location.search.substring(1);
				var vars = query.split("&");
				for (var i=0;i<vars.length;i++) {
				  var pair = vars[i].split("=");
				  if (pair[0] == variable) {
				    return pair[1];
				  }
				}
				//alert('Query Variable ' + variable + ' not found');
			      } 

function contactSuccess(){
		if (getQueryVariable("contact") == "success")
		{
				
		//Faire apparaitre la pop-up et ajouter le bouton de fermeture
		$("#popup_name").fadeIn().css({
			'width': Number("500")
		})
		.append('<a href="index.html" class="close"><img src="img/close_pop.png" class="btn_close" title="Fermer" alt="Fermer" /></a>');
	
		//R�cup�ration du margin, qui permettra de centrer la fen�tre - on ajuste de 80px en conformit� avec le CSS
		var popMargTop = ($("#popup_name").height() + 80) / 2;
		var popMargLeft = ($("#popup_name").width() + 80) / 2;
	
		//On affecte le margin
		$("#popup_name").css({
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
	
		//Effet fade-in du fond opaque
		$('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
		//Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
	
		return false;
		}
			
			
		//Fermeture de la pop-up et du fond
		$('a.close, #fade').live('click', function() { //Au clic sur le bouton ou sur le calque...
			$('#fade , .popup_block').fadeOut(function() {
				$('#fade, a.close').remove();  //...ils disparaissent ensemble
			});
			return false;
		});
		
}

function openVideos(){
    $("#slides-video .slides_container .img-vid").click(function(){
        var idVideoClique = $(this).attr('id');
        var contenuVideo;

        switch(idVideoClique)
        {
            case "img-vid-it-is-time-to-dream":
                contenuVideo = '<iframe width="674" height="373" src="/v/index.php?vid=1" frameborder="0" allowfullscreen></iframe>';
            break;
        }



        //Faire apparaitre la pop-up et ajouter le bouton de fermeture
        $("#popup_video").fadeIn().css({
            'width': Number("674")
        })
            .append('<div class="close-popup"><div class="cross-close-popup"></div></div>')
            .append('<div class="cont_video">'+contenuVideo+'</div>');


        //.append('<a href="#" class="close"><img src="images/cross-close-slider.png" class="btn_close" title="Fermer" alt="Fermer" /></a>');

        //Recuperation du margin, qui permettra de centrer la fenetre - on ajuste de 80px en conformite avec le CSS
        var popMargTop = ($("#popup_video").height() + 30) / 2;
        var popMargLeft = ($("#popup_video").width()) / 2;

        //On affecte le margin
        $("#popup_video").css({
            'margin-top' : -popMargTop,
            'margin-left' : (-popMargLeft)-3
        });

        //Effet fade-in du fond opaque
        $('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
        //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
        $('#fade').css({'filter' : 'alpha(opacity=90)'}).fadeIn();

        $(".close-popup").click(function() {
            $(".cont_video").remove();
            $('#fade , #popup_video, .cont_video').fadeOut(function() {
                $('#fade, .close-popup, .titrePopUp' ).remove();  //...ils disparaissent ensemble
            });
            return false;
        });

        $("#fade").click(function() {
            $(".cont_video").remove();
            $('#fade , #popup_video, .cont_video').fadeOut(function() {
                $('#fade, .close-popup, .titrePopUp' ).remove();  //...ils disparaissent ensemble
            });
            return false;
        });

    });
}


function initBtnBack(){
		
		$(".btn_btnBack").mouseenter(function(){
				$(this).find("img").stop().animate({marginTop:-120},180);
		});
		
		$(".btn_btnBack").mouseleave(function(){
				$(this).find("img").stop().animate({marginTop:0},180);
		});
		
		
}


function initBtnPhotos(){

        // VIDEOS
        $(".rollbtnPrevVideo").mouseenter(function(){
            $(".rollbtnPrevVideo").find("img").stop().animate({marginLeft:0}, 180);
            $(".btnPrevVideo").stop().animate({borderColor: "#c7c7c7"}, 180);
        });

        $(".rollbtnPrevVideo").mouseleave(function(){
            $(".rollbtnPrevVideo").find("img").stop().animate({marginLeft:-63}, 180);
            $(".btnPrevVideo").stop().animate({borderColor: "#fff"},180);
        });


        $(".rollbtnNextVideo").mouseenter(function(){
            $(".rollbtnNextVideo").find("img").stop().animate({marginLeft:-63}, 180);
            $(".btnNextVideo").stop().animate({borderColor: "#c7c7c7"},180);
        });

        $(".rollbtnNextVideo").mouseleave(function(){
            $(".rollbtnNextVideo").find("img").stop().animate({marginLeft:0}, 180);
            $(".btnNextVideo").stop().animate({borderColor: "#fff"},180);
        });






        // PHOTOS
        $(".rollbtnPrevPhoto").mouseenter(function(){
				$(".rollbtnPrevPhoto").find("img").stop().animate({marginLeft:0}, 180);
				$(".btnPrevPhoto").stop().animate({borderColor: "#c7c7c7"}, 180);
		});
		
		$(".rollbtnPrevPhoto").mouseleave(function(){
				$(".rollbtnPrevPhoto").find("img").stop().animate({marginLeft:-63}, 180);				
				$(".btnPrevPhoto").stop().animate({borderColor: "#fff"},180);
		});
		
		
		
		$(".rollbtnNextPhoto").mouseenter(function(){
				$(".rollbtnNextPhoto").find("img").stop().animate({marginLeft:-63}, 180);
				$(".btnNextPhoto").stop().animate({borderColor: "#c7c7c7"},180);
		});
		
		$(".rollbtnNextPhoto").mouseleave(function(){
				$(".rollbtnNextPhoto").find("img").stop().animate({marginLeft:0}, 180);
				$(".btnNextPhoto").stop().animate({borderColor: "#fff"},180);
		});	
		
		
}


function initBtnAcheter(){
		
		$("#btn-acheter").mouseenter(function(){
				$("#submitAchat").stop().animate({marginTop:-22},180);
		});
		
		$("#btn-acheter").mouseleave(function(){
				$("#submitAchat").stop().animate({marginTop:0},180);
		});
		
		
}

function initBtnContact(){
		
		$("#submitContact").mouseenter(function(){
				$("#rollSubmitContact").stop().animate({marginTop:-38},180);
		});
		
		$("#submitContact").mouseleave(function(){
				$("#rollSubmitContact").stop().animate({marginTop:-6},180);
		});		
		
}


function scrollingParallax(){
		
		
  		 if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)) {
				
				// BIO
				$("#contBio").addClass("contBioIpad");
				$("#imageBio").addClass("imageBioIpad");
				
				
				// VIDEO
				$("#lecteurvid").addClass("lecteurvidIpad");
				$("#launchVideo").addClass("launchVideoIpad");
				$("#textVid").addClass("textVidIpad");
				
				
				// PHOTOS
				$("#slides").addClass("slidesIpad");
				$("#launchVideo").addClass("launchVideoIpad");
				$("#textVid").addClass("textVidIpad");
				
				
				// BOUTIQUE
				$("#album").addClass("albumIpad");
				$("#telechargement").addClass("telechargementIpad");
				$("#commande").addClass("commandeIpad");
				$("#btn-acheter").addClass("btn-acheterIpad");
				
				
				// FACEBOOK
				$("#sina-image").addClass("sina-imageIpad");
				$("#sina-like").addClass("sina-likeIpad");
				
				
				// CONTACT
				$("#contact-form").addClass("contact-formIpad");
				$("#contact-img").addClass("contact-imgIpad");
			
			
				
		}
		
		else{
				
				// HOME
				$('#imageIn').scrollingParallax({
					staticSpeed : 0.7,
					staticScrollLimit : false
				});
				
				$('#imagelogo').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('#welcome').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('#btnDownHome').scrollingParallax({
					staticSpeed : 0.7,
					staticScrollLimit : false
				});
				
				
				
				// BIO
				
				$("#contBio").addClass("contBioClassic");
				$("#imageBio").addClass("imageBioClassic");
				
				$('.contBioClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('.imageBioClassic').scrollingParallax({
					staticSpeed : 1.6,
					staticScrollLimit : false
				});
				
				
				// VIDEOS
				
				$("#lecteurvid").addClass("lecteurvidClassic");
				$("#launchVideo").addClass("launchVideoClassic");
				$("#textVid").addClass("textVidClassic");
				
				$('.lecteurvidClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('.launchVideoClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('.textVidClassic').scrollingParallax({
					staticSpeed : 1.6,
					staticScrollLimit : false
				});
				
				
				// PHOTOS
				
				$("#slides").addClass("slidesClassic");
				
				$('.slidesClassic').scrollingParallax({
					staticSpeed : 1.6,
					staticScrollLimit : false
				});
				
				
				// BOUTIQUE
				
				$("#album").addClass("albumClassic");
				$("#telechargement").addClass("telechargementClassic");
				$("#commande").addClass("commandeClassic");
				$("#btn-acheter").addClass("btn-acheterClassic");
				
				$('.albumClassic').scrollingParallax({
					staticSpeed : 1.6,
					staticScrollLimit : false
				});
				
				$('.telechargementClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('.commandeClassic').scrollingParallax({
					staticSpeed : 1,
					staticScrollLimit : false
				});
				
				$('.btn-acheterClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				
				// FACEBOOK
				
				$("#sina-image").addClass("sina-imageClassic");
				$("#sina-like").addClass("sina-likeClassic");
				
				$('.sina-imageClassic').scrollingParallax({
					staticSpeed : 1.6,
					staticScrollLimit : false
				});
				
				$('.sina-likeClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				
				// CONTACT
				
				// CONTACT
				$("#contact-form").addClass("contact-formClassic");
				$("#contact-img").addClass("contact-imgClassic");
				
				$('.contact-formClassic').scrollingParallax({
					staticSpeed : 1.2,
					staticScrollLimit : false
				});
				
				$('.contact-imgClassic').scrollingParallax({
					staticSpeed : 1.6,
					staticScrollLimit : false
				});
		}	
};




