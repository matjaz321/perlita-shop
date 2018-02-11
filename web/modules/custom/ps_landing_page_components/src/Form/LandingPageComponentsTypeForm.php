<?php

namespace Drupal\ps_landing_page_components\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LandingPageComponentsTypeForm.
 */
class LandingPageComponentsTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $landing_page_components_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $landing_page_components_type->label(),
      '#description' => $this->t("Label for the Landing page components type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $landing_page_components_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\ps_landing_page_components\Entity\LandingPageComponentsType::load',
      ],
      '#disabled' => !$landing_page_components_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $landing_page_components_type = $this->entity;
    $status = $landing_page_components_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Landing page components type.', [
          '%label' => $landing_page_components_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Landing page components type.', [
          '%label' => $landing_page_components_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($landing_page_components_type->toUrl('collection'));
  }

}
