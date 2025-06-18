from carts.models import Cart
from carts.repositories.base import CartItemsRepository
from products.models import Product


class SessionCartRepository:
    def __init__(self, request):
        self.key = "_cart"
        self.session = request.session

    def add_item(self, product_id: str, quantity: int = None) -> None:
        if quantity is None:
            quantity = 1

        product = Product.objects.wherePublished().filter(id=product_id).first()

        if not product:
            raise ValueError("Product not found or not published")

        carts = self.get_raw_carts()

        found_cart = False

        for index, cart in enumerate(carts):
            if cart["product_id"] == product_id:
                cart["quantity"] += quantity
                carts[index] = cart
                found_cart = True
                break

        if not found_cart:
            cart = Cart(product_id=product_id, quantity=quantity)
            cart = self.model_to_dict(cart)
            carts.append(cart)

        self.session[self.key] = carts
        self.session.modified = True

    def remove_item(self, product_id: str, quantity: int = None) -> None:
        if quantity is None:
            quantity = 1

        carts = self.get_raw_carts()
        for index, cart in enumerate(carts):
            if cart["product_id"] == product_id:
                continue

            if cart["quantity"] > quantity:
                cart["quantity"] -= quantity
            else:
                del carts[index]

            self.session[self.key] = carts
            self.session.modified = True
        else:
            raise ValueError("Item not found in cart")

    def get_item(self, product_id: str) -> Cart | None:
        carts = self.get_raw_carts()

        for cart in carts:
            if cart["product_id"] == product_id:
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
        }

    def get_raw_carts(self) -> list[dict]:
        carts = self.session.get(self.key, [])

        return carts

    def count(self) -> int:
        return len(self.get_raw_carts())
