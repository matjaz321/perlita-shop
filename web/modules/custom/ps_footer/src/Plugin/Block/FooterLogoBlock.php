<?php

namespace Drupal\ps_footer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Block\BlockManager;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Config\ConfigFactory;

/**
 * Provides a 'FooterLogoBlock' block.
 *
 * @Block(
 *  id = "footer_logo_block",
 *  admin_label = @Translation("Footer logo block"),
 * )
 */
class FooterLogoBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Block\BlockManager definition.
   *
   * @var \Drupal\Core\Block\BlockManager
   */
  protected $blockManager;

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $config;

  /**
   * Constructs a new FooterLogoBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Block\BlockManager $block_manager
   *   The block manager.
   * @param \Drupal\Core\Session\AccountProxy $current_user
   *   The current user.
   * @param \Drupal\Core\Config\ConfigFactory $config
   *   The config.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManager $entity_type_manager,
    BlockManager $block_manager,
    AccountProxy $current_user,
    ConfigFactory $config
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->blockManager = $block_manager;
    $this->currentUser = $current_user;
    $this->config = $config;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('plugin.manager.block'),
      $container->get('current_user'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $site_config = $this->config->get('system.site');

    $config = $this->config->getEditable('ps_general.perlitashopgeneral');
    $data = $config->getRawData();

    $social_media = [];
    foreach ($data as $name => $value) {
      if (!empty($value)) {
        $social_media[] = [
          'platform' => $name,
          'url' => $value,
        ];
      }
    }

    $build = [
      '#theme' => 'ps_footer_logo_block',
      '#url' => theme_get_setting('logo.url'),
      '#site_slogan' => $site_config->get('slogan'),
      '#social_media' => $social_media,
    ];


    return $build;
  }

}
