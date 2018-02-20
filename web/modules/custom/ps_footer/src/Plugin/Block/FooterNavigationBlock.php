<?php

namespace Drupal\ps_footer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\system\Entity\Menu;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Menu\MenuLinkTree;
use Drupal\Core\Config\ConfigFactory;

/**
 * Provides a 'FooterNavigationBlock' block.
 *
 * @Block(
 *  id = "footer_navigation_block",
 *  admin_label = @Translation("Footer navigation block"),
 * )
 */
class FooterNavigationBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructs a new FooterNavigationBlock object.
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
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   *   The config factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManager $entity_type_manager, MenuLinkTree $menu_link_tree, ConfigFactory $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->menuLinkTree = $menu_link_tree;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('entity_type.manager'), $container->get('menu.link_tree'), $container->get('config.factory'));
  }

  /**
   * Returns string after certain word.
   *
   * @param string $string
   *   Input.
   * @param string $substring
   *   Cut.
   *
   * @return bool|string
   *   Return string.
   */
  private function strafter($string, $substring) {
    $pos = strpos($string, $substring);
    if ($pos === FALSE) {
      return $string;
    }
    else {
      return (substr($string, $pos + strlen($substring)));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->getEditable('ps_general.perlitashopgeneral');
    $build = ['#theme' => 'ps_footer_navigation_block'];
    $data = $config->getRawData();
    $menu_names = [];
    foreach ($data as $key => $value) {
      if (strpos($key, 'menu_') !== FALSE && $data[$key] != FALSE) {
        $menu_names[] = $this->strafter($key, 'menu_');
      }
    }
    if (!empty($menu_names)) {
      foreach ($menu_names as $menu_name) {

        // Load main menu tree.
        $parameters = $this->menuLinkTree->getCurrentRouteMenuTreeParameters($menu_name);
        $parameters->setMinDepth(0);
        $parameters->setMaxDepth(1);
        $parameters->onlyEnabledLinks();

        $tree = $this->menuLinkTree->load($menu_name, $parameters);
        if (empty($tree)) {
          return $build;
        }

        // Check for access.
        $manipulators = [
          ['callable' => 'menu.default_tree_manipulators:checkAccess'],
        ];

        // Build menu.
        $tree = $this->menuLinkTree->transform($tree, $manipulators);
        $menu = $this->menuLinkTree->build($tree);

        $menuItem = Menu::load($menu_name);

        $build['#menus'][] = [
          'title' => $menuItem->label(),
          'items' => $menu['#items'],
          'class' => 'col-md-4 col-sm-6',
        ];
      }
      // Get last item of array, change calss, remove last item and
      // set our new item to be the last.
      $element = array_values(array_slice($build['#menus'], -1))[0];
      $element['class'] = 'col-md-4 hidden-sm';
      array_pop($build['#menus']);
      array_push($build['#menus'], $element);
    }

    return $build;
  }

}
