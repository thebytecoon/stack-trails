from django.db import models
from django.contrib.auth.models import User
from django.conf import settings
from brands.models import Brand
from categories.models import Category
from colors.models import Color
from django.urls import reverse


class ProductQuerySet(models.QuerySet):
    def wherePublished(self):
        return self.filter(published=1)

    def withAllFields(self):
        return self.prefetch_related("category", "brand")

    def whereSearchable(self):
        return self.whereIsPurchasable()

    def whereIsPurchasable(self):
        return self.wherePublished().filter(stock__gte=1)

    def search(self, keyword):
        queryset = self.whereIsPurchasable().filter(
            models.Q(title__icontains=keyword)
            | models.Q(brand__display_name__icontains=keyword)
            | models.Q(category__display_name__icontains=keyword)
        )

        return queryset


class ProductManager(models.Manager):
    def get_queryset(self):
        return ProductQuerySet(self.model, using=self._db)

    def wherePublished(self):
        return self.get_queryset().wherePublished()

    def withAllFields(self):
        return self.get_queryset().withAllFields()

    def whereSearchable(self):
        return self.get_queryset().whereSearchable()

    def whereIsPurchasable(self):
        return self.get_queryset().whereIsPurchasable()

    def search(self, keyword):
        return self.get_queryset().search(keyword)


class Product(models.Model):
    name = models.CharField(max_length=255)
    price = models.DecimalField(max_digits=10, decimal_places=2)
    slug = models.SlugField(max_length=255, unique=True)
    owner = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.DO_NOTHING)
    brand = models.ForeignKey(Brand, on_delete=models.DO_NOTHING)
    category = models.ForeignKey(Category, on_delete=models.DO_NOTHING)
    color = models.ForeignKey(Color, on_delete=models.DO_NOTHING)
    image = models.CharField(max_length=255, null=True, blank=True)
    published = models.BooleanField(default=0)
    stock = models.PositiveSmallIntegerField(null=True)
    sku = models.CharField(max_length=255, null=True)
    description = models.TextField(null=True)
    short_description = models.TextField(null=True, blank=True)
    discount = models.PositiveSmallIntegerField(default=0)
    featured = models.BooleanField(default=0)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    objects = ProductManager()

    class Meta:
        db_table = "products"

    def __str__(self):
        return self.name

    def sluggable(self):
        return {
            "slug": {
                "source": "name",
            }
        }

    def has_stock(self):
        return self.stock > 0

    def is_published(self):
        return self.published

    def is_purchasable(self):
        return self.has_stock() and self.is_published()

    def buy(self, quantity=1):
        self.stock -= quantity
        self.save()

    def get_url(self):
        return reverse("products.show", args=[self.slug])

    def image_url(self, width=600, height=600):
        return f"{self.image}?w={width}&h={height}&fit=crop&crop=center"

    @property
    def image_url_xs(self):
        return self.image_url(width=60, height=60)

    @property
    def image_url_sm(self):
        return self.image_url(width=100, height=100)

    @property
    def image_url_md(self):
        return self.image_url(width=300, height=300)


class Reviews(models.Model):
    product = models.ForeignKey(
        Product, on_delete=models.CASCADE, related_name="reviews"
    )
    user = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    rating = models.PositiveSmallIntegerField()
    comment = models.TextField(null=True, blank=True)
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        db_table = "product_reviews"

    def __str__(self):
        return f"Review by {self.user.username} for {self.product.title}"
