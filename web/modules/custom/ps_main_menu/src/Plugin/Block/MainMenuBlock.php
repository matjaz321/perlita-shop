<?php

namespace Drupal\ps_main_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Menu\MenuLinkTree;

/**
 * Provides a 'MainMenuBlock' block.
 *
 * @Block(
 *  id = "main_menu_block",
 *  admin_label = @Translation("Main menu block"),
 * )
 */
class MainMenuBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Menu\MenuLinkTree definition.
   *
   * @var \Drupal\Core\Menu\MenuLinkTree
   */
  protected $menuLinkTree;

  /**
   * Constructs a new MainMenuBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Menu\MenuLinkTree $menu_link_tree
   *   The menu link tree.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManager $entity_type_manager, 
	  MenuLinkTree $menu_link_tree
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->menuLinkTree = $menu_link_tree;
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
      $container->get('menu.link_tree')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    // Load main menu tree.
    $menu_name = 'main';
    $parameters = $this->menuLinkTree->getCurrentRouteMenuTreeParameters($menu_name);
    $parameters->setMinDepth(0);
    $parameters->setMaxDepth(3);
    $parameters->onlyEnabledLinks();

    $tree = $this->menuLinkTree->load($menu_name, $parameters);
    if (empty($tree)) {
      return $build;
    }

    // Check for access.
    $manipulators = array(
      array('callable' => 'menu.default_tree_manipulators:checkAccess'),
    );

    // Build menu.
    $tree = $this->menuLinkTree->transform($tree, $manipulators);
    $menu = $this->menuLinkTree->build($tree);

    // Return builded menu to preprocess.
    $build = [
      '#theme' => 'ps_main_menu',
      '#links' => $menu['#items'],
    ];
    return $build;
  }

}
