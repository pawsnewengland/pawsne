/* ios-orientation-change-fix.js v1.0.0, Fixes zoom on rotation bug in iOS,Script by @scottjehl, rebound by @wilto, https://github.com/scottjehl/iOS-Orientationchange-Fix, MIT / GPLv2 License */
(function(w){var ua=navigator.userAgent;if(!(/iPhone|iPad|iPod/.test(navigator.platform)&&/OS [1-5]_[0-9_]* like Mac OS X/i.test(ua)&&ua.indexOf("AppleWebKit")>-1)){return;}
var doc=w.document;if(!doc.querySelector){return;}
var meta=doc.querySelector("meta[name=viewport]"),initialContent=meta&&meta.getAttribute("content"),disabledZoom=initialContent+",maximum-scale=1",enabledZoom=initialContent+",maximum-scale=10",enabled=true,x,y,z,aig;if(!meta){return;}
function restoreZoom(){meta.setAttribute("content",enabledZoom);enabled=true;}
function disableZoom(){meta.setAttribute("content",disabledZoom);enabled=false;}
function checkTilt(e){aig=e.accelerationIncludingGravity;x=Math.abs(aig.x);y=Math.abs(aig.y);z=Math.abs(aig.z);if((!w.orientation||w.orientation===180)&&(x>7||((z>6&&y<8||z<8&&y>6)&&x>5))){if(enabled){disableZoom();}}
else if(!enabled){restoreZoom();}}
w.addEventListener("orientationchange",restoreZoom,false);w.addEventListener("devicemotion",checkTilt,false);})(this);
/* fluid-vids.js v1.0, Fluid and responsive YouTube and Vimeo videos, Script by Todd Motto, https://github.com/toddmotto/fluidvids, MIT / GPLv2 License */
(function(){var iframes=document.getElementsByTagName('iframe');for(var i=0;i<iframes.length;++i){var iframe=iframes[i];var players=/www.youtube.com|player.vimeo.com/;if(iframe.src.search(players)!==-1){var videoRatio=(iframe.height/iframe.width)*100;iframe.style.position='absolute';iframe.style.top='0';iframe.style.left='0';iframe.width='100%';iframe.height='100%';var div=document.createElement('div');div.className='video-wrap';div.style.width='100%';div.style.position='relative';div.style.paddingTop=videoRatio+'%';var parentNode=iframe.parentNode;parentNode.insertBefore(div,iframe);div.appendChild(iframe);}}})();
/* drop.js v1.0, Simple, progressively enhanced dropdown menus, Script by Chris Ferdinandi - http://gomakethings.com, Licensed under WTFPL - http://www.wtfpl.net */
$(function(){$('.dropdown > a').click(function(e){e.preventDefault();$(this).toggleClass('active').next($('.dropdown-menu')).toggleClass('active');$(this).parent().siblings('.dropdown').removeClass('active').children('a').removeClass('active').next($('.dropdown-menu')).removeClass('active');$(this).parent('.dropdown').toggleClass('active');});});
/* astro.js v1.0, Mobile-first navigation patterns, Script by Chris Ferdinandi - http://gomakethings.com, Licensed under WTFPL - http://www.wtfpl.net/ */
$(function(){$('.nav-toggle').click(function(e){e.preventDefault();var dataID=$(this).attr('data-target');var hrefID=$(this).attr('href');if(dataID){$(dataID).toggleClass('active');}
else{$(hrefID).toggleClass('active');}});});
/* houdini.js v1.0, A simple collapse and expand widget, Script by Chris Ferdinandi - http://gomakethings.com, Licensed under WTFPL - http://www.wtfpl.net/ */
$(function(){$('.collapse-toggle').click(function(e){e.preventDefault();var dataID=$(this).attr('data-target');var hrefID=$(this).attr('href');if(dataID){$(dataID).toggleClass('active');}
else{$(hrefID).toggleClass('active');}});});
/* modal.js v1.0, A kinda-sorta modal window thingy, Script by Chris Ferdinandi - http://gomakethings.com, Licensed under WTFPL - http://www.wtfpl.net */
$(function(){$('.modal').click(function(e){e.preventDefault();var dataID=$(this).attr('data-target');$('.modal-menu').not(dataID).removeClass('active');$(dataID).toggleClass('active');});$('.modal-close').click(function(e){e.preventDefault();$('.modal-menu').removeClass('active');});});
/* petfinder-sort.js v1.0, Filter PetFinder results by a variety of categories, Script by Chris Ferdinandi - http://gomakethings.com, Licensed under WTFPL - http://www.wtfpl.net */
$(function(){$('.pf-sort').click(function(e){$('.grid-img').show();$('.pf-sort').each(function(i){var sortTarget=$(this).attr('data-target');if($(this).prop('checked')){}
else{$(sortTarget).hide();}});});});
/* js-accessibility.js v1.0, Adds .js class to <body> for progressive enhancement, Script by Chris Ferdinandi - http://gomakethings.com, Licensed under WTFPL - http://www.wtfpl.net */
$(function(){$('body').addClass('js');});
