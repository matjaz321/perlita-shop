<?php

namespace Drupal\ps_landing_page_components;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Landing page components entities.
 *
 * @ingroup ps_landing_page_components
 */
class LandingPageComponentsListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Landing page components ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ps_landing_page_components\Entity\LandingPageComponents */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.landing_page_components.edit_form',
      ['landing_page_components' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
