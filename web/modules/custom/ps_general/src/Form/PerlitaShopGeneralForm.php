<?php

namespace Drupal\ps_general\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\system\Entity\Menu;
use Drupal\Core\Menu\MenuLinkTree;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PerlitaShopGeneralForm.
 */
class PerlitaShopGeneralForm extends ConfigFormBase {

  /**
   * Drupal\Core\Menu\MenuLinkTree definition.
   *
   * @var \Drupal\Core\Menu\MenuLinkTree
   */
  protected $menuLinkTree;

  /**
   * Constructs a \Drupal\views_ui\Form\BasicSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Menu\MenuLinkTree $menu_link_tree
   *   The menu link tree.
   */
  public function __construct(ConfigFactoryInterface $config_factory, MenuLinkTree $menu_link_tree) {
    parent::__construct($config_factory);
    $this->menuLinkTree = $menu_link_tree;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('menu.link_tree')
    );
  }

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
      '#description' => $this->t('Provide linwatermeternummerk to your Instagram account.'),
      '#default_value' => $config->get('instagram'),
    ];
    $form['footer_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Footer menu settings'),
      '#description' => $this->t('Choose one of the footer menus down bellow and they will be displayed in the middle section of the footer.'),
    ];
    $menus = Menu::loadMultiple();
    $ignored = [
      'account',
      'admin',
      'footer',
      'main',
      'tools',
    ];

    $options = [];
    foreach ($menus as $menu) {
      if (!in_array($menu->id(), $ignored)) {
        $options[$menu->id()] = $menu->label();
      }
    }
    $form['footer_settings']['menus'] = [
      '#type' => 'checkboxes',
      '#options' => $options,
      '#default_value' => !empty($config->get('menus')) ? $config->get('menus') : [],
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

    $config = $this->config('ps_general.perlitashopgeneral');

    $config->clear('menus')->save();
    $menus = $form_state->getValue('menus');

    $options = [];
    if (!empty($menus)) {
      foreach ($menus as $name => $value) {
        if ($value != FALSE) {
          array_push($options, $name);
        }
      }
    }

    $config
      ->set('facebook', $form_state->getValue('facebook'))
      ->set('twitter', $form_state->getValue('twitter'))
      ->set('google-plus', $form_state->getValue('google_plus'))
      ->set('linkedin', $form_state->getValue('linkedin'))
      ->set('instagram', $form_state->getValue('instagram'))
      //->set('menus', ['categories', 'quick_links'])
      ->save();
  }

}
