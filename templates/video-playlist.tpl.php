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

function pf_jw_embedder_playlist_media_ident($url, $prefix, $suffix) {
	$path_parts = pathinfo($url);
	//dpm($path_parts, '$path_parts');
	return $prefix . basename($url, '.' . $path_parts['extension']) . $suffix;
}

$items_count = count($items);
if ($items_count > 0) {
	
	$js_dialog_lib_path = url(libraries_get_path('jquery.simpledialog'), array('absolute' => TRUE));
		
	$mod_path = drupal_get_path('module', 'pf_jw_embedder');
	drupal_add_css($mod_path . '/templates/video-playlist.css');
	
	$first_item = $items[0];

//dpm($html5, '$htnml5');
//dpm($items, '$$items');
?>

<div class="jw-embedder-playlist clearfix <?php print $classes; ?>">
  <div class="interactive-box">
    <div class="jw-embedder-playlist-player">
			
	<?php foreach ($items as $index => $item) {
		$media_ident = pf_jw_embedder_playlist_media_ident($item['media_video_path'], 'pf-video-playlist-', $item['index']);
  
		?>
	  	<video 
		    src="<?php print $item['media_video_path']; ?>" 
		    <?php if (!empty($item['media_image_path'])): ?>
		    poster="<?php print $item['media_image_path']; ?>"
		    <?php endif; ?>
		    height="<?php print $height; ?>" 
		    width="<?php print $width; ?>"
		    id="<?php print $media_ident; ?>" 
		    style="display:<?php print $item['display']; ?>;">
			</video>
	<?php } ?>
    </div>
  </div>
  
  <div class="jw-embedder-current-detail">
		<ul>
  <?php foreach ($items as $index => $item) { 
		?>
	    <li style="display:<?php print $item['display']?>" class="jw-embedder-current-detail-item item-<?php print $index . $item['additional_classes']; ?>">
				<?php if (!empty($item['title'])): ?>
				<h2><?php print $item['title']; ?></h2>
				<?php endif; ?>
		  	<div class="current-detail-controls">
			  	<div class="current-detail-controls-inner clearfix">
			  		<a href="#embed">Embed</a>
			  		<textarea style="display:none"
			  			rows="7" 
			  			cols="55">&lt;embed src=\'<?php print $player; ?>\' width=\'<?php print $width; ?>\' height=\'<?php print $height; ?>\' 
			  			allowscriptaccess=\'always\' allowfullscreen=\'false\' 
			  			flashvars=\'file=<?php print $item['media_video_path']; ?>&amp;skin=<?php print $skin_flash; ?>&amp;autostart=<?php print $autostart; ?>\'/&gt;</textarea>
			  	</div>
		    </div>
	    </li>
  <?php } ?>
		</ul>
  </div>
  
  <?php if ($html5): 
  
  ?>

  <div class="jw-embedder-playlist-list" class="clearfix">
		<ul>
  <?php 
  foreach ($items as $index => $item) { 
		$media_ident = pf_jw_embedder_playlist_media_ident($item['media_video_path'], 'pf-video-playlist-', $item['index']);
  
  	$item_title = $item['title'] ? $item['title'] : 'No title...';
  	$item_description = empty($item['description']) ? FALSE : $item['description'];
  	$create_popup = FALSE;
  	$more_popup = ' (<a class="playlist-item-more" href="#' . $media_ident . '-descr">Bio</a>)';
  	if (!empty($item['short_description'])):
  		$short_item_description = $item['short_description'] . $more_popup;
  		$create_popup = TRUE;
  	elseif (strlen($item_description) > 80):
  		$short_item_description = substr($item_description, 0, 80) . $more_popup;
  		$create_popup = TRUE;
  	else:
  		$short_item_description = $item['description'];
  	endif;
  	
  	?>
	    <li class="jw-embedder-playlist-item item-<?php print $index . $item['additional_classes']; ?>">
      <?php if (!empty($item['video_thumbnail_path'])): ?>
        <a href="<?php print $media_ident; ?>" class="thumbnail play-video">
        	<img alt="<?php print $item_title; ?>" src="<?php print $item['video_thumbnail_path']; ?>"/>
        </a>
      <?php endif; ?>
	      <div class="playlist-item-content">
	        <a href="<?php print $media_ident; ?>" class="title play-video"><?php print $item_title; ?></a>
	      <?php if (!empty($short_item_description)): ?>
	        <a href="<?php print $media_ident; ?>" class="description play-video"><?php print $short_item_description; ?></a>
	      <?php endif; ?>
	      </div>
      <?php if ($create_popup): ?>
      <div style="display:none">
        <div id="<?php print $media_ident; ?>-descr" class="playlist-item-popup" title="<?php print $item_title; ?>">
        	<?php print $item_description; ?>
        </div>
      </div>
      <?php endif; ?>
	    </li>
  <?php 
  } 
  ?>
		</ul>
	</div>


<script type="text/javascript">

jQuery(document).ready(function($) {
	$ = $;
	<?php 
	$first_media_ident = pf_jw_embedder_playlist_media_ident($first_item['media_video_path'], 'pf-video-playlist-', '0');
	?>

	var CURRENT_PLAYER_ID = '<?php print $first_media_ident;?>';
	
	function set_playlist_jw_player(vid_id) {
		var vid = $('#' + vid_id);
		vid
		.css({
			top:0,
			left:0,
		})
		.animate({
		    opacity: 1.0,
		  }, 1000);
		jwplayer(vid_id)
			.setup({
			  flashplayer: '<?php print $player; ?>'
    		,skin: '<?php print $skin_flash; ?>'
			  ,backcolor:'<?php print $backcolor; ?>'
				,screencolor: '<?php print $screencolor; ?>'
				,frontcolor: '<?php print $frontcolor; ?>'
				,lightcolor: '<?php print $lightcolor; ?>'
				,'controlbar.position': '<?php print $controlbar_position; ?>'
				,'controlbar.idlehide': '<?php print $controlbar_idlehide; ?>'
				,'display.showmute': '<?php print $display_showmute; ?>'
				,autostart: '<?php print $autostart; ?>'
			  /*,modes: [
			  		{ type: "html5", skin: '<?php print $skin_html5; ?>' }
			  		,{ type: "flash", src: "<?php print $player; ?>", skin: '<?php print $skin_flash; ?>' }
			      ,{ type: "download" }
			    ]*/
			});
		$('.jw-embedder-playlist-player>div, .jw-embedder-playlist-player object')
			.css('background-color', 'rgb(<?php print $backcolor_rgb; ?>)');
		$('.jw-embedder-playlist-player object')
			.attr('bgcolor', '#<?php print $backcolor; ?>');
	}

	$('.jw-embedder-playlist-item a.play-video').live('click', function() {
		var self = $(this);
		if (CURRENT_PLAYER_ID != self.attr('href')) {
			jwplayer().stop();
			jwplayer().remove();
			$('#' + CURRENT_PLAYER_ID).animate({
			    opacity: 0
			  }, 500, function() {
					$('.jw-embedder-playlist-item').removeClass('selected');
					$(this).css({height:0, width:0});
					self.parents('li').addClass('selected');
					CURRENT_PLAYER_ID = self.attr('href');
					set_playlist_jw_player(CURRENT_PLAYER_ID);
					return false;
				});
		}
		return false;
	});

	$('.jw-embedder-playlist-item a.playlist-item-more').live('click', function() {
		$($(this).attr('href')).dialog();
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
	 flashplayer: '<?php print $player; ?>'
	,skin: '<?php print $skin_flash; ?>'
  ,backcolor:'<?php print $backcolor; ?>'
	,screencolor: '<?php print $screencolor; ?>'
	,frontcolor: '<?php print $frontcolor; ?>'
	,lightcolor: '<?php print $lightcolor; ?>'
	,'controlbar.position': '<?php print $controlbar_position; ?>'
	,'controlbar.idlehide': '<?php print $controlbar_idlehide; ?>'
	,'display.showmute': '<?php print $display_showmute; ?>'
	,autostart: '<?php print $autostart; ?>'
  ,playlist: <?php print drupal_json_encode($playlist); ?>
  ,"playlist.position": "<?php print $playlist_position;?>"
  ,"playlist.size": <?php print $playlist_size;?>
});
</script>

  <?php endif; ?>
	
</div>

<?php 
}
?>
	
