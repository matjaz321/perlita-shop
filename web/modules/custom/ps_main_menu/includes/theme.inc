<?php

/**
 * @file
 * Contains functions which adds new variable to preprocess.
 */

use Drupal\Core\Link;
use Drupal\Core\Render\Markup;

/**
 * Preprocessor for ps_main_menu.
 */
function ps_main_menu_preprocess_ps_main_menu(&$variables) {
  // Get all links.
  $links = $variables['links'];
  if (empty($links)) {
    return;
  }

  // Go through each menu item.
  $menu = [];
  foreach ($links as $key => $link) {
    // Check if menu item is expended if its not just add link to array.
    if (!$link['is_expanded'] || empty($link['below'])) {
      $menu[$key]['link'] = Link::fromTextAndUrl($link['title'], $link['url'])->toRenderable();
      $menu[$key]['expended'] = FALSE;
    }
    // Otherwise go add link and all link childrens to the array.
    else {
      $title = Markup::create($link['title'] . '<i class="pe-7s-angle-down"></i>');
      $menu[$key] = [
        'link' => Link::fromTextAndUrl($title, $link['url'])->toRenderable(),
        'expended' => TRUE,
      ];
      foreach ($link['below'] as $children_key => $children) {
        $menu[$key]['children'][$children_key] = Link::fromTextAndUrl($children['title'], $children['url'])->toRenderable();
      }
    }
  }
  $variables['menu_links'] = $menu;
}
