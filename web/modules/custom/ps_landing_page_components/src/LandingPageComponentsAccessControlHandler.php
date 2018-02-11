<?php

namespace Drupal\ps_landing_page_components;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Landing page components entity.
 *
 * @see \Drupal\ps_landing_page_components\Entity\LandingPageComponents.
 */
class LandingPageComponentsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\ps_landing_page_components\Entity\LandingPageComponentsInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished landing page components entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published landing page components entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit landing page components entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete landing page components entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add landing page components entities');
  }

}
