<?php

namespace Drupal\ps_landing_page_components\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Landing page components entity.
 *
 * @ingroup ps_landing_page_components
 *
 * @ContentEntityType(
 *   id = "landing_page_components",
 *   label = @Translation("Landing page components"),
 *   bundle_label = @Translation("Landing page components type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ps_landing_page_components\LandingPageComponentsListBuilder",
 *     "views_data" = "Drupal\ps_landing_page_components\Entity\LandingPageComponentsViewsData",
 *     "translation" = "Drupal\ps_landing_page_components\LandingPageComponentsTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsForm",
 *       "add" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsForm",
 *       "edit" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsForm",
 *       "delete" = "Drupal\ps_landing_page_components\Form\LandingPageComponentsDeleteForm",
 *     },
 *     "access" = "Drupal\ps_landing_page_components\LandingPageComponentsAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ps_landing_page_components\LandingPageComponentsHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "landing_page_components",
 *   data_table = "landing_page_components_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer landing page components entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/landing_page_components/{landing_page_components}",
 *     "add-page" = "/admin/structure/landing_page_components/add",
 *     "add-form" = "/admin/structure/landing_page_components/add/{landing_page_components_type}",
 *     "edit-form" = "/admin/structure/landing_page_components/{landing_page_components}/edit",
 *     "delete-form" = "/admin/structure/landing_page_components/{landing_page_components}/delete",
 *     "collection" = "/admin/structure/landing_page_components",
 *   },
 *   bundle_entity_type = "landing_page_components_type",
 *   field_ui_base_route = "entity.landing_page_components_type.edit_form"
 * )
 */
class LandingPageComponents extends ContentEntityBase implements LandingPageComponentsInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Landing page components entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Landing page components entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Landing page components is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
