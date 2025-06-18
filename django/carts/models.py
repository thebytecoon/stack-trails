from django.db import models
from django.conf import settings
from products.models import Product


# Create your models here.
class Cart(models.Model):
    product = models.ForeignKey(Product, on_delete=models.DO_NOTHING)
    user = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.DO_NOTHING)
    quantity = models.PositiveIntegerField(default=1)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = "carts"

    @property
    def total_price(self):
        return self.product.price * self.quantity

    @property
    def price(self):
        return self.product.price
