from orders.models import Order
from django.db import transaction
from django.contrib.auth.models import User
from carts.repositories.base import CartRepository


@transaction.atomic
def create_order(user: User, cart: CartRepository) -> Order:

    order = Order(user=user)
    order.save()

    carts = cart.get_carts()

    for cart in carts:
        order.add_cart_product(cart)

    order.save()

    return order
