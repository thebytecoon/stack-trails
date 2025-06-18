from django.http import JsonResponse
from django.db.models import Q
from .models import Product


def search(request):
    query = request.GET.get("q", "")

    if not query:
        return JsonResponse({"error": "Query parameter is required"}, status=400)

    products = (
        Product.objects.filter(
            Q(name__icontains=query)
            | Q(description__icontains=query)
            | Q(brand__name__icontains=query)
            | Q(category__name__icontains=query)
        )
        .all()
        .order_by("-id")[:5]
    )

    if not products:
        return JsonResponse({"error": "No products found"}, status=404)

    product_data = []
    for product in products:
        product_data.append(
            {
                "id": product.id,
                "url": product.get_url(),
                "name": product.name,
                "price": str(product.price),
                "slug": product.slug,
                "brand": product.brand.name if product.brand else None,
                "category": product.category.name if product.category else None,
                "stock": product.stock,
                "sku": product.sku,
                "image": product.image_url_sm,
                "description": product.description,
            }
        )

    return JsonResponse(product_data, status=200, safe=False)
