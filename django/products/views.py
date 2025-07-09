from django.shortcuts import render, get_object_or_404, redirect
from django.core.paginator import Paginator
from .forms import ProductFilters, ProductForm
from .models import Product
from django.db.models import Q
from django.views.decorators.http import require_GET, require_POST
import json
from django.contrib import messages
from django.db.models import Count, Q
from colors.models import Color
from product_storage.models import ProductStorage


@require_GET
def index(request):
    filters_form = ProductFilters(request.GET)

    query = Product.objects.wherePublished().withAllFields()

    if request.GET.get("categories"):
        query = query.filter(category__name__in=request.GET.getlist("categories"))

    if request.GET.get("brands"):
        query = query.filter(brand__name__in=request.GET.getlist("brands"))

    if request.GET.get("price"):
        price_range = request.GET.get("price").split("-")
        if len(price_range) == 2:
            query = query.filter(price__gte=int(price_range[0]))
            query = query.filter(price__lte=int(price_range[1]))

    if request.GET.get("search"):
        query = query.filter(name__contains=request.GET.get("search"))

    if request.GET.get("sort_by") != None:
        sort_by = request.GET.get("sort_by")
        if sort_by == "price-asc":
            query = query.order_by("price")
        elif sort_by == "price-desc":
            query = query.order_by("-price")
        elif sort_by == "featured":
            query = query.order_by("-featured", "-id")
        elif sort_by == "newest":
            query = query.order_by("-created_at", "-id")
        elif sort_by == "best-selling":
            query = query.annotate(
                paid_sales=Count(
                    "order_items", filter=Q(order_items__order__status="paid")
                )
            ).order_by("-paid_sales", "-created_at", "-id")
        else:
            query = query.order_by("-created_at", "-id")
    else:
        query = query.order_by("-created_at", "-id")

    paginator = Paginator(query, 15)

    page_number = request.GET.get("page")
    products = paginator.get_page(page_number)

    return render(
        request,
        "products/index.html",
        {
            "page_obj": products,
            "products": products,
            "paginator": paginator,
            "filters": filters_form,
        },
    )


@require_GET
def show(request, id):
    query = Product.objects.wherePublished().withAllFields()
    product = get_object_or_404(query, slug=id)

    available_colors = Color.objects.all()
    available_storage = ProductStorage.objects.all()
    selected_color = None
    selected_storage = None

    if request.GET.get("color"):
        selected_color = int(request.GET.get("color"))
    
    if request.GET.get("storage"):
        selected_storage = int(request.GET.get("storage"))

    if request.GET.get("quantity"):
        quantity = int(request.GET.get("quantity"))
    else:
        quantity = 1

    can_add_to_cart = selected_color is not None and selected_storage is not None and quantity > 0

    if product.stock < quantity:
        can_add_to_cart = False
        quantity = product.stockç

    return render(request, "products/show.html", {
        "product": product,
        "available_colors": available_colors,
        "selected_color": selected_color,
        "available_storage": available_storage,
        "selected_storage": selected_storage,
        "can_add_to_cart": can_add_to_cart,
        "quantity": quantity,
    })


@require_GET
def create(request):
    if request.session.get("form"):
        form = ProductForm(request.session["form"])

        if request.session.has_key("errors"):
            errors = json.loads(request.session.get("errors"))

            if errors:
                for field, error in errors.items():
                    if field == "image":
                        form.add_error(field, error)

                del request.session["errors"]

        del request.session["form"]
    else:
        form = ProductForm()

    return render(request, "products/create.html", {"form": form})


@require_POST
def store(request):
    form = ProductForm(request.POST, request.FILES)

    if not form.is_valid():
        request.session["form"] = form.data
        request.session["errors"] = form.errors.as_json()

        return redirect("home")

    data = form.cleaned_data
    data["user_id"] = 1

    product = Product(**data)
    product.save()

    messages.success(request, "Producto creado exitosamente")

    return redirect("products.show", id=product.id)


@require_GET
def edit(request, id):
    product = get_object_or_404(Product, id=id)

    if request.session.get("form"):
        form = ProductForm(request.session["form"])

        if request.session.has_key("errors"):
            errors = json.loads(request.session.get("errors"))

            if errors:
                for field, error in errors.items():
                    if field == "image":
                        form.add_error(field, error)

                del request.session["errors"]

        del request.session["form"]
    else:
        form = ProductForm(product.__dict__)

    return render(
        request,
        "products/edit.html",
        {
            "form": form,
            "product": product,
        },
    )


@require_POST
def update(request, id):
    product = get_object_or_404(Product, id=id)

    form = ProductForm(request.POST, request.FILES)

    if not form.is_valid():
        request.session["form"] = form.data
        request.session["errors"] = form.errors.as_json()

        return redirect("home")

    data = form.cleaned_data

    for key, value in data.items():
        setattr(product, key, value)

    product.save()

    messages.success(request, "Producto actualizado exitosamente")

    return redirect("products.show", id=product.id)
