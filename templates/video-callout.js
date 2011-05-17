
var slideshow = (function($) {

 	var transitionSecs = 7
	,currentPos = 0
	,$nliScreens = null
	,$tabs = []
	,transition_interval
	
	,closeVid = function($bt) {
		var cont_id = $bt.attr('href');
		if (jwplayer()) {
			jwplayer().stop();
			jwplayer().remove();
		}
		toggleVideo(false, cont_id);
	}

	,next = function() {
		var nextPos = (currentPos === ($nliScreens.length - 1)) ? 0 : currentPos + 1;
		show(currentPos, nextPos);
	}

	,show = function(current, next) {
		if (currentPos === next) {
			closeVid($($nliScreens[current]).find('.close-video>a'));
		} else {
		 $($nliScreens[current]).fadeOut(function() {
				$($tabs[current]).removeClass("selected");
			 	$($nliScreens[next]).fadeIn();
			 	$($tabs[next]).addClass("selected");
				currentPos = next;
		 });
		}
	}
	
	,animate = function(isAnim) {
		if (isAnim) {
			transition_interval = setInterval(next, transitionSecs * 1000);
		} else {
			clearInterval(transition_interval);
		}
	}
	
	,toggleVideo = function(isShowVid, ident) {
		var $player_cont = $(ident + '-screen')
		,$vid_descr = $player_cont.find('.video-description')
		,$vid_player = $player_cont.find('.video-player');
		if (isShowVid) {
			$vid_descr.fadeOut(function() {
				$vid_player.fadeIn(800);
			});
			animate(false);
		} else {
			$vid_player.fadeOut(function() {
				$vid_descr.fadeIn(800);
			});
			//animate(true);
		}
	};
	
	return {
	
		start: function(set_player_cb) {
			$nliScreens = $(".tabbed-video-callout .video-callout-screen");
			if ($nliScreens.length > 1) {
				$tabs = $('.tabbed-video-callout .video-callout-tab');
				$tabs.live('click', function(evt) {
					var tabPos = $(this).prevAll('.video-callout-tab').length;
					show(currentPos, tabPos);
					animate(false);
					return false;
				});
				$('.watch-video>a').live('click', function() {
					if (jwplayer()) {
						jwplayer().stop();
						jwplayer().remove();
					}
					var self = $(this)
					,playerId = self.attr('href');
					toggleVideo(true, self.attr('href'));
					set_player_cb(playerId.substring(1));
					return false;
				});
				animate(true);
			}
					
			$(".embed-bt").click(function() {
				$($(this).attr("href")).toggle();
				return false;
			});
			
			$(".close-embed-bt").click(function() {
				$($(this).attr("href")).fadeOut();
				return false;
			});
			
			$(".close-video>a").click(function() {
				closeVid($(this));
				return false;
			});
		}
		
	};

})(jQuery);
