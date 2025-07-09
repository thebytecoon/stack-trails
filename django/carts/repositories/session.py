from carts.models import Cart
from carts.repositories.base import CartItemsRepository
from products.models import Product
from colors.models import Color
from product_storage.models import ProductStorage


class SessionCartRepository:
    def __init__(self, request):
        self.key = "_cart"
        self.session = request.session

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

        product = Product.objects.wherePublished().filter(id=product_id).first()

        if not product:
            raise ValueError("Product not found or not published")

        default_cart = self._get_default_cart(color_id, storage_id)

        default_cart["product_id"] = product_id
        default_cart["quantity"] = quantity

        carts = self.get_raw_carts()

        if self.has_item(
            product_id,
            color_id=default_cart["color_id"],
            storage_id=default_cart["storage_id"],
        ):
            for cart in carts:
                if (
                    cart["product_id"] == product_id
                    and cart.get("color_id") == default_cart["color_id"]
                    and cart.get("storage_id") == default_cart["storage_id"]
                ):
                    cart["quantity"] += quantity
                    break
        else:
            carts.append(default_cart)

        self.session[self.key] = carts
        self.session.modified = True

    def remove_item(
        self,
        product_id: str,
        quantity: int = None,
        color_id: str = None,
        storage_id: str = None,
    ) -> None:
        if quantity is None:
            quantity = 1

        default_cart = self._get_default_cart(color_id, storage_id)

        if not self.has_item(
            product_id,
            color_id=default_cart["color_id"],
            storage_id=default_cart["storage_id"],
        ):
            raise ValueError("Item not found in cart")

        carts = self.get_raw_carts()

        for index, cart in enumerate(carts):
            if (
                cart["product_id"] == product_id
                and cart.get("color_id") == default_cart["color_id"]
                and cart.get("storage_id") == default_cart["storage_id"]
            ):
                if cart["quantity"] <= quantity:
                    del carts[index]
                else:
                    cart["quantity"] -= quantity
                break

        self.session[self.key] = carts
        self.session.modified = True

    def has_item(
        self, product_id: str, color_id: str = None, storage_id: str = None
    ) -> bool:
        carts = self.get_raw_carts()

        default_cart = self._get_default_cart(color_id, storage_id)
        default_cart["product_id"] = product_id

        for cart in carts:
            if (
                cart["product_id"] == product_id
                and cart.get("color_id") == default_cart["color_id"]
                and cart.get("storage_id") == default_cart["storage_id"]
            ):
                return True

        return False

    def get_item(
        self, product_id: str, color_id: str = None, storage_id: str = None
    ) -> Cart | None:
        carts = self.get_raw_carts()

        default_cart = self._get_default_cart(color_id, storage_id)
        default_cart["product_id"] = product_id

        for cart in carts:
            if (
                cart["product_id"] == product_id
                and cart.get("color_id") == default_cart["color_id"]
                and cart.get("storage_id") == default_cart["storage_id"]
            ):
                return Cart(**cart)

        return None

    def get_carts(self) -> list[Cart]:
        carts = CartItemsRepository()
        for cart in self.session.get(self.key, []):
            carts.append(Cart(**cart))

        return carts

    def clear_cart(self) -> None:
        if self.key in self.session:
            del self.session[self.key]
            self.session.modified = True

    def model_to_dict(self, cart: Cart) -> dict:
        return {
            "product_id": cart.product_id,
            "quantity": cart.quantity,
            "color_id": cart.color_id,
            "storage_id": cart.storage_id,
        }

    def get_raw_carts(self) -> list[dict]:
        carts = self.session.get(self.key, [])

        return carts

    def count(self) -> int:
        return len(self.get_raw_carts())
