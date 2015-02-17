<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function juraport_theme_preprocess_page(&$variables, $hook) {
  // Hide the title on the frontpage since we're using a basic page node type.
  if ($variables['is_front']) {
    $variables['title'] = FALSE;
  }
}

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
function juraport_theme_preprocess_region(&$variables, $hook) {
  // Remove the no-wrapper template suggestion, so that we can use our own.
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'] = array_diff(
      $variables['theme_hook_suggestions'], 
      array('region__no_wrapper')
    );
  }
}

/**
 * Implements hook_preprocess_node().
 * 
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function juraport_theme_preprocess_node(&$variables, $hook) {
  // Optionally, run node-type-specific preprocess functions, like
  // juraport_preprocess_node_page() or juraport_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}

/**
 * Removes empty fields from the display if user is not logged in.
 */
function juraport_theme_preprocess_node_jura_subject(&$variables, $hook) {
  if (!user_is_logged_in()) {
    $fields = array(
      'field_jura_subject_laws_rules',
      'field_jura_subject_online',
      'field_jura_subject_lawtext_rules',
      'field_jura_subject_loan',
      'field_jura_subject_network',
    );
    foreach ($fields as $field) {
      if (isset($variables['content'][$field]['#items']) && empty($variables['content'][$field]['#items'])) {
        unset($variables['content'][$field]);
      }
    }
  }
}

/**
 * Implements hook_preprocess_field().
 *
 * Places fontawesome icons in front of field collections on jura_subject nodes.
 */
function juraport_theme_preprocess_field(&$variables, $hook) {
  if (isset($variables['element']['#field_name']) && isset($variables['label'])) {
    $label = $variables['label'];
    $field_name = $variables['element']['#field_name'];
    if ($field_name == 'field_jura_subject_laws_rules') {
      $label = '<i class="fa fa-key fa-2x"></i><span class="field-label-text">' . $label . '</span>';
    }
    else if ($field_name == 'field_jura_subject_online') {
      $label = '<i class="fa fa-globe fa-2x"></i><span class="field-label-text">' . $label . '</span>';
    }
    else if ($field_name == 'field_jura_subject_lawtext_rules') {
      $label = '<i class="fa fa-institution fa-2x"></i><span class="field-label-text">' . $label . '</span>';  
    }
    else if ($field_name == 'field_jura_subject_loan') {
      $label = '<i class="fa fa-book fa-2x"></i><span class="field-label-text">' . $label . '</span>'; 
    }
    else if ($field_name == 'field_jura_subject_network') {
      $label = '<i class="fa fa-group fa-2x"></i><span class="field-label-text">' . $label . '</span>';  
    }    
    $variables['label'] = $label;
  }
}

/**
 * Implements theme_menu_tree().
 * 
 * Adds the needed classes to the footer-menu.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @return 
 *   Markup for the footer-menu menu-tree.
 */
function juraport_theme_menu_tree__menu_footer_menu(&$variables) {
  return '<ul class="footer-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function juraport_theme_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  juraport_theme_preprocess_html($variables, $hook);
  juraport_theme_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function juraport_theme_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function juraport_theme_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function juraport_theme_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}
// */
