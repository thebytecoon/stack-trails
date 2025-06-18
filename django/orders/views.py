from django.shortcuts import render
from .models import Order

def index(request):
    orders = Order.objects.filter(user_id=1)

    return render(request, "orders/index.html", {
        "orders": orders
    })