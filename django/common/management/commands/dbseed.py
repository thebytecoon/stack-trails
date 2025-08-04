from django.core.management.base import BaseCommand, CommandError
from products.models import Product
from categories.models import Category
from brands.models import Brand
from colors.models import Color
from product_storage.models import ProductStorage
from orders.models import ShippingOption
from faker import Faker
from django.contrib.auth.models import User
import random
from django.db import transaction
from faker.providers import lorem


class Command(BaseCommand):
    help = "Seed the database with initial data"

    colors = {
        "lightpink": "#FFB6C1",
        "lightblue": "#ADD8E6",
        "lightgreen": "#90EE90",
        "lightyellow": "#FFFFE0",
        "lightgray": "#D3D3D3",
    }

    storages = [
        '256GB',
        '512GB',
        '1TB',
    ]

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

    product_info = {
        "quest": {
            "images": [
                "https://images.unsplash.com/photo-1617802690992-15d93263d3a9",
                "https://images.unsplash.com/photo-1605647540924-852290f6b0d5"
            ],
            "features": [
                "See your surroundings in full color for mixed reality.",
                "Pancake lenses for clearer, slimmer display.",
                "Snapdragon XR2 Gen 2 for better performance.",
                "Haptics and better tracking.",
                "Backward compatible with Quest 2 games.",
            ],
        },
        "headset": {
            "images": [
                "https://images.unsplash.com/photo-1505740420928-5e560c06d30e",
                "https://images.unsplash.com/photo-1583394838336-acd977736f90",
                "https://images.unsplash.com/photo-1484704849700-f032a568e944",
                "https://images.unsplash.com/photo-1628202926206-c63a34b1618f"
            ],
            "features": [
                "High-resolution display for immersive visuals.",
                "Adjustable head strap for comfort during long sessions.",
                "Built-in audio for an immersive sound experience.",
                "Wireless connectivity for freedom of movement.",
                "Compatible with a wide range of VR games and applications.",
            ]
        },
        "pos_machine": {
            "images": [
                "https://images.unsplash.com/photo-1728044849347-ea6ff59d98dd"
            ],
            "features": [
                "Compact design for easy placement on counters.",
                "Touchscreen interface for intuitive operation.",
                "Integrated card reader for secure transactions.",
                "Supports multiple payment methods including cash and card.",
                "Customizable settings for different business needs.",
            ]
        },
        "osciloscope": {
            "images": [
                "https://images.unsplash.com/photo-1580983230786-ce385a434707"
            ],
            "features": [
                "High bandwidth for accurate signal analysis.",
                "Multiple channels for simultaneous signal monitoring.",
                "Large display for easy viewing of waveforms.",
                "USB connectivity for data transfer and analysis.",
                "Compact design for portability and ease of use.",
            ]
        },
        "laptop": {
            "images": [
                "https://images.unsplash.com/photo-1496181133206-80ce9b88a853"
            ],
            "features": [
                "High-performance processor for fast computing.",
                "Lightweight and portable design for on-the-go use.",
                "Long battery life for extended use without charging.",
                "High-resolution display for clear visuals.",
                "Multiple connectivity options including USB-C and HDMI.",
            ]
        },
        "mouse": {
            "images": [
                "https://images.unsplash.com/photo-1527864550417-7fd91fc51a46"
            ],
            "features": [
                "Ergonomic design for comfortable use.",
                "Wireless connectivity for freedom of movement.",
                "Adjustable DPI settings for precision control.",
                "Long battery life for extended use.",
                "Customizable buttons for personalized functionality.",
            ]
        },
        "drone": {
            "images": [
                "https://images.unsplash.com/photo-1487887235947-a955ef187fcc"
            ],
            "features": [
                "High-resolution camera for stunning aerial photography.",
                "GPS navigation for precise flight control.",
                "Long flight time for extended exploration.",
                "Obstacle avoidance for safe flying.",
                "Compact and foldable design for easy transport.",
            ]
        },
        "glasses": {
            "images": [
                "https://plus.unsplash.com/premium_photo-1733749585363-062125288d04"
            ],
            "features": [
                "Lightweight and comfortable for all-day wear.",
                "UV protection for eye safety.",
                "Scratch-resistant lenses for durability.",
                "Stylish design for a modern look.",
                "Available in various colors and styles.",
            ]
        },
        "screen": {
            "images": [
                "https://images.unsplash.com/photo-1496171367470-9ed9a91ea931"
            ],
            "features": [
                "High-definition display for crystal-clear visuals.",
                "Multiple connectivity options including HDMI and USB-C.",
                "Adjustable stand for optimal viewing angles.",
                "Built-in speakers for an immersive audio experience.",
                "Slim design for modern aesthetics.",
            ]
        }
    }

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
                    Category.objects.create(
                        display_name=category.capitalize(),
                    )

                categories = Category.objects.all()

                self.stdout.write(self.style.SUCCESS("Creating brands..."))
                for brand in self.brands:
                    Brand.objects.create(
                        display_name=brand.capitalize(),
                    )

                brands = Brand.objects.all()

                self.stdout.write(self.style.SUCCESS("Creating colors..."))
                for color, hex in self.colors.items():
                    Color.objects.create(
                        display_name=color.capitalize(),
                        hex_code=hex,
                    )

                self.stdout.write(self.style.SUCCESS("Creating storages..."))
                for storage_name in self.storages:
                    ProductStorage.objects.create(
                        name=storage_name,
                    )

                fake = Faker()
                fake.add_provider(lorem)

                self.stdout.write(self.style.SUCCESS("Creating products..."))
                for _ in range(500):
                    product_type = random.choice(list(self.product_info.keys()))
                    
                    product = Product.objects.create(
                        name=" ".join(fake.words(nb=3)).capitalize(),
                        price=random.randint(5, 1200),
                        stock=random.randint(0, 20),
                        brand=random.choice(brands),
                        category=random.choice(categories),
                        image=random.choice(self.product_info[product_type]["images"]),
                        published=fake.boolean(),
                        description=fake.paragraph(),
                        short_description=fake.sentence(),
                        discount=random.randint(0, 50),
                        featured=fake.boolean(),
                        sku=fake.bothify(text="???-#####"),
                        owner=u,
                    )

                    for feature in self.product_info[product_type]["features"]:
                        product.features.create(description=feature)

                    for _ in range(random.randint(0, 50)):
                        product.reviews.create(
                            user=u,
                            rating=random.randint(1, 5),
                            title=fake.sentence(),
                            comment=fake.paragraph(),
                        )

                self.stdout.write(self.style.SUCCESS("Creating shipping options..."))
                for option in self.shipping_options:
                    ShippingOption.objects.create(
                        name=option["name"],
                        description=option["description"],
                        price=option["price"],
                    )

            self.stdout.write(self.style.SUCCESS("Database seeded successfully!"))
        except Exception as e:
            raise e
