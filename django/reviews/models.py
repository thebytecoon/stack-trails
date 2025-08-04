from django.db import models
from django.conf import settings
from products.models import Product
from orders.models import OrderItem


class Review(models.Model):
    user = models.ForeignKey(
        settings.AUTH_USER_MODEL, on_delete=models.DO_NOTHING, related_name="reviews"
    )
    product = models.ForeignKey(Product, on_delete=models.CASCADE, related_name="reviews")
    item = models.OneToOneField(
        OrderItem, on_delete=models.CASCADE, related_name="review", null=True
    )
    rating = models.IntegerField()
    title = models.CharField(max_length=255)
    comment = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'reviews'

    def __str__(self):
        return self.__dict__
