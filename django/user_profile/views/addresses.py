from django.shortcuts import render
from django.views.decorators.http import require_GET, require_POST
from django.contrib.auth.decorators import login_required
from django.http import Http404
from addresses.models import Address
from addresses.forms import AddressForm
from django.urls import reverse


@login_required
@require_GET
def index(request):
    user = request.user

    addresses = user.addresses.order_by("-created_at", "-id").all()

    return render(
        request,
        "user_profile/addresses/index.html",
        {
            "user": user,
            "addresses": addresses,
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
@require_GET
def edit(request, address_id):
    user = request.user

    try:
        address = user.addresses.get(id=address_id)
    except Address.DoesNotExist:
        raise Http404("Address not found")

    form = AddressForm(initial=address.__dict__)

    return render(
        request,
        "user_profile/addresses/partials/modal.html",
        {
            "user": user,
            "form": form,
            "form_action": reverse(
                "user.addresses.update",
                args=[address.id],
            ),
        },
    )


@login_required
@require_POST
def update(request, address_id):
    user = request.user

    try:
        address = user.addresses.get(id=address_id)
    except Address.DoesNotExist:
        raise Http404("Address not found")

    form = AddressForm(request.POST)

    if not form.is_valid():
        return render(
            request,
            "user_profile/addresses/partials/form.html",
            {
                "form": form,
                "form_action": reverse(
                    "user.addresses.update",
                    args=[address.id],
                ),
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

    for key, value in address_data.items():
        setattr(address, key, value)
    address.save()

    return render(
        request,
        "user_profile/addresses/partials/modal_success.html",
        {
            "user": user,
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
def destroy(request, address_id):
    user = request.user
    try:
        address = user.addresses.get(id=address_id)
    except Address.DoesNotExist:
        raise Http404("Address not found")

    address.delete()

    addresses = user.addresses.order_by("-created_at", "-id").all()

    return render(
        request,
        "user_profile/addresses/partials/list.html",
        {
            "user": user,
            "addresses": addresses,
        },
    )


@login_required
@require_POST
def set_as_default(request, address_id):
    user = request.user
    try:
        address = user.addresses.get(id=address_id)
    except Address.DoesNotExist:
        raise Http404("Address not found")

    user.addresses.exclude(id=address_id).update(default=False)

    address.default = True
    address.save()

    addresses = user.addresses.order_by("-created_at", "-id").all()

    return render(
        request,
        "user_profile/addresses/partials/list.html",
        {
            "user": user,
            "addresses": addresses,
        },
    )
