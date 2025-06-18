from django.urls import path

from . import views

urlpatterns = [
    path("", views.index, name="carts.index"),
    path("store", views.store, name="carts.store"),
    path("destroy/<int:product_id>", views.destroy, name="carts.destroy"),
    path("add/<int:product_id>", views.add, name="carts.add"),
    path("sub/<int:product_id>", views.sub, name="carts.sub"),
]
