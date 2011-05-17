<?php

/**
 * @file field.tpl.php
 * Default template implementation to display the value of a field.
 *
 * This file is not used and is here as a starting point for customization only.
 * @see theme_field()
 *
 * Available variables:
 * - $items: An array of field values. Use render() to output them.
 * - $label: The item label.
 * - $label_hidden: Whether the label display is set to 'hidden'.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - field: The current template type, i.e., "theming hook".
 *   - field-name-[field_name]: The current field name. For example, if the
 *     field name is "field_description" it would result in
 *     "field-name-field-description".
 *   - field-type-[field_type]: The current field type. For example, if the
 *     field type is "text" it would result in "field-type-text".
 *   - field-label-[label_display]: The current label position. For example, if
 *     the label position is "above" it would result in "field-label-above".
 *
 * Other variables:
 * - $element['#object']: The entity to which the field is attached.
 * - $element['#view_mode']: View mode, e.g. 'full', 'teaser'...
 * - $element['#field_name']: The field name.
 * - $element['#field_type']: The field type.
 * - $element['#field_language']: The field language.
 * - $element['#field_translatable']: Whether the field is translatable or not.
 * - $element['#label_display']: Position of label display, inline, above, or
 *   hidden.
 * - $field_name_css: The css-compatible field name.
 * - $field_type_css: The css-compatible field type.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_field()
 * @see theme_field()
 */

$items_count = count($items);
if ($items_count > 0) {
			
	$js_lib_path = url(libraries_get_path('mediaplayer'), array('absolute' => TRUE));
	$mod_path = drupal_get_path('module', 'pf_jw_embedder');
	
	$player = $js_lib_path . '/player.swf';
	$skin_flash = $js_lib_path . '/glow/glow.zip';
	$skin_html5 = $js_lib_path . '/glow/glow.xml';
		
	drupal_add_js($js_lib_path . '/jwplayer.js');
	drupal_add_css($mod_path . '/templates/video-callout.css');
	drupal_add_js($mod_path . '/templates/video-callout.js');
		
	$first_item = $items[0];

?>

<div class="tabbed-video-callout clearfix <?php print $classes; ?>">

  <div id="interactive-box">
    <div class="info">
	
		<?php foreach ($items as $index => $item) { 
			$display = 'none';
			if ($index == 0):
		  	$display = 'block';
			endif;
	    
			$media_ident = 'pf-video-callout-' . basename($item['media_video_path'], '.mp4') . $item['index'];

	  ?>

      <div id="<?php print $media_ident; ?>-screen" 
      	class="video-callout-screen" 
      	style="display:<?php print $display; ?>">
      	
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
								    height="<?php print $height; ?>" 
								    width="<?php print $width; ?>"
								    id="<?php print $media_ident; ?>" 
								    style="display:<?php print $display; ?>;">
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
  	
		$media_ident = 'pf-video-callout-' . basename($item['media_video_path'], '.mp4') . $item['index'];
  	
		$additional_classes = '';
		if ($index == 0):
			$additional_classes = ' selected first';
		elseif(($index + 1) == $tab_count):
			$additional_classes = ' last';
		endif;
		 ?>
	    <div class="video-callout-tab tab-<?php print ($index + 1) . $additional_classes; ?>">
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
	
	$first_media_ident = 'pf-video-callout-' . basename($first_item['media_video_path'], '.mp4') . '0';
	
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
		  //flashplayer: '<?php print $player; ?>',
    	//skin: '<?php print $skin_flash; ?>'
		  backcolor:'<?php print $backcolor; ?>',
		  modes: [
		  		{ type: "html5", skin: '<?php print $skin_html5; ?>' },
		  		{ type: "flash", src: "<?php print $player; ?>", skin: '<?php print $skin_flash; ?>' },
		      { type: "download" }
		    ]
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
	
