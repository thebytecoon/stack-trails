from django.shortcuts import render, redirect
from django.views.decorators.http import require_GET, require_POST
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from orders.models import Order, OrderStatusEnum
from carts.utils import get_cart
from orders.actions.create import create_order
from orders.models import ShippingOption
from django.http import Http404, HttpResponse
from .forms import CheckoutForm
from orders.actions.pay import pay_order
from addresses.models import Address
from payments.models import PaymentMethod


@login_required
@require_POST
def store(request):
    cart = get_cart(request)

    if not cart.count():
        messages.error(request, "No posee productos en el carrito")

        return redirect("home")

    try:
        order = create_order(request.user, cart)
    except Exception as e:
        messages.error(request, f"Error al crear la orden: {str(e)}")
        return redirect("checkout.create")

    return redirect("checkout.order", order.code)


@login_required
@require_GET
def order(request, code):
    try:
        order = Order.objects.filter(
            code=code, user=request.user, status=OrderStatusEnum.INITIAL
        ).first()
    except Order.DoesNotExist:
        messages.error(request, "Orden no encontrada")
        return redirect("home")

    user = request.user

    form = CheckoutForm(user=user, order=order)

    shipping_options = ShippingOption.objects.order_by("price").all()

    return render(
        request,
        "checkout/order.html",
        {
            "order": order,
            "shipping_options": shipping_options,
            "form": form,
        },
    )


@login_required
@require_POST
def update_shipping(request, code):
    try:
        order = Order.objects.get(
            code=code, user=request.user, status=OrderStatusEnum.INITIAL
        )
    except Order.DoesNotExist:
        return Http404("Orden no encontrada")

    shipping_option_id = request.POST.get("shipping")
    if not shipping_option_id:
        return HttpResponse("shipping is missing", status=422)

    try:
        shipping_option = ShippingOption.objects.get(id=shipping_option_id)
        order.delivery_price = shipping_option.price
        order.total = order.subtotal + order.delivery_price
        order.save()
    except ShippingOption.DoesNotExist:
        return Http404("Shipping option not found")

    return render(
        request, "checkout/partials/order_summary.html", {"order": order, "htmx": True}
    )


@login_required
@require_POST
def checkout_purchase(request, code):
    try:
        order = Order.objects.get(
            code=code, user=request.user, status=OrderStatusEnum.INITIAL
        )
    except Order.DoesNotExist:
        return Http404("Orden no encontrada")

    user = request.user

    form = CheckoutForm(user=user, order=order, data=request.POST)

    if not form.is_valid():
        messages.error(request, "Por favor, corrija los errores en el formulario.")

        return redirect("checkout.order", code=code)

    try:
        address = Address.objects.get(pk=form.cleaned_data["address"])
    except Address.DoesNotExist:
        messages.error(request, "Dirección no encontrada")
        return redirect("checkout.order", code=code)

    try:
        payment_method = PaymentMethod.objects.get(
            pk=form.cleaned_data["payment_method"]
        )
    except PaymentMethod.DoesNotExist:
        messages.error(request, "Método de pago no encontrado")
        return redirect("checkout.order", code=code)

    try:
        shipping_option = ShippingOption.objects.get(
            pk=form.cleaned_data["shipping_option"]
        )
    except ShippingOption.DoesNotExist:
        messages.error(request, "Opción de envío no encontrada")
        return redirect("checkout.order", code=code)

    try:

        pay_order(order, address, payment_method, shipping_option)
    except Exception as e:
        messages.error(request, f"Error al procesar el pago: {str(e)}")
        return redirect("checkout.order", code=code)

    cart = get_cart(request)
    cart.clear_carts()

    return render(request, "checkout/thank-you.html", {"order": order})
