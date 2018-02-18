<?php

namespace Drupal\ps_main_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Block\BlockManager;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'UserMenuBlock' block.
 *
 * @Block(
 *  id = "user_menu_block",
 *  admin_label = @Translation("User menu block"),
 * )
 */
class UserMenuBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   * Drupal\Core\Render\Renderer definition.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * Constructs a new UserMenuBlock object.
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
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer.
   * @param \Drupal\Core\Session\AccountProxy $current_user
   *   The current user.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManager $entity_type_manager,
    BlockManager $block_manager,
    Renderer $renderer,
    AccountProxy $current_user
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->blockManager = $block_manager;
    $this->renderer = $renderer;
    $this->currentUser = $current_user;
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
      $container->get('renderer'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'ps_user_menu',
    ];
    // You can hard code configuration or you load from settings.
    $config = ['dropdown' => 1];
    $plugin_block = $this->blockManager->createInstance('commerce_cart', $config);
    // Some blocks might implement access check.
    $access_result = $plugin_block->access($this->currentUser);
    // Return empty render array if user doesn't have access.
    // $access_result can be boolean or an AccessResult class.
    if (is_object($access_result) && $access_result->isForbidden() || is_bool($access_result) && !$access_result) {
      // You might need to add some cache tags/contexts.
      return [];
    }

    $build['#cart_block'] = $plugin_block->build();

    if (empty($build['#cart_block']['content'])) {
      $build['#cart_block']['#theme'] = 'commerce_cart_empty_page';
    }

    // You can hard code configuration or you load from settings.
    $config = [];
    $plugin_block = $this->blockManager->createInstance('user_block', $config);
    // Some blocks might implement access check.
    $access_result = $plugin_block->access($this->currentUser);
    // Return empty render array if user doesn't have access.
    // $access_result can be boolean or an AccessResult class.
    if (is_object($access_result) && $access_result->isForbidden() || is_bool($access_result) && !$access_result) {
      // You might need to add some cache tags/contexts.
      return [];
    }

    $build['#user_block'] = $plugin_block->build();

    return $build;
  }

}
