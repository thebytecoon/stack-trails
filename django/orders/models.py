from django.db import models
from django.conf import settings
from products.models import Product
from enum import StrEnum
from django.db import transaction
from datetime import timedelta
from django.utils import timezone


class OrderStatusEnum(StrEnum):
    INITIAL = "initial"
    PAID = "paid"
    CANCELLED = "cancelled"

    @classmethod
    def get_labels(cls):
        match cls:
            case cls.INITIAL:
                return "Inicial"
            case cls.PAID:
                return "Pagada"
            case cls.CANCELLED:
                return "Cancelada"

    @classmethod
    def choices(cls):
        return [(tag, tag.value) for tag in cls]


class Order(models.Model):
    total = models.DecimalField(default=0.0, max_digits=10, decimal_places=2)
    subtotal = models.DecimalField(default=0.0, max_digits=10, decimal_places=2)
    delivery_price = models.DecimalField(default=0, max_digits=10, decimal_places=2)
    user = models.ForeignKey(
        settings.AUTH_USER_MODEL, on_delete=models.DO_NOTHING, related_name="orders"
    )
    tax = models.DecimalField(default=0, max_digits=10, decimal_places=2, null=True)
    status = models.CharField(default=OrderStatusEnum.INITIAL, max_length=255)
    code = models.CharField(max_length=255, unique=True, null=True)
    payment_type = models.CharField(max_length=255, null=True)
    names = models.CharField(max_length=255, null=True)
    country = models.CharField(max_length=255, null=True)
    city = models.CharField(max_length=255, null=True)
    address_1 = models.CharField(max_length=255, null=True)
    address_2 = models.CharField(max_length=255, null=True)
    zip_code = models.CharField(max_length=255, null=True)
    phone = models.CharField(max_length=255, null=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = "orders"

    @property
    def short_code(self):
        return self.code[:18]

    def add_cart_product(self, cart):
        product = cart.product
        total_price = float(product.price * cart.quantity)

        order_item = self.order_items.create(
            product=product,
            quantity=cart.quantity,
            unit_price=product.price,
            total_price=total_price,
        )

        self.subtotal += total_price
        self.total += total_price

        return order_item

    def pay(self):
        if self.order_items.count() == 0:
            raise Exception("La orden no puede ser pagada porque no posee productos")

        if not self.status == OrderStatusEnum.INITIAL:
            raise Exception("Esta orden ya ha sido procesada")

        with transaction.atomic():
            for order_item in self.order_items.all():
                product = order_item.product

                if product.stock < order_item.quantity:
                    raise Exception(
                        f"El producto {product.name} no tiene suficiente stock para completar la orden"
                    )

                product.stock -= order_item.quantity
                product.save()

            self.status = OrderStatusEnum.PAID
            self.save()

    def cancel(self):
        if not self.status == self.STATUS_INITIAL:
            raise Exception("Esta orden ya ha sido procesada")

        self.status = self.STATUS_CANCELLED
        self.save()

    def is_paid(self):
        return self.status == self.STATUS_PAID

    def is_cancelled(self):
        return self.status == self.STATUS_CANCELLED

    @property
    def shipped_at(self):
        return timezone.now() + timedelta(days=3)

    @property
    def processed_at(self):
        return timezone.now() + timedelta(days=1)

    @property
    def delivered_at(self):
        return timezone.now() + timedelta(days=5)

    @property
    def formatted_shipping_price(self):
        if not self.delivery_price:
            return "Free"

        return f"${self.delivery_price:.2f}"


class OrderItem(models.Model):
    product = models.ForeignKey(
        Product, on_delete=models.DO_NOTHING, related_name="order_items"
    )
    order = models.ForeignKey(
        Order, on_delete=models.DO_NOTHING, related_name="order_items"
    )
    unit_price = models.DecimalField(max_digits=10, decimal_places=2)
    total_price = models.DecimalField(max_digits=10, decimal_places=2)
    quantity = models.PositiveIntegerField()

    class Meta:
        db_table = "order_items"


class ShippingOption(models.Model):
    name = models.CharField(max_length=255)
    description = models.CharField(null=True)
    price = models.DecimalField(max_digits=10, decimal_places=2)

    class Meta:
        db_table = "shipping_options"

    def __str__(self):
        return self.name
