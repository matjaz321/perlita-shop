<?php

namespace Drupal\ps_main_menu\Controller;

use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderItem;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_cart\CartManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CardItemRemoveController.
 */
class CardItemRemoveController extends ControllerBase {

  /**
   * Drupal\commerce_cart\CartManager definition.
   *
   * @var \Drupal\commerce_cart\CartManager
   */
  protected $commerceCartCartManager;

  /**
   * Constructs a new CardItemRemoveController object.
   */
  public function __construct(CartManager $commerce_cart_cart_manager) {
    $this->commerceCartCartManager = $commerce_cart_cart_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('commerce_cart.cart_manager')
    );
  }

  /**
   * Removeitem.
   *
   * @return string
   *   Return Hello string.
   */
  public function removeItem($order, $order_item) {
    $order_entity = Order::load($order);
    $order_item_entity = OrderItem::load($order_item);

    $this->commerceCartCartManager->removeOrderItem($order_entity, $order_item_entity);
    $request = new RedirectResponse(Url::fromRoute('<front>')->toString());
    return $request;
  }

}
