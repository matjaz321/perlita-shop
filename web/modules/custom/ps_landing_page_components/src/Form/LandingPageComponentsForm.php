<?php

namespace Drupal\ps_landing_page_components\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Landing page components edit forms.
 *
 * @ingroup ps_landing_page_components
 */
class LandingPageComponentsForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\ps_landing_page_components\Entity\LandingPageComponents */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Landing page components.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Landing page components.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.landing_page_components.canonical', ['landing_page_components' => $entity->id()]);
  }

}
