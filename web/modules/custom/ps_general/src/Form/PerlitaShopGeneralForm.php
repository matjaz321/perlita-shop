<?php

namespace Drupal\ps_general\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PerlitaShopGeneralForm.
 */
class PerlitaShopGeneralForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ps_general.perlitashopgeneral',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'perlita_shop_general_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ps_general.perlitashopgeneral');
    $form['social_media'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Social Media'),
      '#description' => $this->t('There are all settings for social media'),
    ];
    $form['social_media']['facebook'] = [
      '#type' => 'url',
      '#title' => $this->t('Facebook'),
      '#description' => $this->t('Enter link to your Facebook page.'),
      '#default_value' => $config->get('facebook'),
    ];
    $form['social_media']['twitter'] = [
      '#type' => 'url',
      '#title' => $this->t('Twitter'),
      '#description' => $this->t('Provide link to your Twitter account.'),
      '#default_value' => $config->get('twitter'),
    ];
    $form['social_media']['google_plus'] = [
      '#type' => 'url',
      '#title' => $this->t('Google Plus'),
      '#description' => $this->t('Provide link to your Google Plus account.'),
      '#default_value' => $config->get('google-plus'),
    ];
    $form['social_media']['linkedin'] = [
      '#type' => 'url',
      '#title' => $this->t('LinkedIn'),
      '#description' => $this->t('Provide link to your LinkedIn account.'),
      '#default_value' => $config->get('linkedin'),
    ];
    $form['social_media']['instagram'] = [
      '#type' => 'url',
      '#title' => $this->t('Instagram'),
      '#description' => $this->t('Provide link to your Instagram account.'),
      '#default_value' => $config->get('instagram'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('ps_general.perlitashopgeneral')
      ->set('facebook', $form_state->getValue('facebook'))
      ->set('twitter', $form_state->getValue('twitter'))
      ->set('google-plus', $form_state->getValue('google_plus'))
      ->set('linkedin', $form_state->getValue('linkedin'))
      ->set('instagram', $form_state->getValue('instagram'))
      ->save();
  }

}
