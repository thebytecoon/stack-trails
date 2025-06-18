from django.urls import path

from . import views

urlpatterns = [
    path("store", views.store, name="checkout.store"),
    path("order/<code>", views.order, name="checkout.order"),
    path(
        "order/<code>/update_shipping",
        views.update_shipping,
        name="checkout.update_shipping",
    ),
    path(
        "order/<code>/purchase",
        views.checkout_purchase,
        name="checkout.purchase",
    ),
]
