from carts.models import Cart
from .utils import get_cart


def cart_products(request):
    cart = get_cart(request)

    carts = cart.get_carts()

    cart_total = 0
    for cart in carts:
        cart_total += cart.total_price

    return {
        "user_carts": carts,
        "user_cart_total": cart_total,
    }
