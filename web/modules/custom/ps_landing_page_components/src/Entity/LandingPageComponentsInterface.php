<?php

namespace Drupal\ps_landing_page_components\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Landing page components entities.
 *
 * @ingroup ps_landing_page_components
 */
interface LandingPageComponentsInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Landing page components name.
   *
   * @return string
   *   Name of the Landing page components.
   */
  public function getName();

  /**
   * Sets the Landing page components name.
   *
   * @param string $name
   *   The Landing page components name.
   *
   * @return \Drupal\ps_landing_page_components\Entity\LandingPageComponentsInterface
   *   The called Landing page components entity.
   */
  public function setName($name);

  /**
   * Gets the Landing page components creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Landing page components.
   */
  public function getCreatedTime();

  /**
   * Sets the Landing page components creation timestamp.
   *
   * @param int $timestamp
   *   The Landing page components creation timestamp.
   *
   * @return \Drupal\ps_landing_page_components\Entity\LandingPageComponentsInterface
   *   The called Landing page components entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Landing page components published status indicator.
   *
   * Unpublished Landing page components are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Landing page components is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Landing page components.
   *
   * @param bool $published
   *   TRUE to set this Landing page components to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ps_landing_page_components\Entity\LandingPageComponentsInterface
   *   The called Landing page components entity.
   */
  public function setPublished($published);

}
