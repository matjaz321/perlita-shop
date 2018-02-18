<?php

namespace Drupal\ps_main_menu\Controller;

use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderItem;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_store\Entity\Store;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_cart\CartManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
   * Remove item.
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

  /**
   * Add item.
   *
   * @return string
   *   Return Hello string.
   */
  public function addItem(ProductVariation $variation) {
    $store_id = 1;
    $order_type = 'default';

    $cart_provider = \Drupal::service('commerce_cart.cart_provider');

    $store = Store::load($store_id);
    // This is special: We must know if there is already a cart for the provided
    // order type and store:
    $cart = $cart_provider->getCart($order_type, $store);
    if (!$cart) {
      $cart = $cart_provider->createCart($order_type, $store);
    }

    $order_item = OrderItem::create([
      'type' => 'default',
      'purchased_entity' => (string) $variation->id(),
      'quantity' => 1,
      'unit_price' => $variation->getPrice(),
    ]);
    $order_item->save();
    $this->commerceCartCartManager->addOrderItem($cart, $order_item);

    drupal_set_message(t('Product added to the cart.'));
    $request = new RedirectResponse(Url::fromRoute('commerce_cart.page')->toString());
    return $request;
  }

}
