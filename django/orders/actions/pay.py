from addresses.models import Address
from payments.models import PaymentMethod
from orders.models import ShippingOption, Order
from django.db import transaction


def pay_order(
    order: Order,
    address: Address,
    payment_method: PaymentMethod,
    shipping_option: ShippingOption,
) -> Order:

    if payment_method.is_expired:
        raise ValueError("El método de pago ha expirado")

    with transaction.atomic():
        order.names = address.names
        order.country = address.country
        order.city = address.city
        order.address_1 = address.address_line_1
        order.address_2 = address.address_line_2
        order.zip_code = address.postal_code
        order.phone = address.phone_number

        order.delivery_price = shipping_option.price

        order.pay()

    return order
