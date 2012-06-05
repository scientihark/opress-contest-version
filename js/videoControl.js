$(document).ready(function(){
    
    
    initmavideo();
    
    
});

function initmavideo(){
    
    
    
    // ANIM TEXTVIDEO IPAD  (SANS LAUNCHVIDEO)
    if ((navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1))
    {        
        
        $("#launchVideo").hide();
        
        var clicTextVideoIpad = 0;
        
        $(".textVidIpad").append("<p id=\"infoVid\">i</p>");
        $("#infoVid").hide();
                
        $(".textVidIpad").css("cursor","pointer");
        
        // i
        $("#titreVid").hide();
        $("#textVidIn").hide();
        
        $(".textVidIpad").stop().animate({width:50, height:50, marginTop:380, marginLeft:667}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginTop:'easeOutExpo', marginLeft:'easeOutExpo' }, } );
        
        $("#infoVid").show();
        
    
        $(".textVidIpad").click(function(){
                
            var moduloClicIpad = (clicTextVideoIpad-1)%2;        
        
            if(moduloClicIpad == 0)
                {
                    // Full Text
                    $("#infoVid").hide();
                    $(".textVidIpad").stop().animate({width:310, height:310, marginTop:172, marginLeft:451}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginTop:'easeOutExpo', marginLeft:'easeOutExpo' }, } );
                    $(".textVidIpad").delay(800, function()
                    {
                        $("#titreVid").show();
                        $("#textVidIn").show();
                    });
                    
                    clicTextVideoIpad++;
                }
                else
                {
                    // i
                    $("#titreVid").hide();
                    $("#textVidIn").hide();
                    
                    $(".textVidIpad").stop().animate({width:50, height:50, marginTop:380, marginLeft:667}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginTop:'easeOutExpo', marginLeft:'easeOutExpo' }, } );
                    
                    $("#infoVid").show();                
                    
                    clicTextVideoIpad++;
                }  
        });
    }
    
    // ANIM CLASSIQUE
    else
    {
        
        $("#launchVideo").mouseenter(function(){
        
            $(this).find("#btnLirevid").stop().animate({marginTop:-18},150);
        });
    
        $("#launchVideo").mouseout(function(){
            
            $(this).find("#btnLirevid").stop().animate({marginTop:0},150);
        });
        
    
        $("#launchVideo").click(function(){
            
            $(this).stop().animate({opacity:0},600);
            
            $(this).delay(1000, function()
            {
                $(this).hide();
            });
            
                $(".textVidClassic").stop().animate({width:50, height:50, marginTop:3813, marginLeft:667}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginTop:'easeOutExpo', marginLeft:'easeOutExpo' }, } );
                //$("#textVid").stop().animate({height:50},600);
                
                $("#titreVid").hide();
                $("#textVidIn").hide();
                
                $(".textVidClassic").delay(800, function()
                {
                    $(".textVidClassic").append("<p id=\"infoVid\">i</p>");
                });
                
                $(".textVidClassic").css("cursor","pointer");
            
            
            // Lancement de la vid閛
            $('#vid').delay(600).get(0).play();        
            
            var clicTextVideo = 1;        
            
            
            $("#textVid").click(function(){
                
                var moduloClic = (clicTextVideo-1)%2;
                
                if(moduloClic == 0)
                {
                    // Full Text
                    $("#infoVid").hide();
                    $(".textVidClassic").stop().animate({width:310, height:310, marginTop:3605, marginLeft:451}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginTop:'easeOutExpo', marginLeft:'easeOutExpo' }, } );
                    $(".textVidClassic").delay(800, function()
                    {
                        $("#titreVid").show();
                        $("#textVidIn").show();
                    });
                    
                    clicTextVideo++;
                }
                else
                {
                    // i
                    $("#titreVid").hide();
                    $("#textVidIn").hide();
                    
                    $(".textVidClassic").stop().animate({width:50, height:50, marginTop:3813, marginLeft:667}, {duration:400, specialEasing: { width: 'easeOutExpo', height: 'easeOutExpo', marginTop:'easeOutExpo', marginLeft:'easeOutExpo' }, } );
                    
                    $("#infoVid").show();                
                    
                    clicTextVideo++;
                }
                
                
                
            });

        
    });
    
    
    
}

}

