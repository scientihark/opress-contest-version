$isnext=true;
$liked=0;
function modify_thumb_id(id) {
	if(id == -1) {
		document.getElementById("preview").innerHTML = "";
	}
	var thumbid = document.getElementById("thumb_id");
	thumbid.value = id;	
	var href = document.getElementById("thumbhref");
	var str = "showWindow('thumbswindow', 'plugin.php?id=thumbs&mod=upload&" + 
		getParameter("app", href.getAttribute('onclick')) + "&" +
		getParameter("rid", href.getAttribute('onclick')) + 
		"&thumbid=" + thumbid.value + "'); " + "return false;";
	href.setAttribute("onclick", str, 0);
}



function getParameter(paraStr, url)  
{  	
    var result = "";  
    var str = "&" + url.split("?")[1];  
    var paraName = paraStr + "=";  
    if(str.indexOf("&"+paraName)!=-1)  
    {  
        if(str.substring(str.indexOf(paraName),str.length).indexOf("&")!=-1)  
        {  
            var TmpStr=str.substring(str.indexOf(paraName),str.length);  
            result=TmpStr.substr(TmpStr.indexOf(paraName),TmpStr.indexOf("&")-TmpStr.indexOf(paraName));    
        }  
        else  
        {    
            result=str.substring(str.indexOf(paraName),str.length);    
        }  
    }    
    else  
    {    
        result="";    
    }    
    return (result.replace("&",""));    
} 


function sentanimation($canvasid){
	var canvas = document.getElementById($canvasid);
	var ctx = canvas.getContext("2d");
	var cyc = 100;
	ctx.fillStyle = "#fff";
	var loadingPosition = new Vector2(100, 60);
	var loadingRadius = 50;
	var intervalAngle = 45;
	var bigCircleRadius = 8;
	var bigCirclePosition = new Vector2(100, 20);
    bigCircleRadius = 10;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
	var canvas = document.getElementById($canvasid);
	function drawLoading() {
    	for (var i = 0; i < 11; i++) {
       	 	ctx.beginPath();
        	ctx.arc(bigCirclePosition.x, bigCirclePosition.y, bigCircleRadius, 0, Math.PI * 2, true);
        	ctx.closePath();
        	ctx.fill();
        	bigCircleRadius -= 1;
        	bigCirclePosition.rotateSelf(loadingPosition, 30);
    	}
	}
	var $aaa=function () {
    	bigCircleRadius = 10;
    	ctx.clearRect(0, 0, canvas.width, canvas.height);
   		drawLoading();000000000000
	}
	CANVASLOOP=setInterval($aaa, 50);
}
Vector2 = function (x, y) {
            this.x = x || 0;
            this.y = y || 0;
        };
        Vector2.prototype = {
            sub: function (v1, v2) {
                this.x = v1.x - v2.x;
                this.y = v1.y - v2.y;
                return this;
            },
       rotateSelf: function (p, theta) {
		var v = new Vector2();
v.sub(this, p);
theta *= Math.PI / 180;
 var R = [[Math.cos(theta), -Math.sin(theta)], [Math.sin(theta), Math.cos(theta)]];
this.x = p.x + R[0][0] * v.x + R[0][1] * v.y;
this.y = p.y + R[1][0] * v.x + R[1][1] * v.y;
}
};
// 首页ajax调用
function getcontent(type, id, return_block) {
	if($('#' + return_block + ' .artist-description').text() == '') {
		//$('#block_title_'+type+id).addClass('').removeClass('title');
		$('#' + return_block + ' .artist-description').html(tohtml("<center><canvas id=\"myCanvas"+id+"\"><img src=\"../img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\"></canvas></center>"));
		sentanimation("myCanvas"+id);
$.ajax({
                 type:"POST",
                 dataType:"html",
                 url:"http://contest.scie.in/api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"get_posts",id:id}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					//$('#' + return_block + ' .date').text(data.date);
					//$tempa='#' + return_block + ' .artist-description';
					//document.getElementById($tempa).innerHTML=data.conent;
					//$('#' + return_block + ' .artist-description').html(data.conent);
					//$('#' + return_block + ' .artist-description').html(tohtml(data.conent));
					$('#' + return_block + ' .artist-description').html(tohtml(data));
					//$('#' + return_block + ' .artist-description').html("ok");
					//$('#block_title_'+type+id).addClass('title');
					//$('#block_title_'+type+id).click();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
					
	             }
                 
	});
	}
}

function filterImgElement(data, limit) {
	data = data.replace(/<\/?img[^>]*>/gi,"[图片]"); 
	
	return data;
}

String.prototype.replaceAll = function(s1,s2) {
    return this.replace(new RegExp(s1,"gm"),s2);
}

function tohtml(str)
{
str = str.replaceAll('&lt;',"<");
str = str.replaceAll('&gt;','>');
return str;
}


function addarticle($type,$id,$title,$date,$img){
	var $mother=document.getElementById('cp_appoint');
	var $son=document.createElement("article");
	$son.id="cp-"+$type+"-"+$id;
	$son.className="type-nyheder status-publish hentry small-long isotope-item";
	var $ocvar="getcontent('"+$type+"', '"+$id+"', '"+"cp-"+$type+"-"+$id+"');";
	$ndate=new Date($date.replace(/-/g,"/"));
	var $ptime=Date.parse($ndate);
	//alert($ptime);
	//var $argv={"onclick":$ocvar, "data-id":$id,"data-title":$title,"data-slug":$title,"data-views":0,"data-likes":0,"data-timestamp":$ptime};
	//$son.attributes.push($argv);
	$son.setAttribute("onclick",$ocvar);
	$son.setAttribute("data-id",$id);
	$son.setAttribute("data-title",$title);
	$son.setAttribute("data-slug",$title);
	$son.setAttribute("data-views",0);
	$son.setAttribute("data-likes",0);
	$son.setAttribute("data-timestamp",$ptime);
	$son.setAttribute("style","style=\"position: absolute; left: 480px; top: 500px; opacity: 1;");
	var $postc="<header class=\"title\"> <img src=\""+$img+"\" width=\"110\" height=\"80\" alt=\"此模版甚好，朕收下了。\" />\n";
	$postc=$postc+"<h3>"+$title+"</h3>\n<div class=\"tauthor\">"+$date+"</div>\n</header>\n<section class=\"post_content\">\n<header>\n<table id=\"info\" class=\htitle\">\n<tbody>\n<tr>\n<th class=\"text-right\">顶</th>\n<td class=\text-left author\"></td>\n</tr>\n<tr>\n<th class=\"text-right\">阅读</th>\n<td class=\"text-left views\"></td>\n</tr>\n</tbody>\n</table>\n</header>\n<table class=\"htitle\">\n<tbody>\n<tr>\n<th class=\"text-right\"></th></td>\n</tr>\n</tbody>\n</table>\n<section class=\"artist-description\"></section>\n<table class=\"htitle\">\n<tbody>\n<tr>\n<th class=\"text-right\></th>\n<td>\n</td>\n</tr>\n</tbody>\n</table>\n<section class=\"artist-meta\">\n</section>\n</section>\n";
	$postc=$postc+"<footer class=\"read-more\"> <a class=\"toggler like\" href=\"#\"><span class=\"icon\"></span><span class=\"count\>0个回复</span></a> <a class=\"toggler open\" href=\"#\" rel=\"bookmark\">展开帖子</a> </footer>";	
	$son.innerHTML=$postc;
	$mother.appendChild($son);
}

function get_news($page) {
	if($isnext) {
		//$('#block_title_'+type+id).addClass('').removeClass('title');
$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"http://contest.scie.in/api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"get_news",page:$page}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					var $ii=0;
					for($ii=0;$ii<data.count;$ii++){
						addarticle("news",data.ids[$ii],data.titles[$ii],data.date[$ii],data.img[$ii])
					}
					$isnext=data.isnextp;
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
					
	             }
                 
	});
	}
}
//get_news(1);
go_site_inti();
inti_weibo();
function inti_weibo(){
	weibo_refresh();
	var $ccc=function(){weibo_refresh();};
	setInterval($ccc,360000);
}
function weibo_refresh(){
	$tbox=document.getElementById('cp_aside_wb');
	$tbox.innerHTML="<center><canvas id=\"myCanvas-tbox\"><img src=\"../img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\"></canvas></center>";
	sentanimation('myCanvas-tbox');
	$.ajax({
                 type:"POST",
                 dataType:"html",
                 url:"../api/sina/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"weibo"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 $tbox.innerHTML=data;
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$tbox.innerHTML="请求超时，稍后继续查询";
	             }
                 
});
}
function go_site_inti(){
	document.getElementById('mn_P1').addEventListener("click",go_p,false);
	$go_site_inti_tempb=function(){
		//window.open("/honor");
		};
	document.getElementById('mn_home').addEventListener("click",$go_site_inti_tempb,false);

	document.getElementById('mn_forum_2').addEventListener("click",go_m,false);
	
	document.getElementById('mn_forum_11').addEventListener("click",go_l,false);
	
	document.getElementById('mn_home_4').addEventListener("click",go_a,false);
}
function go_p(){
		window.open("/p");
};
function go_l(){
		window.open("/login.html");
};
function go_m(){
		window.open("/mpanel.html");
};
function go_a(){
		window.open("/");
};
function like_this($post_id){
	$tempb='liked_'+$post_id;
		$tempc=document.getElementById($tempb).innerHTML;
	if(!$tempc||$tempc!="`"){
		 $tempa='like_'+$post_id;
		document.getElementById($tempa).innerHTML="正在顶~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"../api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"like_posts",id:$post_id}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					
					
					 document.getElementById($tempa).innerHTML=data.num+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;顶过了";
					 document.getElementById($tempb).innerHTML="`";
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById($tempa).innerHTML="请求超时，点我重新顶~~";
	             }
                 
});
	}
}