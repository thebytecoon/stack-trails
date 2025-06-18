from carts.models import Cart
from products.models import Product


class DatabaseCartRepository:
    def __init__(self, request):
        self.user = request.user

        if request.session.has_key("_cart"):
            for cart in request.session["_cart"]:
                self.add_item(cart["product_id"], cart["quantity"])
            del request.session["_cart"]

    def add_item(self, product_id: str, quantity: int = None) -> None:
        if quantity is None:
            quantity = 1

        product = Product.objects.filter(id=product_id, published=True).first()

        if not product:
            raise ValueError("Product not found or not published")

        cart = Cart.objects.filter(product=product, user=self.user).first()

        if not cart:
            Cart.objects.create(
                product_id=product_id, user=self.user, quantity=quantity
            )
        else:
            if cart.quantity + quantity <= cart.product.stock:
                cart.quantity += quantity
                cart.save()
            else:
                raise ValueError("Not enough stock available for this product")

    def remove_item(self, product_id: str, quantity: int = None) -> None:
        if quantity is None:
            quantity = 1

        cart = Cart.objects.filter(product_id=product_id, user=self.user).first()

        if not cart:
            raise ValueError("Item not found in cart")

        if cart.quantity > quantity:
            cart.quantity -= quantity
            cart.save()
        elif cart.quantity <= quantity:
            cart.delete()

    def get_item(self, product_id: str) -> Cart | None:
        cart = Cart.objects.filter(product_id=product_id, user=self.user).first()
        if cart:
            return cart

        return {}

    def get_carts(self) -> list:
        return Cart.objects.filter(user=self.user, product__published=True).all()

    def clear_carts(self) -> None:
        Cart.objects.filter(user=self.user).delete()

    def count(self) -> int:
        return Cart.objects.filter(user=self.user, product__published=True).count()
