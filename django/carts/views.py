from django.shortcuts import render, redirect
from django.views.decorators.http import require_POST, require_GET
from django.http import HttpResponseBadRequest
from .models import Cart
from django.contrib import messages
from .utils import get_cart
from .enums import CartDisplayEnum


@require_GET
def index(request):
    cart = get_cart(request)

    carts = cart.get_carts()

    total = 0
    for cart_item in carts:
        total += cart_item.total_price

    return render(request, "carts/index.html", {"carts": carts, "total": total})


@require_POST
def store(request):
    if not request.POST.get("product_id"):
        return HttpResponseBadRequest

    quantity = 1

    if request.POST.get("quantity"):
        quantity = int(request.POST.get("quantity"))

    cart = get_cart(request)
    product_id = request.POST.get("product_id")

    try:
        cart.add_item(product_id, quantity)
    except ValueError as e:
        messages.error(request, str(e))
        return redirect(request.META.get("HTTP_REFERER"))

    messages.success(request, "Producto agregado exitosamente")

    return redirect(request.META.get("HTTP_REFERER"))


@require_POST
def destroy(request, product_id):
    if not request.POST.get("display"):
        return HttpResponseBadRequest("Display parameter is required")

    try:
        display = CartDisplayEnum(request.POST.get("display"))
    except ValueError:
        return HttpResponseBadRequest("Invalid display type")

    cart = get_cart(request)

    color_id = None
    storage_id = None

    if request.POST.get("color"):
        color_id = int(request.POST.get("color"))

    if request.POST.get("storage"):
        storage_id = int(request.POST.get("storage"))

    try:
        cart.remove_item(product_id, 9999999, color_id, storage_id)
    except ValueError as e:
        pass

    carts = cart.get_carts()

    return render(request, display.getView(), {"carts": carts})


@require_POST
def add(request, product_id):
    if not request.POST.get("display"):
        return HttpResponseBadRequest("Display parameter is required")

    try:
        display = CartDisplayEnum(request.POST.get("display"))
    except ValueError:
        return HttpResponseBadRequest("Invalid display type")

    cart = get_cart(request)

    quantity = None
    color_id = None
    storage_id = None

    if request.POST.get("quantity"):
        quantity = int(request.POST.get("quantity"))

    if request.POST.get("color"):
        color_id = int(request.POST.get("color"))

    if request.POST.get("storage"):
        storage_id = int(request.POST.get("storage"))

    try:
        cart.add_item(product_id, quantity, color_id, storage_id)
    except ValueError as e:
        pass

    carts = cart.get_carts()

    total = 0
    for cart in carts:
        total += cart.total_price

    return render(request, display.getView(), {"carts": carts, "total": total})


@require_POST
def sub(request, product_id):
    if not request.POST.get("display"):
        return HttpResponseBadRequest("Display parameter is required")

    try:
        display = CartDisplayEnum(request.POST.get("display"))
    except ValueError:
        return HttpResponseBadRequest("Invalid display type")

    quantity = None
    color_id = None
    storage_id = None

    if request.POST.get("quantity"):
        quantity = int(request.POST.get("quantity"))

    if request.POST.get("color"):
        color_id = int(request.POST.get("color"))

    if request.POST.get("storage"):
        storage_id = int(request.POST.get("storage"))

    cart = get_cart(request)
    try:
        cart.remove_item(product_id, quantity, color_id, storage_id)
    except ValueError as e:
        pass

    carts = cart.get_carts()

    total = 0
    for cart in carts:
        total += cart.total_price

    return render(request, display.getView(), {"carts": carts, "total": total})
