from django.shortcuts import render
from django.views.decorators.http import require_GET, require_POST
from django.contrib.auth.decorators import login_required
from django.http import Http404
from django.urls import reverse
from payments.models import PaymentMethod


@login_required
@require_GET
def index(request):
    user = request.user

    payment_methods = user.payment_methods.order_by("-created_at", "-id").all()

    return render(
        request,
        "user_profile/payment_methods/index.html",
        {
            "user": user,
            "payment_methods": payment_methods,
        },
    )


@login_required
@require_GET
def create(request):
    user = request.user

    form = AddressForm()

    return render(
        request,
        "user_profile/addresses/partials/modal.html",
        {
            "user": user,
            "form": form,
            "form_action": reverse("user.addresses.store"),
        },
    )


@login_required
@require_POST
def store(request):
    user = request.user

    form = AddressForm(request.POST)

    if not form.is_valid():
        return render(
            request,
            "user_profile/addresses/partials/form.html",
            {
                "form": form,
                "form_action": reverse("user.addresses.create"),
            },
        )

    address_data = {
        "user": user,
        "name": request.POST.get("name"),
        "names": request.POST.get("names"),
        "address_line_1": request.POST.get("address_line_1"),
        "address_line_2": request.POST.get("address_line_2", ""),
        "phone_number": request.POST.get("phone_number", ""),
        "city": request.POST.get("city") + request.POST.get("state", ""),
        "postal_code": request.POST.get("postal_code"),
        "country": request.POST.get("country"),
    }

    address = Address.objects.create(**address_data)

    return render(
        request,
        "user_profile/addresses/partials/modal_success.html",
        {
            "user": user,
        },
    )


@login_required
@require_POST
def destroy(request, method_id):
    user = request.user
    try:
        payment_method = user.payment_metods.get(id=method_id)
    except PaymentMethod.DoesNotExist:
        raise Http404("Method not found")

    payment_method.delete()

    payment_metods = user.payment_metods.order_by("-created_at", "-id").all()

    return render(
        request,
        "user_profile/payment_methods/partials/list.html",
        {
            "user": user,
            "payment_metods": payment_metods,
        },
    )


@login_required
@require_POST
def set_as_default(request, method_id):
    user = request.user
    try:
        payment_method = user.payment_methods.get(id=method_id)
    except PaymentMethod.DoesNotExist:
        raise Http404("Method not found")

    user.payment_methods.exclude(id=method_id).update(default=False)

    payment_method.default = True
    payment_method.save()

    payment_methods = user.payment_methods.order_by("-created_at", "-id").all()

    return render(
        request,
        "user_profile/payment_methods/partials/list.html",
        {
            "user": user,
            "payment_methods": payment_methods,
        },
    )
