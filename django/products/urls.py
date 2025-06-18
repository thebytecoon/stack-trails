from django.urls import path

from . import views, api

urlpatterns = [
    path("", views.index, name="products.index"),
    path("create", views.create, name="products.create"),
    path("store", views.store, name="products.store"),
    path("edit/<id>", views.edit, name="products.edit"),
    path("update/<id>", views.update, name="products.update"),
    path("<id>", views.show, name="products.show"),
    path("api/search", api.search, name="api.products.search"),
]
