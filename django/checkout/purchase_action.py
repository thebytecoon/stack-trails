from carts.models import Cart
from orders.models import Order, OrderItem
from django.db import transaction
from products.models import Product
from django.contrib.auth.models import User
from .signals import order_was_purchased

def purchase(request, user: User, data):
    carts = Cart.objects.filter(user_id=user.id)

    with transaction.atomic():
        products_id = carts.values_list('product_id', flat=True)
        products_id = list(products_id)
        Product.objects.filter(id__in=products_id).select_for_update()

        total = 0
        for cart in carts:
            if cart.quantity > cart.product.stock:
                raise Exception(f"No hay suficiente stock del producto {cart.product.name}")
            total += cart.total_price()

        data["user_id"] = user.id
        data["total"] = total
        data["status"] = "Paid"
        del data["card_number"]
        del data["expiry_date"]
        del data["cvv"]

        order = Order(**data)
        order.save()
        
        for cart in carts:
            OrderItem.objects.create(
                order=order,
                product=cart.product,
                quantity=cart.quantity,
                final_price=cart.total_price()
            )
            product = cart.product
            product.stock -= cart.quantity
            product.save()
            cart.delete()

    order_was_purchased.send(sender=request, order=order)