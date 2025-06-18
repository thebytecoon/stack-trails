from django.shortcuts import render, redirect
from django.views.decorators.http import require_GET
from django.contrib.auth.decorators import login_required
from ..forms import OrderFiltersForm
from datetime import datetime, timedelta
from django.utils import timezone
from django.core.paginator import Paginator
from orders.models import OrderStatusEnum
from django.http import Http404


@login_required
@require_GET
def index(request):
    user = request.user

    form = OrderFiltersForm(user, request.GET)

    form.is_valid()
    data = form.cleaned_data

    query = (
        user.orders.filter(status=OrderStatusEnum.PAID)
        .prefetch_related("order_items")
        .order_by("-created_at")
    )

    if data["date"]:
        date_range = data["date"].split("-")
        if len(date_range) == 1:
            year = int(date_range[0])
            start = datetime(year, 1, 1)
            end = datetime(year + 1, 1, 1)
            query = query.filter(created_at__gte=start, created_at__lt=end)
        elif len(date_range) == 2:
            now = datetime.now()
            now = timezone.make_aware(now)

            query = query.filter(
                created_at__gte=now - timedelta(days=int(date_range[1]))
            )

    if data["search"]:
        query = query.filter(order_items__product__name__icontains=data["search"])

    paginator = Paginator(query, 6)

    page_number = request.GET.get("page")
    orders = paginator.get_page(page_number)

    return render(
        request,
        "user_profile/orders/index.html",
        {"page_obj": orders, "orders": orders, "form": form},
    )


@login_required
@require_GET
def show(request, code):
    user = request.user

    order = (
        user.orders.filter(code=code, status=OrderStatusEnum.PAID)
        .prefetch_related("order_items")
        .first()
    )

    if not order:
        return Http404("Order not found or you do not have permission to view it.")

    return render(
        request,
        "user_profile/orders/show.html",
        {
            "order": order,
        },
    )
