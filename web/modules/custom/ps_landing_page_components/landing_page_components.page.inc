<?php

/**
 * @file
 * Contains landing_page_components.page.inc.
 *
 * Page callback for Landing page components entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Landing page components templates.
 *
 * Default template: landing_page_components.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_landing_page_components(array &$variables) {
  // Fetch LandingPageComponents Entity Object.
  $landing_page_components = $variables['elements']['#landing_page_components'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
