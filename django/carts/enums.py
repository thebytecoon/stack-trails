from enum import StrEnum


class CartDisplayEnum(StrEnum):
    OFFCANVAS = "offcanvas"
    CART = "cart"
    PRODUCT_LIST = "product_list"

    def getView(self):
        match self:
            case CartDisplayEnum.OFFCANVAS:
                return "carts/offcanvas_htmx.html"
            case CartDisplayEnum.CART:
                return "carts/cart_htmx.html"
            case CartDisplayEnum.PRODUCT_LIST:
                return "carts/product_list_htmx.html"
