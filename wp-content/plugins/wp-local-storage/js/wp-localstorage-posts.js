(function(window,undefined) {
var $=function(id){
		return document.getElementById(id);
	},
	
	$T=function(t,p) {
		p = p ? p : document;
		return p.getElementsByTagName(t);
	},
	
	$$=$C=function(c, t, p) {
		var at = $T(t,p),
			ms = new Array();
		for (var i = 0; i < at.length; i++)
			if (hasClassName(at[i],c))
				ms.push(at[i]);
		return ms;
	},
	
	hasClassName=function(o,c) {
		return new RegExp("(?:^|\\s+)" + c + "(?:\\s+|$)").test(o.className);
	},
	
	getObjPoint=function(o){
		var x=y=0;
		do {
			x += o.offsetLeft || 0;
			y += o.offsetTop  || 0;
			o = o.offsetParent;
		} while (o);

		return {'x':x,'y':y};
	},
	
	bind=function(obj,func){
		return function(){
			func.apply(obj,arguments);
		}
	},
	
	addListener=function(e, n, o, u){
		if(e.addEventListener) {
			e.addEventListener(n, o, u);
			return true;
		} else if(e.attachEvent) {
			e['e' + n + o] = o;
			e[n + o] = function() {
				e['e' + n + o](window.event);
			};
			e.attachEvent('on' + n, e[n + o]);
			return true;
		}
		return false;
	},
	
	IE=function(){
		if(/msie (\d+\.\d)/i.test(navigator.userAgent)){
			return document.documentMode || parseFloat(RegExp.$1);
		}
		return 0;
	},
	
	getScrollSize=function(){
		var x=y=0,
			doc=document.documentElement,
			body = document.body;
		x = (doc && doc.scrollLeft || body && body.scrollLeft || 0) - (doc && doc.clientLeft || body && body.clientLeft || 0);
		y = (doc && doc.scrollTop  || body && body.scrollTop  || 0) - (doc && doc.clientTop  || body && body.clientTop  || 0);
		return {'x':x,'y':y}
	},
	
	getWindowSize=function(){
		return {'x':document.documentElement.clientWidth || document.body.clientWidth,'y':document.documentElement.clientHeight || document.body.clientHeight};
	},
	
	getDocSize=function(){
		return {'x':document.documentElement.scrollWidth || document.body.scrollWidth,'y':document.documentElement.scrollHeight || document.body.scrollHeight};
	},
	
	documentReady=(function(){
		var load_events = [],load_timer,script,done,exec,old_onload,init = function () {done = true;clearInterval(load_timer);while (exec = load_events.shift())exec(); if (script) script.onreadystatechange = '';};
		return function (func) {
			if (done) return func();
			if (!load_events[0]) {
				if (document.addEventListener)
					document.addEventListener("DOMContentLoaded", init, false);
				else if (/MSIE/i.test(navigator.userAgent)){
					document.write("<script id=__ie_onload defer src=//0><\/scr"+"ipt>");
					script = document.getElementById("__ie_onload");
					script.onreadystatechange = function() {
						if (this.readyState == "complete")
							init();
					};
				}else
				if (/WebKit/i.test(navigator.userAgent)) {
					load_timer = setInterval(function() {
						if (/loaded|complete/.test(document.readyState))
							init();
					}, 10);
				}else{
					old_onload = window.onload;
					window.onload = function() {
						init();
						if (old_onload) old_onload();
					};
				}
			}
			load_events.push(func);
		}
	})();
	
	
var storeLocalData=function(key, value) {
    try {
        var storage=window.localStorage || window.globalStorage && window.globalStorage[location.hostname];
        if (storage){
			if (value !== undefined)
				value == "" ? storage.removeItem(key) : storage[key] = value;
			else if (key !== undefined)
				return storage[key] || "";
			else throw new Error();
        }else if (IE()) {
            var userData = $('userData') || document.createElement('input');
            if (!userData.id) {
				userData.id="userData";
				userData.style.display='none';
				userData.style.behavior='url(#default#userData)';
                document.body.appendChild(userData);
            }
            try {
                userData.load("oXMLBranch");
            } catch(e) {}
            if (value !== undefined) {
                value == "" ? userData.removeAttribute(key) : userData.setAttribute(key, value);
                userData.save("oXMLBranch");
            } else if (key !== undefined){
				return userData.getAttribute(key) || "";
			} else throw new Error();
        } else return false;
		return true;
    } catch(e) {
		if(storage){
			storage.clear();
		} else if (userData) {
			var attrs = userData.xmlDocument.firstChild.attributes, i;
			while(i = attrs.length){
				var j = attrs[--i].nodeName;
				userData.removeAttribute(j);
			}
			userData.save("oXMLBranch");
		}
	}
}

function getDate(){
	var date=new Date,
		year=date.getFullYear(),
		month=date.getMonth()+1,
		day=date.getDate(),
		hours=date.getHours(),
		min=date.getMinutes();
	month=month<10?'0'+month:month;
	day=day<10?'0'+day:day;
	min=min<10?'0'+min:min;
	return year+'/'+month+'/'+day+' '+hours+':'+min;
}
function storePostData(){
	if($('media-buttons')){
		var a=document.createElement('a'),
			b=document.createElement('span'),
			ui=new UI(a,'');
		a.href="#1";
		a.setAttribute('title','see the localStorage')
		a.innerHTML='<img src="'+window.WPLS_opt.btn+'"/>';
		b.style.marginLeft='10px';
		b.innerHTML='localStorage: ';
		$('media-buttons').appendChild(b);
		$('media-buttons').appendChild(a);
		addListener(a,'click',function(){
			var date=storeLocalData('WPLS_storage_post_time');
			if(date){
				ui.setContent(storeLocalData('WPLS_storage_post'));
				ui.setHead('Store data at '+storeLocalData('WPLS_storage_post_time'));
			}else
				ui.setHead('No date stored!');
			
		},false);
	}
	var local=storeLocalData('WPLS_storage_post'),
		storeTimer;
	
	addListener($('content'),'focus',function(){
		if(!storeTimer)
		storeTimer=setInterval(function(){
			if($('content').value!=''){
				storeLocalData('WPLS_storage_post', $('content').value);
				storeLocalData('WPLS_storage_post_time', getDate());
			}
		},1000);
	},false);
	addListener($('content'),'blur',function(){
		clearInterval(storeTimer);storeTimer=undefined;
	},false);
}
	/* UI Class */
	function UI(el,str){
		this.el=el;
		this.content=str;
		this.init();
	}
	UI.prototype={
		init:function(){
			this.frame=document.createElement('div');
			this.frame.className='SP_the_frame';
			var data='<table class="SP_dialog_table">'+
						'<tbody>'+
							'<tr>'+
								'<td class="SP_t_topleft"></td>'+
								'<td class="SP_t_topborder"></td>'+
								'<td class="SP_t_topright"></td>'+
							'</tr>'+
							'<tr>'+
								'<td class="SP_t_leftborder"></td>'+
								'<td class="SP_t_content">'+
									'<div class="SP_header"></div>'+
									'<div><textarea class="SP_content">'+this.content+'</textarea></div>'+
								'</td>'+
								'<td class="SP_t_rightborder"></td>'+
							'</tr>'+
							'<tr>'+
								'<td class="SP_t_bottomleft"></td>'+
								'<td class="SP_t_bottomborder"></td>'+
								'<td class="SP_t_bottomright"></td>'+
							'</tr>'+
						'</tbody></table><div class="SP_close"></div><div class="SP_arrow"></div>';
				
			this.frame.innerHTML=data;
			document.body.appendChild(this.frame);
			addListener($$('SP_close','div',this.frame)[0],'click',bind(this,this.hide),false);
		},
		show:function(){
			this.setPos();
			this.frame.style.display='block';
		},
		hide:function(){
			this.frame.style.display='none';
		},
		setContent:function(str){
			$$('SP_content','textarea',this.frame)[0].value=str;
			this.show();
		},
		setHead:function(str){
			$$('SP_header','div',this.frame)[0].innerHTML=str;
		},
		setPos:function(){
			var ep=getObjPoint(this.el),
				ds=getDocSize(),ss=getScrollSize(),
				ws=getWindowSize(),
				left,top;
			top=ep.y+20;
			left=ep.x-50;
			this.frame.style.top=top+'px';
			this.frame.style.left=left+'px';
		}
	}
	documentReady(function(){
		if($("content")&&$('media-buttons'))storePostData();
	});
})(window,undefined);