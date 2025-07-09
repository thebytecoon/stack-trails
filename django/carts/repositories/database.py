from carts.models import Cart
from products.models import Product
from colors.models import Color
from product_storage.models import ProductStorage


class DatabaseCartRepository:
    def __init__(self, request):
        self.user = request.user

        if request.session.has_key("_cart"):
            for cart in request.session["_cart"]:
                self.add_item(
                    cart["product_id"],
                    cart["quantity"],
                    cart["color_id"],
                    cart["storage_id"],
                )
            del request.session["_cart"]

    def _get_default_cart(self, color_id: str = None, storage_id: str = None) -> dict:
        default_cart = {}

        if color_id:
            color = Color.objects.filter(id=color_id).first()
            if not color:
                raise ValueError("Color not found")
            default_cart["color_id"] = color.id
        else:
            color = Color.objects.order_by("id").first()
            default_cart["color_id"] = color.id

        if storage_id:
            storage = ProductStorage.objects.filter(id=storage_id).first()
            if not storage:
                raise ValueError("Storage not found")
            default_cart["storage_id"] = storage.id
        else:
            storage = ProductStorage.objects.order_by("id").first()
            default_cart["storage_id"] = storage.id

        return default_cart

    def add_item(
        self,
        product_id: str,
        quantity: int = None,
        color_id: str = None,
        storage_id: str = None,
    ) -> None:
        if quantity is None:
            quantity = 1

        product = (
            Product.objects.whereIsPurchasable()
            .filter(
                id=product_id,
            )
            .first()
        )

        if not product:
            raise ValueError("Product not found or not published")

        default_cart = self._get_default_cart(color_id, storage_id)

        cart = Cart.objects.filter(
            product=product,
            user=self.user,
            color_id=default_cart["color_id"],
            storage_id=default_cart["storage_id"],
        ).first()

        if not cart:
            Cart.objects.create(
                product_id=product_id,
                color_id=default_cart["color_id"],
                storage_id=default_cart["storage_id"],
                quantity=quantity,
                user=self.user,
            )
        else:
            if cart.quantity + quantity <= cart.product.stock:
                cart.quantity += quantity
                cart.save()
            else:
                raise ValueError("Not enough stock available for this product")

    def remove_item(
        self,
        product_id: str,
        quantity: int = None,
        color_id: str = None,
        storage_id: str = None,
    ) -> None:
        if quantity is None:
            quantity = 1

        cart = self._get_default_cart(color_id, storage_id)

        cart = Cart.objects.filter(
            product_id=product_id,
            color_id=cart["color_id"],
            storage_id=cart["storage_id"],
            user=self.user,
        ).first()

        if not cart:
            raise ValueError("Item not found in cart")

        if cart.quantity > quantity:
            cart.quantity -= quantity
            cart.save()
        elif cart.quantity <= quantity:
            cart.delete()

    def has_item(
        self, product_id: str, color_id: str = None, storage_id: str = None
    ) -> bool:
        cart = self._get_default_cart(color_id, storage_id)

        return Cart.objects.filter(
            product_id=product_id,
            user=self.user,
            color_id=cart["color_id"],
            storage_id=cart["storage_id"],
        ).exists()

    def get_item(
        self, product_id: str, color_id: str = None, storage_id: str = None
    ) -> Cart | None:
        default_cart = self._get_default_cart(color_id, storage_id)

        cart = Cart.objects.filter(
            product_id=product_id,
            user=self.user,
            color_id=default_cart["color_id"],
            storage_id=default_cart["storage_id"],
        ).first()
        if cart:
            return cart

        return {}

    def get_carts(self) -> list:
        return Cart.objects.filter(user=self.user, product__published=True).all()

    def clear_carts(self) -> None:
        Cart.objects.filter(user=self.user).delete()

    def count(self) -> int:
        return Cart.objects.filter(user=self.user, product__published=True).count()
