<?php

/**
 * @file
 * Theme.inc ps_general.
 */

use Drupal\views\Views;

/**
 * Implements hook_preprocess().
 */
function ps_general_preprocess_paragraph__shop_view(&$variables) {
  $view = Views::getView('shop');
  if (is_object($view)) {
    $view->setDisplay('shop_view');
    $view->preExecute();
    $view->execute();
    $variables['overview'] = $view->buildRenderable();
  }
}
