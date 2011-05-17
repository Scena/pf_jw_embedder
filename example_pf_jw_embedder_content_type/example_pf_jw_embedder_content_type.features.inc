<?php
/**
 * @file
 * example_pf_jw_embedder_content_type.features.inc
 */

/**
 * Implementation of hook_node_info().
 */
function example_pf_jw_embedder_content_type_node_info() {
  $items = array(
    'test_video_playlist' => array(
      'name' => t('Test video playlist'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
