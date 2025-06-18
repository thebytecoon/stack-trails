from django.urls import path

from user_profile.views import orders
from user_profile.views import addresses
from user_profile.views import payments

urlpatterns = [
    path("orders/<code>", orders.show, name="user.orders.show"),
    path("orders", orders.index, name="user.orders.index"),
    path("addresses", addresses.index, name="user.addresses.index"),
    path(
        "addresses/<address_id>/update",
        addresses.update,
        name="user.addresses.update",
    ),
    path(
        "addresses/<address_id>/edit",
        addresses.edit,
        name="user.addresses.edit",
    ),
    path(
        "addresses/create",
        addresses.create,
        name="user.addresses.create",
    ),
    path(
        "addresses/store",
        addresses.store,
        name="user.addresses.store",
    ),
    path(
        "addresses/<address_id>/set-default",
        addresses.set_as_default,
        name="user.addresses.default",
    ),
    path(
        "addresses/<address_id>/delete",
        addresses.destroy,
        name="user.addresses.delete",
    ),
    path(
        "payment-methods",
        payments.index,
        name="user.payment-methods.index",
    ),
    path(
        "payment-methods/<method_id>/delete",
        payments.destroy,
        name="user.payment-methods.delete",
    ),
    path(
        "payment-methods/<method_id>/set-default",
        payments.set_as_default,
        name="user.payment-methods.default",
    ),
]
