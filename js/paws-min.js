!function($){"use strict";var toggle='[data-toggle="dropdown"]',Dropdown=function(element){var $el=$(element).on('click.dropdown.data-api',this.toggle)
$('html').on('click.dropdown.data-api',function(){$el.parent().removeClass('open')})}
Dropdown.prototype={constructor:Dropdown,toggle:function(e){var $this=$(this),$parent,selector,isActive
if($this.is('.disabled, :disabled'))return
selector=$this.attr('data-target')
if(!selector){selector=$this.attr('href')
selector=selector&&selector.replace(/.*(?=#[^\s]*$)/,'')}
$parent=$(selector)
$parent.length||($parent=$this.parent())
isActive=$parent.hasClass('open')
clearMenus()
if(!isActive)$parent.toggleClass('open')
return false}}
function clearMenus(){$(toggle).parent().removeClass('open')}
$.fn.dropdown=function(option){return this.each(function(){var $this=$(this),data=$this.data('dropdown')
if(!data)$this.data('dropdown',(data=new Dropdown(this)))
if(typeof option=='string')data[option].call($this)})}
$.fn.dropdown.Constructor=Dropdown
$(function(){$('html').on('click.dropdown.data-api',clearMenus)
$('body').on('click.dropdown','.dropdown form',function(e){e.stopPropagation()}).on('click.dropdown.data-api',toggle,Dropdown.prototype.toggle)})}(window.jQuery);!function($){"use strict";var Tab=function(element){this.element=$(element)}
Tab.prototype={constructor:Tab,show:function(){var $this=this.element,$ul=$this.closest('ul:not(.dropdown-menu)'),selector=$this.attr('data-target'),previous,$target,e
if(!selector){selector=$this.attr('href')
selector=selector&&selector.replace(/.*(?=#[^\s]*$)/,'')}
if($this.parent('li').hasClass('active'))return
previous=$ul.find('.active a').last()[0]
e=$.Event('show',{relatedTarget:previous})
$this.trigger(e)
if(e.isDefaultPrevented())return
$target=$(selector)
this.activate($this.parent('li'),$ul)
this.activate($target,$target.parent(),function(){$this.trigger({type:'shown',relatedTarget:previous})})},activate:function(element,container,callback){var $active=container.find('> .active'),transition=callback&&$.support.transition&&$active.hasClass('fade')
function next(){$active.removeClass('active').find('> .dropdown-menu > .active').removeClass('active')
element.addClass('active')
if(transition){element[0].offsetWidth
element.addClass('in')}else{element.removeClass('fade')}
if(element.parent('.dropdown-menu')){element.closest('li.dropdown').addClass('active')}
callback&&callback()}
transition?$active.one($.support.transition.end,next):next()
$active.removeClass('in')}}
$.fn.tab=function(option){return this.each(function(){var $this=$(this),data=$this.data('tab')
if(!data)$this.data('tab',(data=new Tab(this)))
if(typeof option=='string')data[option]()})}
$.fn.tab.Constructor=Tab
$(function(){$('body').on('click.tab.data-api','[data-toggle="tab"], [data-toggle="pill"]',function(e){e.preventDefault()
$(this).tab('show')})})}(window.jQuery);!function($){"use strict";var Collapse=function(element,options){this.$element=$(element)
this.options=$.extend({},$.fn.collapse.defaults,options)
if(this.options.parent){this.$parent=$(this.options.parent)}
this.options.toggle&&this.toggle()}
Collapse.prototype={constructor:Collapse,dimension:function(){var hasWidth=this.$element.hasClass('width')
return hasWidth?'width':'height'},show:function(){var dimension,scroll,actives,hasData
if(this.transitioning)return
dimension=this.dimension()
scroll=$.camelCase(['scroll',dimension].join('-'))
actives=this.$parent&&this.$parent.find('> .accordion-group > .in')
if(actives&&actives.length){hasData=actives.data('collapse')
if(hasData&&hasData.transitioning)return
actives.collapse('hide')
hasData||actives.data('collapse',null)}
this.$element[dimension](0)
this.transition('addClass',$.Event('show'),'shown')
this.$element[dimension](this.$element[0][scroll])},hide:function(){var dimension
if(this.transitioning)return
dimension=this.dimension()
this.reset(this.$element[dimension]())
this.transition('removeClass',$.Event('hide'),'hidden')
this.$element[dimension](0)},reset:function(size){var dimension=this.dimension()
this.$element.removeClass('collapse')[dimension](size||'auto')[0].offsetWidth
this.$element[size!==null?'addClass':'removeClass']('collapse')
return this},transition:function(method,startEvent,completeEvent){var that=this,complete=function(){if(startEvent.type=='show')that.reset()
that.transitioning=0
that.$element.trigger(completeEvent)}
this.$element.trigger(startEvent)
if(startEvent.isDefaultPrevented())return
this.transitioning=1
this.$element[method]('in')
$.support.transition&&this.$element.hasClass('collapse')?this.$element.one($.support.transition.end,complete):complete()},toggle:function(){this[this.$element.hasClass('in')?'hide':'show']()}}
$.fn.collapse=function(option){return this.each(function(){var $this=$(this),data=$this.data('collapse'),options=typeof option=='object'&&option
if(!data)$this.data('collapse',(data=new Collapse(this,options)))
if(typeof option=='string')data[option]()})}
$.fn.collapse.defaults={toggle:true}
$.fn.collapse.Constructor=Collapse
$(function(){$('body').on('click.collapse.data-api','[data-toggle=collapse]',function(e){var $this=$(this),href,target=$this.attr('data-target')||e.preventDefault()||(href=$this.attr('href'))&&href.replace(/.*(?=#[^\s]+$)/,''),option=$(target).data('collapse')?'toggle':$this.data()
$(target).collapse(option)})})}(window.jQuery);!function($){"use strict";var Modal=function(content,options){this.options=options
this.$element=$(content).delegate('[data-dismiss="modal"]','click.dismiss.modal',$.proxy(this.hide,this))}
Modal.prototype={constructor:Modal,toggle:function(){return this[!this.isShown?'show':'hide']()},show:function(){var that=this,e=$.Event('show')
this.$element.trigger(e)
if(this.isShown||e.isDefaultPrevented())return
$('body').addClass('modal-open')
this.isShown=true
escape.call(this)
backdrop.call(this,function(){var transition=$.support.transition&&that.$element.hasClass('fade')
if(!that.$element.parent().length){that.$element.appendTo(document.body)}
that.$element.show()
if(transition){that.$element[0].offsetWidth}
that.$element.addClass('in')
transition?that.$element.one($.support.transition.end,function(){that.$element.trigger('shown')}):that.$element.trigger('shown')})},hide:function(e){e&&e.preventDefault()
var that=this
e=$.Event('hide')
this.$element.trigger(e)
if(!this.isShown||e.isDefaultPrevented())return
this.isShown=false
$('body').removeClass('modal-open')
escape.call(this)
this.$element.removeClass('in')
$.support.transition&&this.$element.hasClass('fade')?hideWithTransition.call(this):hideModal.call(this)}}
function hideWithTransition(){var that=this,timeout=setTimeout(function(){that.$element.off($.support.transition.end)
hideModal.call(that)},500)
this.$element.one($.support.transition.end,function(){clearTimeout(timeout)
hideModal.call(that)})}
function hideModal(that){this.$element.hide().trigger('hidden')
backdrop.call(this)}
function backdrop(callback){var that=this,animate=this.$element.hasClass('fade')?'fade':''
if(this.isShown&&this.options.backdrop){var doAnimate=$.support.transition&&animate
this.$backdrop=$('<div class="modal-backdrop '+animate+'" />').appendTo(document.body)
if(this.options.backdrop!='static'){this.$backdrop.click($.proxy(this.hide,this))}
if(doAnimate)this.$backdrop[0].offsetWidth
this.$backdrop.addClass('in')
doAnimate?this.$backdrop.one($.support.transition.end,callback):callback()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass('in')
$.support.transition&&this.$element.hasClass('fade')?this.$backdrop.one($.support.transition.end,$.proxy(removeBackdrop,this)):removeBackdrop.call(this)}else if(callback){callback()}}
function removeBackdrop(){this.$backdrop.remove()
this.$backdrop=null}
function escape(){var that=this
if(this.isShown&&this.options.keyboard){$(document).on('keyup.dismiss.modal',function(e){e.which==27&&that.hide()})}else if(!this.isShown){$(document).off('keyup.dismiss.modal')}}
$.fn.modal=function(option){return this.each(function(){var $this=$(this),data=$this.data('modal'),options=$.extend({},$.fn.modal.defaults,$this.data(),typeof option=='object'&&option)
if(!data)$this.data('modal',(data=new Modal(this,options)))
if(typeof option=='string')data[option]()
else if(options.show)data.show()})}
$.fn.modal.defaults={backdrop:true,keyboard:true,show:true}
$.fn.modal.Constructor=Modal
$(function(){$('body').on('click.modal.data-api','[data-toggle="modal"]',function(e){var $this=$(this),href,$target=$($this.attr('data-target')||(href=$this.attr('href'))&&href.replace(/.*(?=#[^\s]+$)/,'')),option=$target.data('modal')?'toggle':$.extend({},$target.data(),$this.data())
e.preventDefault()
$target.modal(option)})})}(window.jQuery);var popupWindow=null;function centeredPopup(url,winName,w,h,scroll){LeftPosition=(screen.width)?(screen.width-w)/2:0;TopPosition=(screen.height)?(screen.height-h)/2.5:0;settings='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
popupWindow=window.open(url,winName,settings)}
(function(w){var ua=navigator.userAgent;if(!(/iPhone|iPad|iPod/.test(navigator.platform)&&/OS [1-5]_[0-9_]* like Mac OS X/i.test(ua)&&ua.indexOf("AppleWebKit")>-1)){return;}
var doc=w.document;if(!doc.querySelector){return;}
var meta=doc.querySelector("meta[name=viewport]"),initialContent=meta&&meta.getAttribute("content"),disabledZoom=initialContent+",maximum-scale=1",enabledZoom=initialContent+",maximum-scale=10",enabled=true,x,y,z,aig;if(!meta){return;}
function restoreZoom(){meta.setAttribute("content",enabledZoom);enabled=true;}
function disableZoom(){meta.setAttribute("content",disabledZoom);enabled=false;}
function checkTilt(e){aig=e.accelerationIncludingGravity;x=Math.abs(aig.x);y=Math.abs(aig.y);z=Math.abs(aig.z);if((!w.orientation||w.orientation===180)&&(x>7||((z>6&&y<8||z<8&&y>6)&&x>5))){if(enabled){disableZoom();}}
else if(!enabled){restoreZoom();}}
w.addEventListener("orientationchange",restoreZoom,false);w.addEventListener("devicemotion",checkTilt,false);})(this);(function($){$.fn.fitVids=function(options){var settings={customSelector:null}
var div=document.createElement('div'),ref=document.getElementsByTagName('base')[0]||document.getElementsByTagName('script')[0];div.className='fit-vids-style';div.innerHTML='&shy;<style>         \
      .fluid-width-video-wrapper {        \
         width: 100%;                     \
         position: relative;              \
         padding: 0;                      \
      }                                   \
                                          \
      .fluid-width-video-wrapper iframe,  \
      .fluid-width-video-wrapper object,  \
      .fluid-width-video-wrapper embed {  \
         position: absolute;              \
         top: 0;                          \
         left: 0;                         \
         width: 100%;                     \
         height: 100%;                    \
      }                                   \
    </style>';ref.parentNode.insertBefore(div,ref);if(options){$.extend(settings,options);}
return this.each(function(){var selectors=["iframe[src*='player.vimeo.com']","iframe[src*='www.youtube.com']","iframe[src*='www.kickstarter.com']","object","embed"];if(settings.customSelector){selectors.push(settings.customSelector);}
var $allVideos=$(this).find(selectors.join(','));$allVideos.each(function(){var $this=$(this);if(this.tagName.toLowerCase()=='embed'&&$this.parent('object').length||$this.parent('.fluid-width-video-wrapper').length){return;}
var height=this.tagName.toLowerCase()=='object'?$this.attr('height'):$this.height(),aspectRatio=height/$this.width();if(!$this.attr('id')){var videoID='fitvid'+Math.floor(Math.random()*999999);$this.attr('id',videoID);}
$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top',(aspectRatio*100)+"%");$this.removeAttr('height').removeAttr('width');});});}})(jQuery);
