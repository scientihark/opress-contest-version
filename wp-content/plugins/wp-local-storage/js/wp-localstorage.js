(function(window,undefined) {
var $=function(id){
		return document.getElementById(id);
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
function storeCommentData(){
	var local=storeLocalData('WPLS_storage_'+$('comment_post_ID').value), post_id=$('comment_post_ID').value, 
		storeTimer, new_value, old_value=local;
	$('comment').value= local === undefined||local === false? '' : local;
	addListener($('comment'),'focus',function(){
		if(!storeTimer)
		storeTimer=setInterval(function(){
			if((new_value=$('comment').value)!==undefined && new_value!=old_value && (old_value=new_value)!==undefined)
				storeLocalData('WPLS_storage_'+post_id, new_value);
		},1000);
	},false);
	addListener($('comment'),'blur',function(){
		clearInterval(storeTimer);storeTimer=undefined;
	},false);
	addListener($('commentform'),'submit',function(){
		storeLocalData('WPLS_storage_'+$('comment_post_ID').value, '');
	},false);
}
	
	documentReady(function(){
		if($("comment")&&$('commentform'))storeCommentData();
	});
})(window,undefined);