from django.core.management.base import BaseCommand, CommandError
from products.models import Product
from categories.models import Category
from brands.models import Brand
from colors.models import Color
from orders.models import ShippingOption
from faker import Faker
from django.contrib.auth.models import User
import random
from django.db import transaction
from faker.providers import lorem


class Command(BaseCommand):
    help = "Seed the database with initial data"

    colors = {
        "red": "#FF0000",
        "green": "#00FF00",
        "blue": "#0000FF",
        "yellow": "#FFFF00",
        "black": "#000000",
        "white": "#FFFFFF",
        "purple": "#800080",
        "orange": "#FFA500",
        "pink": "#FFC0CB",
        "gray": "#808080",
    }

    categories = [
        "electronics",
        "clothing",
        "books",
        "home_appliances",
        "toys",
        "sports",
        "health",
        "beauty",
        "automotive",
        "garden",
    ]

    brands = [
        "Sony",
        "Samsung",
        "Apple",
        "LG",
        "Panasonic",
        "Dell",
        "HP",
        "Lenovo",
        "Asus",
        "Philips",
    ]

    images = [
        "https://images.unsplash.com/photo-1505740420928-5e560c06d30e",
        "https://images.unsplash.com/photo-1583394838336-acd977736f90",
        "https://images.unsplash.com/photo-1527864550417-7fd91fc51a46",
        "https://images.unsplash.com/photo-1484704849700-f032a568e944",
        "https://images.unsplash.com/photo-1496171367470-9ed9a91ea931",
        "https://images.unsplash.com/photo-1487887235947-a955ef187fcc",
        "https://images.unsplash.com/photo-1605647540924-852290f6b0d5",
        "https://images.unsplash.com/photo-1496181133206-80ce9b88a853",
        "https://images.unsplash.com/photo-1628202926206-c63a34b1618f",
        "https://images.unsplash.com/photo-1580983230786-ce385a434707",
        "https://plus.unsplash.com/premium_photo-1733749585363-062125288d04",
        "https://images.unsplash.com/photo-1728044849347-ea6ff59d98dd",
        "https://images.unsplash.com/photo-1617802690992-15d93263d3a9",
    ]

    shipping_options = [
        {
            "name": "Standard Shipping",
            "description": "5-7 business days",
            "price": 0.0,
        },
        {
            "name": "Express Shipping",
            "description": "2-3 business days",
            "price": 15.99,
        },
        {
            "name": "Overnight Shipping",
            "description": "Next business day",
            "price": 29.99,
        },
    ]

    def handle(self, *args, **options):
        try:
            with transaction.atomic():
                self.stdout.write(self.style.SUCCESS("Seeding database..."))
                u = User(username="test", email="test@localhost.com")
                u.set_password("1234")
                u.is_superuser = True
                u.is_staff = True
                u.save()

                self.stdout.write(self.style.SUCCESS("Creating user addresses..."))
                u.addresses.create(
                    name="Home",
                    names="John Doe",
                    address_line_1="123 Main Street",
                    address_line_2="Apt 4B",
                    country="United States",
                    city="New York, NY",
                    postal_code="10001",
                    phone_number="(555) 123-4567",
                    default=True,
                )

                u.addresses.create(
                    name="Work",
                    names="John Doe",
                    address_line_1="456 Business Ave",
                    address_line_2="Suite 200",
                    country="United States",
                    city="New York, NY",
                    postal_code="10005",
                    phone_number="(555) 987-6543",
                    default=False,
                )

                self.stdout.write(self.style.SUCCESS("Creating payment methods..."))

                u.payment_methods.create(
                    type="Visa",
                    card_number="4387",
                    cardholder_name="John Doe",
                    expiry_date="2026-12-31",
                    code="123",
                )

                self.stdout.write(self.style.SUCCESS("Creating categories..."))
                for category in self.categories:
                    Category.objects.get_or_create(
                        display_name=category.capitalize(),
                    )

                categories = Category.objects.all()

                self.stdout.write(self.style.SUCCESS("Creating brands..."))
                for brand in self.brands:
                    Brand.objects.get_or_create(
                        display_name=brand.capitalize(),
                    )

                brands = Brand.objects.all()

                self.stdout.write(self.style.SUCCESS("Creating colors..."))
                for color, hex in self.colors.items():
                    Color.objects.get_or_create(
                        display_name=color.capitalize(),
                        hex_code=hex,
                    )

                colors = Color.objects.all()

                fake = Faker()
                fake.add_provider(lorem)

                self.stdout.write(self.style.SUCCESS("Creating products..."))
                for _ in range(300):
                    Product.objects.get_or_create(
                        name=" ".join(fake.words(nb=3)).capitalize(),
                        price=random.randint(5, 1200),
                        stock=random.randint(0, 20),
                        brand=random.choice(brands),
                        category=random.choice(categories),
                        color=random.choice(colors),
                        image=random.choice(self.images),
                        published=fake.boolean(),
                        description=fake.paragraph(),
                        short_description=fake.sentence(),
                        discount=random.randint(0, 50),
                        featured=fake.boolean(),
                        sku=fake.bothify(text="???-#####"),
                        owner=u,
                    )

                self.stdout.write(self.style.SUCCESS("Creating shipping options..."))
                for option in self.shipping_options:
                    ShippingOption.objects.get_or_create(
                        name=option["name"],
                        description=option["description"],
                        price=option["price"],
                    )

            self.stdout.write(self.style.SUCCESS("Database seeded successfully!"))
        except Exception as e:
            raise CommandError(f"Error seeding database: {e}")
