<?php

namespace Drupal\ps_landing_page_components\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Landing page components entities.
 */
class LandingPageComponentsViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
