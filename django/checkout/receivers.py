from orders.models import Order
from django.dispatch import receiver
from .signals import order_was_purchased
from django.core.mail import EmailMultiAlternatives
from django.template.loader import render_to_string

@receiver(order_was_purchased)
def send_purchase_confirmation_email(sender, order: Order, **kwargs):
    text_content = render_to_string(
        "mails/purchase.txt",
        context={
            "order": order
        },
    )

    html_content = render_to_string(
        "mails/purchase.html",
        context={
            "order": order
        },
    )

    email = EmailMultiAlternatives(
        "Sistema PQR",
        text_content,
        "tiendita@localhost.com",
        ["admin@localhost.com"],
        reply_to=["tiendita@localhost.com"],
    )

    email.attach_alternative(html_content, "text/html")

    email.send(fail_silently=False)