/*
 * urlInternal - v1.0 - 10/7/2009
 * http://benalman.com/projects/jquery-urlinternal-plugin/
 * 
 * Copyright (c) 2009 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($){var g,i=!0,r=!1,m=window.location,h=Array.prototype.slice,b=m.href.match(/^((https?:\/\/.*?\/)?[^#]*)#?.*$/),u=b[1]+"#",t=b[2],e,l,f,q,c,j,x="elemUrlAttr",k="href",y="src",p="urlInternal",d="urlExternal",n="urlFragment",a,s={};function w(A){var z=h.call(arguments,1);return function(){return A.apply(this,z.concat(h.call(arguments)))}}$.isUrlInternal=q=function(z){if(!z||j(z)){return g}if(a.test(z)){return i}if(/^(?:https?:)?\/\//i.test(z)){return r}if(/^[a-z\d.-]+:/i.test(z)){return g}return i};$.isUrlExternal=c=function(z){var A=q(z);return typeof A==="boolean"?!A:A};$.isUrlFragment=j=function(z){var A=(z||"").match(/^([^#]?)([^#]*#).*$/);return !!A&&(A[2]==="#"||z.indexOf(u)===0||(A[1]==="/"?t+A[2]===u:!/^https?:\/\//i.test(z)&&$('<a href="'+z+'"/>')[0].href.indexOf(u)===0))};function v(A,z){return this.filter(":"+A+(z?"("+z+")":""))}$.fn[p]=w(v,p);$.fn[d]=w(v,d);$.fn[n]=w(v,n);function o(D,C,B,A){var z=A[3]||e()[(C.nodeName||"").toLowerCase()]||"";return z?!!D(C.getAttribute(z)):r}$.expr[":"][p]=w(o,q);$.expr[":"][d]=w(o,c);$.expr[":"][n]=w(o,j);$[x]||($[x]=function(z){return $.extend(s,z)})({a:k,base:k,iframe:y,img:y,input:y,form:"action",link:k,script:y});e=$[x];$.urlInternalHost=l=function(B){B=B?"(?:(?:"+Array.prototype.join.call(arguments,"|")+")\\.)?":"";var A=new RegExp("^"+B+"(.*)","i"),z="^(?:"+m.protocol+")?//"+m.hostname.replace(A,B+"$1").replace(/\\?\./g,"\\.")+(m.port?":"+m.port:"")+"/";return f(z)};$.urlInternalRegExp=f=function(z){if(z){a=typeof z==="string"?new RegExp(z,"i"):z}return a};l("www")})(jQuery);


/*
 * jQuery Address Plugin v1.5
 * http://www.asual.com/jquery/address/
 *
 * Copyright (c) 2009-2010 Rostislav Hristov
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * Date: 2012-11-18 23:51:44 +0200 (Sun, 18 Nov 2012)
 */
 (function(a){a.address=(function(){var d=function(al){var am=a.extend(a.Event(al),(function(){var aq={},ap=a.address.parameterNames();for(var ao=0,an=ap.length;
ao<an;ao++){aq[ap[ao]]=a.address.parameter(ap[ao]);}return{value:a.address.value(),path:a.address.path(),pathNames:a.address.pathNames(),parameterNames:ap,parameters:aq,queryString:a.address.queryString()};
}).call(a.address));a(a.address).trigger(am);return am;},k=function(al){return Array.prototype.slice.call(al);},j=function(an,am,al){a().bind.apply(a(a.address),Array.prototype.slice.call(arguments));
return a.address;},L=function(am,al){a().unbind.apply(a(a.address),Array.prototype.slice.call(arguments));return a.address;},P=function(){return(ae.pushState&&E.state!==K);
},J=function(){return("/"+aa.pathname.replace(new RegExp(E.state),"")+aa.search+(W()?"#"+W():"")).replace(R,"/");},W=function(){var al=aa.href.indexOf("#");
return al!=-1?F(aa.href.substr(al+1),af):"";},A=function(){return P()?J():W();},b=function(){try{return top.document!==K&&top.document.title!==K?top:window;
}catch(al){return window;}},l=function(){return"javascript";},aj=function(al){al=al.toString();return(E.strict&&al.substr(0,1)!="/"?"/":"")+al;},F=function(al,am){if(E.crawlable&&am){return(al!==""?"!":"")+al;
}return al.replace(/^\!/,"");},V=function(al,am){return parseInt(al.css(am),10);},ad=function(){if(!t){var am=A(),al=decodeURI(Y)!=decodeURI(am);if(al){if(h&&q<7){aa.reload();
}else{if(h&&!Q&&E.history){n(G,50);}_old=Y;Y=am;ab(af);}}}},ab=function(al){var an=d(I),am=d(al?g:ai);n(x,10);if(an.isDefaultPrevented()||am.isDefaultPrevented()){S();
}},S=function(){Y=_old;if(P()){}else{t=D;if(s){if(E.history){aa.hash="#"+F(Y,D);}else{aa.replace("#"+F(Y,D));}}else{if(Y!=A()){if(E.history){aa.hash="#"+F(Y,D);
}else{aa.replace("#"+F(Y,D));}}}if((h&&!Q)&&E.history){n(G,50);}if(s){n(function(){t=af;},1);}else{t=af;}}},x=function(){if(E.tracker!=="null"&&E.tracker!==H){var al=a.isFunction(E.tracker)?E.tracker:T[E.tracker],am=(aa.pathname+aa.search+(a.address&&!P()?a.address.value():"")).replace(/\/\//,"/").replace(/^\/$/,"");
if(a.isFunction(al)){al(am);}else{if(a.isFunction(T.urchinTracker)){T.urchinTracker(am);}else{if(T.pageTracker!==K&&a.isFunction(T.pageTracker._trackPageview)){T.pageTracker._trackPageview(am);
}else{if(T._gaq!==K&&a.isFunction(T._gaq.push)){T._gaq.push(["_trackPageview",decodeURI(am)]);}}}}}},G=function(){var al=l()+":"+af+";document.open();document.writeln('<html><head><title>"+ah.title.replace(/\'/g,"\\'")+"</title><script>var "+z+' = "'+encodeURIComponent(A()).replace(/\'/g,"\\'")+(ah.domain!=aa.hostname?'";document.domain="'+ah.domain:"")+"\";<\/script></head></html>');document.close();";
if(q<7){e.src=al;}else{e.contentWindow.location.replace(al);}},ag=function(){if(i&&c!=-1){var al,an,am=i.substr(c+1).split("&");for(al=0;al<am.length;al++){an=am[al].split("=");
if(/^(autoUpdate|crawlable|history|strict|wrap)$/.test(an[0])){E[an[0]]=(isNaN(an[1])?/^(true|yes)$/i.test(an[1]):(parseInt(an[1],10)!==0));}if(/^(state|tracker)$/.test(an[0])){E[an[0]]=an[1];
}}i=H;}_old=Y;Y=A();},U=function(){if(!Z){Z=D;ag();var an=function(){w.call(this);r.call(this);},am=a("body").ajaxComplete(an);an();if(E.wrap){var ao=a("body > *").wrapAll('<div style="padding:'+(V(am,"marginTop")+V(am,"paddingTop"))+"px "+(V(am,"marginRight")+V(am,"paddingRight"))+"px "+(V(am,"marginBottom")+V(am,"paddingBottom"))+"px "+(V(am,"marginLeft")+V(am,"paddingLeft"))+'px;" />').parent().wrap('<div id="'+z+'" style="height:100%;overflow:auto;position:relative;'+(s&&!window.statusbar.visible?"resize:both;":"")+'" />');
a("html, body").css({height:"100%",margin:0,padding:0,overflow:"hidden"});if(s){a('<style type="text/css" />').appendTo("head").text("#"+z+"::-webkit-resizer { background-color: #fff; }");
}}if(h&&!Q){var al=ah.getElementsByTagName("frameset")[0];e=ah.createElement((al?"":"i")+"frame");e.src=l()+":"+af;if(al){al.insertAdjacentElement("beforeEnd",e);
al[al.cols?"cols":"rows"]+=",0";e.noResize=D;e.frameBorder=e.frameSpacing=0;}else{e.style.display="none";e.style.width=e.style.height=0;e.tabIndex=-1;ah.body.insertAdjacentElement("afterBegin",e);
}n(function(){a(e).bind("load",function(){var ap=e.contentWindow;_old=Y;Y=ap[z]!==K?ap[z]:"";if(Y!=A()){ab(af);aa.hash=F(Y,D);}});if(e.contentWindow[z]===K){G();
}},50);}n(function(){d("init");ab(af);},1);if(!P()){if((h&&q>7)||(!h&&Q)){if(T.addEventListener){T.addEventListener(X,ad,af);}else{if(T.attachEvent){T.attachEvent("on"+X,ad);
}}}else{u(ad,50);}}if("state" in window.history){a(window).trigger("popstate");}}},w=function(){var ao,ar=a("a"),ap=ar.size(),am=1,al=-1,aq='[rel*="address:"]',an=function(){if(++al!=ap){ao=a(ar.get(al));
if(ao.is(aq)){ao.address(aq);}n(an,am);}};n(an,am);},p=function(){if(decodeURI(Y)!=decodeURI(A())){_old=Y;Y=A();ab(af);}},o=function(){if(T.removeEventListener){T.removeEventListener(X,ad,af);
}else{if(T.detachEvent){T.detachEvent("on"+X,ad);}}},r=function(){if(E.crawlable){var am=aa.pathname.replace(/\/$/,""),al="_escaped_fragment_";if(a("body").html().indexOf(al)!=-1){a('a[href]:not([href^=http]), a[href*="'+document.domain+'"]').each(function(){var an=a(this).attr("href").replace(/^http:/,"").replace(new RegExp(am+"/?$"),"");
if(an===""||an.indexOf(al)!=-1){a(this).attr("href","#"+encodeURI(decodeURIComponent(an.replace(new RegExp("/(.*)\\?"+al+"=(.*)$"),"!$2"))));}});}}},K,H=null,z="jQueryAddress",ac="string",X="hashchange",m="init",I="change",g="internalChange",ai="externalChange",D=true,af=false,E={autoUpdate:D,crawlable:af,history:D,strict:D,wrap:af},C=a.browser,q=parseFloat(C.version),h=!a.support.opacity,s=C.webkit||C.safari,T=b(),ah=T.document,ae=T.history,aa=T.location,u=setInterval,n=setTimeout,R=/\/{2,9}/g,ak=navigator.userAgent,Q="on"+X in T,e,N,i=a("script:last").attr("src"),c=i?i.indexOf("?"):-1,M=ah.title,t=af,Z=af,O=D,y=af,B={},Y=A();
_old=Y;if(h){q=parseFloat(ak.substr(ak.indexOf("MSIE")+4));if(ah.documentMode&&ah.documentMode!=q){q=ah.documentMode!=8?7:8;}var v=ah.onpropertychange;
ah.onpropertychange=function(){if(v){v.call(ah);}if(ah.title!=M&&ah.title.indexOf("#"+A())!=-1){ah.title=M;}};}if(ae.navigationMode){ae.navigationMode="compatible";
}if(document.readyState=="complete"){var f=setInterval(function(){if(a.address){U();clearInterval(f);}},50);}else{ag();a(U);}a(window).bind("popstate",p).bind("unload",o);
return{bind:function(am,an,al){return j.apply(this,k(arguments));},unbind:function(am,al){return L.apply(this,k(arguments));},init:function(am,al){return j.apply(this,[m].concat(k(arguments)));
},change:function(am,al){return j.apply(this,[I].concat(k(arguments)));},internalChange:function(am,al){return j.apply(this,[g].concat(k(arguments)));},externalChange:function(am,al){return j.apply(this,[ai].concat(k(arguments)));
},baseURL:function(){var al=aa.href;if(al.indexOf("#")!=-1){al=al.substr(0,al.indexOf("#"));}if(/\/$/.test(al)){al=al.substr(0,al.length-1);}return al;
},autoUpdate:function(al){if(al!==K){E.autoUpdate=al;return this;}return E.autoUpdate;},crawlable:function(al){if(al!==K){E.crawlable=al;return this;}return E.crawlable;
},history:function(al){if(al!==K){E.history=al;return this;}return E.history;},state:function(al){if(al!==K){E.state=al;var am=J();if(E.state!==K){if(ae.pushState){if(am.substr(0,3)=="/#/"){aa.replace(E.state.replace(/^\/$/,"")+am.substr(2));
}}else{if(am!="/"&&am.replace(/^\/#/,"")!=W()){n(function(){aa.replace(E.state.replace(/^\/$/,"")+"/#"+am);},1);}}}return this;}return E.state;},strict:function(al){if(al!==K){E.strict=al;
return this;}return E.strict;},tracker:function(al){if(al!==K){E.tracker=al;return this;}return E.tracker;},wrap:function(al){if(al!==K){E.wrap=al;return this;
}return E.wrap;},update:function(){y=D;this.value(Y);y=af;return this;},title:function(al){if(al!==K){n(function(){M=ah.title=al;if(O&&e&&e.contentWindow&&e.contentWindow.document){e.contentWindow.document.title=al;
O=af;}},50);return this;}return ah.title;},value:function(al){if(al!==K){al=aj(al);if(al=="/"){al="";}if(Y==al&&!y){return;}_old=Y;Y=al;if(E.autoUpdate||y){ab(D);
if(P()){ae[E.history?"pushState":"replaceState"]({},"",E.state.replace(/\/$/,"")+(Y===""?"/":Y));}else{t=D;if(s){if(E.history){aa.hash="#"+F(Y,D);}else{aa.replace("#"+F(Y,D));
}}else{if(Y!=A()){if(E.history){aa.hash="#"+F(Y,D);}else{aa.replace("#"+F(Y,D));}}}if((h&&!Q)&&E.history){n(G,50);}if(s){n(function(){t=af;},1);}else{t=af;
}}}return this;}return aj(Y);},path:function(am){if(am!==K){var al=this.queryString(),an=this.hash();this.value(am+(al?"?"+al:"")+(an?"#"+an:""));return this;
}return aj(Y).split("#")[0].split("?")[0];},pathNames:function(){var am=this.path(),al=am.replace(R,"/").split("/");if(am.substr(0,1)=="/"||am.length===0){al.splice(0,1);
}if(am.substr(am.length-1,1)=="/"){al.splice(al.length-1,1);}return al;},queryString:function(am){if(am!==K){var an=this.hash();this.value(this.path()+(am?"?"+am:"")+(an?"#"+an:""));
return this;}var al=Y.split("?");return al.slice(1,al.length).join("?").split("#")[0];},parameter:function(am,av,ao){var at,aq;if(av!==K){var au=this.parameterNames();
aq=[];av=av===K||av===H?"":av.toString();for(at=0;at<au.length;at++){var ap=au[at],aw=this.parameter(ap);if(typeof aw==ac){aw=[aw];}if(ap==am){aw=(av===H||av==="")?[]:(ao?aw.concat([av]):[av]);
}for(var ar=0;ar<aw.length;ar++){aq.push(ap+"="+aw[ar]);}}if(a.inArray(am,au)==-1&&av!==H&&av!==""){aq.push(am+"="+av);}this.queryString(aq.join("&"));
return this;}av=this.queryString();if(av){var al=[];aq=av.split("&");for(at=0;at<aq.length;at++){var an=aq[at].split("=");if(an[0]==am){al.push(an.slice(1).join("="));
}}if(al.length!==0){return al.length!=1?al:al[0];}}},parameterNames:function(){var al=this.queryString(),ao=[];if(al&&al.indexOf("=")!=-1){var ap=al.split("&");
for(var an=0;an<ap.length;an++){var am=ap[an].split("=")[0];if(a.inArray(am,ao)==-1){ao.push(am);}}}return ao;},hash:function(am){if(am!==K){this.value(Y.split("#")[0]+(am?"#"+am:""));
return this;}var al=Y.split("#");return al.slice(1,al.length).join("#");}};})();a.fn.address=function(b){var d;if(typeof b=="string"){d=b;b=undefined;}if(!a(this).attr("address")){var c=function(g){if(g.shiftKey||g.ctrlKey||g.metaKey||g.which==2){return true;
}if(a(this).is("a")){g.preventDefault();var f=b?b.call(this):/address:/.test(a(this).attr("rel"))?a(this).attr("rel").split("address:")[1].split(" ")[0]:a.address.state()!==undefined&&!/^\/?$/.test(a.address.state())?a(this).attr("href").replace(new RegExp("^(.*"+a.address.state()+"|\\.)"),""):a(this).attr("href").replace(/^(#\!?|\.)/,"");
a.address.value(f);}};a(d?d:this).live("click",c).live("submit",function(h){if(a(this).is("form")){h.preventDefault();var g=a(this).attr("action"),f=b?b.call(this):(g.indexOf("?")!=-1?g.replace(/&$/,""):g+"?")+a(this).serialize();
a.address.value(f);}}).attr("address",true);}return this;};})(jQuery);