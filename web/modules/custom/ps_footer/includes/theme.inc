<?php

/**
 * @file
 * File theme.inc.
 */

/**
 * In
 */
function ps_footer_preprocess_ps_footer_navigation_block(&$variables) {
  if (!empty($variables['menus'])) {
    foreach ($variables as $menu) {
      $variables['menu_items'][] = [
        //'title' =>
      ];
    }
  }
  $test = 1;
}
