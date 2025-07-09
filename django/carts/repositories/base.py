from typing import Protocol
from carts.models import Cart


class CartItemsRepository(list[Cart]):
    @property
    def count(self) -> int:
        return len(self)


class CartRepository(Protocol):
    def add_item(
        self,
        product_id: str,
        quantity: int = None,
        color_id: str = None,
        storage_id: str = None,
    ) -> None:
        """Add an item to the user's cart."""
        pass

    def remove_item(
        self,
        product_id: str,
        quantity: int = None,
        color_id: str = None,
        storage_id: str = None,
    ) -> None:
        """Remove an item from the user's cart."""
        pass

    def has_item(
        self, product_id: str, color_id: str = None, storage_id: str = None
    ) -> bool:
        """Check if the user's cart contains a specific item."""
        pass

    def get_item(
        self, product_id: str, color_id: str = None, storage_id: str = None
    ) -> Cart | None:
        """Retrieve a specific item from the user's cart."""
        pass

    def get_carts(self) -> list:
        """Retrieve the user's cart."""
        pass

    def clear_carts(self) -> None:
        """Clear the user's cart."""
        pass

    def count(self) -> int:
        """Get the total number of items in the user's cart."""
        pass
