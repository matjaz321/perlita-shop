<?php

namespace Drupal\ps_landing_page_components\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Landing page components type entity.
 *
 * @ConfigEntityType(
 *   id = "landing_page_components_type",
 *   label = @Translation("Landing page components type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ps_landing_page_components\LandingPageComponentsTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsTypeForm",
 *       "edit" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsTypeForm",
 *       "delete" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ps_landing_page_components\LandingPageComponentsTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "landing_page_components_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "landing_page_components",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/landing_page_components_type/{landing_page_components_type}",
 *     "add-form" = "/admin/structure/landing_page_components_type/add",
 *     "edit-form" = "/admin/structure/landing_page_components_type/{landing_page_components_type}/edit",
 *     "delete-form" = "/admin/structure/landing_page_components_type/{landing_page_components_type}/delete",
 *     "collection" = "/admin/structure/landing_page_components_type"
 *   }
 * )
 */
class LandingPageComponentsType extends ConfigEntityBundleBase implements LandingPageComponentsTypeInterface {

  /**
   * The Landing page components type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Landing page components type label.
   *
   * @var string
   */
  protected $label;

}
