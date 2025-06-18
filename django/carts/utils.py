from .repositories.base import CartRepository
from .repositories.database import DatabaseCartRepository
from .repositories.session import SessionCartRepository


def get_cart(request) -> CartRepository:
    if request.user.is_authenticated:
        return DatabaseCartRepository(request=request)
    else:
        return SessionCartRepository(request=request)
