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

function pf_jw_embedder_callout_media_ident($url, $prefix, $suffix) {
	dpm(pathinfo($url, PATHINFO_EXTENSION), 'pathinfo($url, PATHINFO_EXTENSION)');
	return $prefix . basename($url, '.' . pathinfo($url, PATHINFO_EXTENSION)) . $suffix;
}

$items_count = count($items);
if ($items_count > 0) {
			
	$mod_path = drupal_get_path('module', 'pf_jw_embedder');
	drupal_add_css($mod_path . '/templates/video-callout.css');
	drupal_add_js($mod_path . '/templates/video-callout.js');
		
	$first_item = $items[0];
?>

<div class="tabbed-video-callout clearfix <?php print $classes; ?>">
  <div id="interactive-box">
    <div class="info">
		<?php foreach ($items as $index => $item) {
			$media_ident = pf_jw_embedder_callout_media_ident($item['media_video_path'], 'pf-video-callout-', $item['index']);
	  ?>
      <div id="<?php print $media_ident; ?>-screen" 
      	class="video-callout-screen" 
      	style="display:<?php print $item['display']; ?>">
        <div class="video-description" style="background:transparent url('<?php print $item['media_image_path']; ?>') !important;display:block">
	        <div class="video-description-inner">
	        	<?php if (!empty($item['title'])): ?>
	          	<h2><?php print $item['title']; ?></h2>
	          <?php endif; ?>
	        	<?php if (!empty($item['description'])): ?>
	          	<p><?php print $item['description']; ?></p>
	          <?php endif; ?>
	          <p class="watch-video"><a href="#<?php print $media_ident; ?>"><span>Watch Video</span></a></p>
	        </div>
        </div>
        <div class="video-player clearfix" style="background:transparent url('<?php print $item['media_video_bg_path']; ?>') !important;display: none;">
	        <div class="video-player-inner">
	          <div class="video-wrapper clearfix ">
	    				<div class="jw-embedder-callout-player">
		            <div id="cont-object-<?php print $media_ident; ?>">
						            <!-- 
								    poster="<?php print $item['media_image_path']; ?>" -->
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
							  	
		            </div>
	            </div>
	            <div class="close-video">
	              <a href="#<?php print $media_ident; ?>"><span>CLOSE VIDEO</span></a>
	            </div>
	            <div class="embed-wrapper">
	              <div class="embed-code-bt">
	                <a href="#<?php print $media_ident; ?>-embedcode" class="embed-bt"><span>Embed video</span></a>
	                <div id="<?php print $media_ident; ?>-embedcode" style="display:none;float:right;" class="embedcode">
	                  <a class="close-embed-bt" href="#<?php print $media_ident; ?>-embedcode"><span>CLOSE</span></a>
	                  <textarea rows="7" cols="55">&lt;embed src=\'<?php print $player; ?>\' width=\'462\' height=\'275\' allowscriptaccess=\'always\' allowfullscreen=\'false\' flashvars=\'file=<?php print $item['media_video_path']; ?>&amp;skin=<?php print $skin_flash; ?>&amp;autostart=true\'/&gt;</textarea>
	                </div>
	              </div>
	            </div>
            </div>
          </div>
        </div>
      </div>

    <?php } ?>

    </div>
  </div>
  
  <?php 
//dpm($items);
  
  $tab_count = count($items);
  if ($tab_count > 1): 
  ?>
  <div class="video-callout-controls tabs-<?php print $tab_count;?> clearfix">
  	<div class="video-callout-tabs">
  <?php foreach ($items as $index => $item) {
		$media_ident = pf_jw_embedder_callout_media_ident($item['media_video_path'], 'pf-video-callout-', $item['index']);
		 ?>
	    <div class="video-callout-tab tab-<?php print ($index + 1) . $item['additional_classes']; ?>">
	      <a href="#<?php print $media_ident; ?>-screen" >
	        <span class="h3"><?php print $item['short_title'] ? $item['short_title'] : $item['title']; ?></span>
	        <span class="h4"><?php print $item['short_description'] ? $item['short_description'] : '&#160;'; ?></span>
	      </a>
	    </div>
  <?php } ?>
  	</div>
	</div>
  <?php endif;?>
  
<script type="text/javascript">
	<?php 
	$first_media_ident = pf_jw_embedder_callout_media_ident($first_item['media_video_path'], 'pf-video-callout-', '0');
	?>

function set_callout_jw_player(vid_id) {
	jQuery('#' + vid_id).parent()
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
		,'controlbar.position': '<?php print $controlbar_position; ?>'
		,'controlbar.idlehide': '<?php print $controlbar_idlehide; ?>'
		,'display.showmute': '<?php print $display_showmute; ?>'
		,autostart: '<?php print $autostart; ?>'
	  /*,modes: [
	  		{ type: "html5", skin: '<?php print $skin_html5; ?>' }
	  		,{ type: "flash", src: "<?php print $player; ?>", skin: '<?php print $skin_flash; ?>' }
	      ,{ type: "download" }
	    ]*/
		}).play();
	jQuery('div.tabbed-video-callout>div.interactive-box>div.info>div, #jw-embedder-playlist-player object')
		.css('background-color', 'rgb(<?php print $backcolor_rgb; ?>)');
	jQuery('div.tabbed-video-callout>div.interactive-box>div.info object')
		.attr('bgcolor', '#<?php print $backcolor; ?>');

}


jQuery(document).ready(function() {
	slideshow.start(set_callout_jw_player);
});
	
</script>
  
</div>

<?php 
}
?>
	
