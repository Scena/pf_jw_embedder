<?php

/**
 * @file field.tpl.php
 * Default template implementation to display the value of a field.
 * 
 * See pf_jw_embedder.module's pf_jw_embedder_field_formatter_view function 
 * the current list of variables being sent to this template.
 * 
 * @see template_preprocess_field()
 * @see theme_field()
 */
$items_count = count($items);
if ($items_count > 0) {
		
	$js_lib_path = url(libraries_get_path('mediaplayer'), array('absolute' => TRUE));
	$mod_path = drupal_get_path('module', 'pf_jw_embedder');
	
	$player = $js_lib_path . '/player.swf';
	if ($skin_url):
		$skin_name = basename($skin_url);
		$skin_flash = $skin_url . '/' . $skin_name . '.zip';
		$skin_html5 = $skin_url . '/' . $skin_name . '.xml';
	else:
		$skin_flash = $js_lib_path . '/glow/glow.zip';
		$skin_html5 = $js_lib_path . '/glow/glow.xml';
	endif;
		
	drupal_add_js($js_lib_path . '/jwplayer.js');
	drupal_add_css($mod_path . '/templates/video-playlist.css');
	//drupal_add_js(drupal_get_path('module', 'pf_jw_embedder') . '/templates/video-playlist.js');
		
	$first_item = $items[0];

//dpm($html5, '$htnml5');
?>

<div class="jw-embedder-playlist clearfix <?php print $classes; ?>">
  <div id="interactive-box">
    <div id="jw-embedder-playlist-player">
			
	<?php foreach ($items as $index => $item) { 
		$display = 'none';
		if ($index == 0):
	  	$display = 'block';
		endif;
		?>
	  	<video 
		    src="<?php print $item['media_video_path']; ?>" 
		    poster="<?php print $item['media_image_path']; ?>"
		    height="<?php print $height; ?>" 
		    width="<?php print $width; ?>"
		    id="pf-video-<?php print ($index + 1); ?>" 
		    style="display:<?php print $display; ?>;">
			</video>
	  	
	<?php } ?>
    </div>
  </div>
  
  <?php if ($html5): ?>

  <div id="jw-embedder-playlist-list" class="clearfix">
		<ul>
  <?php foreach ($items as $index => $item) {
		$additional_classes = $index % 2 ? ' odd' : ' even';
		if ($index == 0):
			$additional_classes .= ' first selected';
		elseif(($index + 1) == $items_count):
			$additional_classes .= ' last';
		endif;
		 ?>
	    <li class="jw-embedder-playlist-item item-<?php print ($index + 1) . $additional_classes; ?>">
	      <a href="pf-video-<?php print ($index + 1); ?>">
	      <?php if ($item['video_thumbnail_path']): ?>
	        <span class="thumbnail"><?php print $item['video_thumbnail_path']; ?></span>
	      <?php endif; ?>
	        <span class="title"><?php print $item['title'] ? $item['title'] : 'No title...'; ?></span>
	      <?php if ($item['description']): ?>
	        <span class="description"><?php print $item['description']; ?></span>
	      <?php endif; ?>
	      </a>
	    </li>

  <?php } ?>
		</ul>
	</div>


<script type="text/javascript">

jQuery(document).ready(function($) {

	var CURRENT_PLAYER_ID = 'pf-video-1';
	
	function set_playlist_jw_player(vid_id) {
		var vid = $('#' + vid_id);
		vid
		.css({
			top:0,
			left:0,
		})
		.animate({
		    opacity: 100,
		  }, 1000);

		jwplayer(vid_id).setup({
			  flashplayer: '<?php print $player; ?>'
    		,skin: '<?php print $skin_flash; ?>'
			  ,backcolor:'<?php print $backcolor; ?>'
				,screencolor: '<?php print $screencolor; ?>'
				,frontcolor: '<?php print $frontcolor; ?>'
				,lightcolor: '<?php print $lightcolor; ?>'
			  /*,modes: [
			  		{ type: "html5", skin: '<?php print $skin_html5; ?>' }
			  		,{ type: "flash", src: "<?php print $player; ?>", skin: '<?php print $skin_flash; ?>' }
			      ,{ type: "download" }
			    ]*/
			});
		$('#jw-embedder-playlist-player>div, #jw-embedder-playlist-player object').css('background-color', 'rgb(<?php print $backcolor_rgb; ?>)');
		$('#jw-embedder-playlist-player object').attr('bgcolor', '#<?php print $backcolor; ?>');
		/*
		vid.parent().fadeIn('fast', 'linear');
		*/
	}

	$('.jw-embedder-playlist-item>a').live('click', function() {
		var self = $(this);
		jwplayer().stop();
		jwplayer().remove();
		$('#' + CURRENT_PLAYER_ID).animate({
		    opacity: 0
		  }, 500, function() {
				$('.jw-embedder-playlist-item').removeClass('selected');
				$(this).css({height:0, width:0});
				self.parent().addClass('selected');
				var CURRENT_PLAYER_ID = self.attr('href');
				set_playlist_jw_player(CURRENT_PLAYER_ID);
			});
		return false;
	});

	set_playlist_jw_player(CURRENT_PLAYER_ID);
	
});
</script>


  <?php else: ?>
	
<script type="text/javascript">

<?php 

$playlist = array();
foreach ($items as $index => $item) {
	$playlist[$index]['file'] = $item['media_video_path'];
	$playlist[$index]['title'] = $item['title'];
	$playlist[$index]['description'] = $item['description'];
	if (!empty($item['media_image_path'])) {
		$playlist[$index]['image'] = $item['media_image_path'];
	}
}

?>

jwplayer('jw-embedder-playlist-player').setup({
  flashplayer: '<?php print $js_lib_path. '/player.swf'; ?>',
  height: <?php print $height; ?>,
  width: <?php print $width; ?>,
  playlist: <?php print drupal_json_encode($playlist); ?>,
  "playlist.position": "bottom",
  "playlist.size": 200
});
</script>

  <?php endif; ?>
	
</div>

<?php 
}
?>
	
