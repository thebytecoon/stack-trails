from django.shortcuts import render, redirect
from products.models import Product
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.forms import AuthenticationForm
from django.views.decorators.http import require_http_methods
from django.contrib import messages


def home(request):
    featured_products = (
        Product.objects.wherePublished().withAllFields().order_by("?")[:4]
    )

    return render(
        request,
        "home/home.html",
        {
            "featured_products": featured_products,
        },
    )


@require_http_methods(["GET"])
def login_view(request):
    form = AuthenticationForm(request, data=request.session.pop("_old_data", None))

    return render(request, "auth/login.html", {"form": form})


@require_http_methods(["POST"])
def login_action(request):
    form = AuthenticationForm(request, data=request.POST)

    if not form.is_valid():
        request.session["_old_data"] = request.POST
        messages.error(request, "Invalid username or password.")
        return redirect("login")

    username = form.cleaned_data.get("username")
    password = form.cleaned_data.get("password")
    user = authenticate(username=username, password=password)

    if not user:
        request.session["_old_data"] = request.POST
        messages.error(request, "Invalid username or password.")
        return redirect("login")

    login(request, user)

    return redirect("home")


def logout_view(request):
    logout(request)
    return redirect("home")
