from django.shortcuts import render, get_object_or_404
from orders.models import Order, OrderItem
from django.views.decorators.http import require_GET, require_POST
from django.contrib.auth.decorators import login_required
from ..forms import ReviewForm
from reviews.models import Review


@login_required
@require_GET
def create(request, order_code, item_id):
    user = request.user

    query = OrderItem.objects.filter(
        id=item_id, order__code=order_code, order__user=user
    )

    item = get_object_or_404(query)

    product = item.product

    form = ReviewForm()

    return render(
        request,
        "user_profile/orders/reviews/create.html",
        {
            "item": item,
            "form": form,
            "product": product,
        },
    )


@login_required
@require_POST
def store(request, order_code, item_id):
    user = request.user

    query = OrderItem.objects.filter(
        id=item_id, order__code=order_code, order__user=user
    )

    item = get_object_or_404(query)

    product = item.product

    form = ReviewForm(request.POST)

    if not form.is_valid():
        return render(
            request,
            "user_profile/orders/reviews/create.html",
            {
                "item": item,
                "form": form,
                "product": product,
            },
        )

    review_data = form.cleaned_data

    product.reviews.create(
        user=user,
        item=item,
        rating=review_data["rating"],
        title=review_data["title"],
        comment=review_data["comment"],
    )

    return render(request, "user_profile/orders/reviews/model_success.html", {})


@login_required
@require_GET
def edit(request, order_code, item_id, review_id):
    user = request.user

    query = Review.objects.filter(id=review_id, item_id=item_id, user=user)

    review = get_object_or_404(query)

    product = review.product
    item = review.item

    form = ReviewForm(initial=review.__dict__)

    return render(
        request,
        "user_profile/orders/reviews/edit.html",
        {
            "item": item,
            "form": form,
            "product": product,
            "review": review,
        },
    )


@login_required
@require_POST
def update(request, order_code, item_id, review_id):
    user = request.user

    query = Review.objects.filter(id=review_id, item_id=item_id, user=user)

    review = get_object_or_404(query)

    product = review.product
    item = review.item

    form = ReviewForm(request.POST)

    if not form.is_valid():
        return render(
            request,
            "user_profile/orders/reviews/edit.html",
            {
                "item": item,
                "form": form,
                "product": product,
                "review": review,
            },
        )

    review_data = form.cleaned_data

    review.rating = review_data["rating"]
    review.title = review_data["title"]
    review.comment = review_data["comment"]
    review.save()

    return render(request, "user_profile/orders/reviews/model_success.html", {})
