<?php
/**
 * @file
 * example_pf_jw_embedder_content_type.features.field.inc
 */

/**
 * Implementation of hook_field_default_fields().
 */
function example_pf_jw_embedder_content_type_field_default_fields() {
  $fields = array();

  // Exported field: 'node-test_video_playlist-field_video_playlist'
  $fields['node-test_video_playlist-field_video_playlist'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '-1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_video_playlist',
      'foreign keys' => array(),
      'indexes' => array(),
      'module' => 'pf_jw_embedder',
      'settings' => array(),
      'translatable' => '1',
      'type' => 'pf_jw_embedder',
    ),
    'field_instance' => array(
      'bundle' => 'test_video_playlist',
      'deleted' => '0',
      'description' => '',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'pf_jw_embedder',
          'settings' => array(),
          'type' => 'pf_jw_embedder_formatter_default',
          'weight' => '0',
        ),
        'teaser' => array(
          'label' => 'above',
          'settings' => array(),
          'type' => 'hidden',
          'weight' => 0,
        ),
      ),
      'entity_type' => 'node',
      'field_name' => 'field_video_playlist',
      'label' => 'Video playlist items',
      'required' => 0,
      'settings' => array(
        'user_register_form' => FALSE,
      ),
      'widget' => array(
        'active' => 1,
        'module' => 'pf_jw_embedder',
        'settings' => array(
          'backcolor' => 'ffffff',
          'height' => '360',
          'html5' => 1,
          'width' => '640',
        ),
        'type' => 'pf_jw_embedder_widget_default',
        'weight' => '1',
      ),
    ),
  );

  // Exported field: 'node-test_video_playlist-field_video_slideshow'
  $fields['node-test_video_playlist-field_video_slideshow'] = array(
    'field_config' => array(
      'active' => '1',
      'cardinality' => '-1',
      'deleted' => '0',
      'entity_types' => array(),
      'field_name' => 'field_video_slideshow',
      'foreign keys' => array(),
      'indexes' => array(),
      'module' => 'pf_jw_embedder',
      'settings' => array(),
      'translatable' => '1',
      'type' => 'pf_jw_embedder',
    ),
    'field_instance' => array(
      'bundle' => 'test_video_playlist',
      'deleted' => '0',
      'description' => '',
      'display' => array(
        'default' => array(
          'label' => 'above',
          'module' => 'pf_jw_embedder',
          'settings' => array(),
          'type' => 'pf_jw_embedder_formatter_slideshow',
          'weight' => '1',
        ),
        'teaser' => array(
          'label' => 'above',
          'settings' => array(),
          'type' => 'hidden',
          'weight' => 0,
        ),
      ),
      'entity_type' => 'node',
      'field_name' => 'field_video_slideshow',
      'label' => 'Video slideshow items',
      'required' => 0,
      'settings' => array(
        'user_register_form' => FALSE,
      ),
      'widget' => array(
        'active' => 1,
        'module' => 'pf_jw_embedder',
        'settings' => array(
          'backcolor' => 'ffffff',
          'height' => '275',
          'html5' => 1,
          'width' => '462',
        ),
        'type' => 'pf_jw_embedder_widget_default',
        'weight' => '2',
      ),
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Video playlist items');
  t('Video slideshow items');

  return $fields;
}
