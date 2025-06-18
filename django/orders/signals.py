from .models import Order
from django.db.models.signals import pre_save
from django.dispatch import receiver
import uuid


@receiver(pre_save, sender=Order)
def add_uuid_to_order(sender, instance, **kwargs):
    if not instance.code:
        instance.code = str(uuid.uuid4())
