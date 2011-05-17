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
			  //flashplayer: '<?php print $js_lib_path. '/player.swf'; ?>',
    		//skin: '<?php print $js_lib_path. '/glow/glow.zip'; ?>'
			  backcolor:'<?php print $backcolor; ?>',
			  modes: [
			  		{ type: "html5", skin: '<?php print $js_lib_path. '/glow/glow.zip'; ?>' },
			  		{ type: "flash", src: "<?php print $js_lib_path. '/player.swf'; ?>", skin: '<?php print $js_lib_path. '/glow/glow.zip'; ?>' },
			      { type: "download" }
			    ]
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
				set_jw_player(CURRENT_PLAYER_ID);
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
	
