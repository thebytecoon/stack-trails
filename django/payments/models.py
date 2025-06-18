from django.db import models
from django.conf import settings


# Create your models here.
class PaymentMethod(models.Model):
    user = models.ForeignKey(
        settings.AUTH_USER_MODEL,
        on_delete=models.CASCADE,
        related_name="payment_methods",
    )
    type = models.CharField(max_length=100)
    card_number = models.CharField(max_length=20)
    cardholder_name = models.CharField(max_length=100)
    expiry_date = models.DateField(null=True, blank=True)
    code = models.CharField(max_length=100)
    default = models.BooleanField(default=False)
    created_at = models.DateTimeField(auto_now_add=True)

    class Meta:
        db_table = "payment_methods"

    @property
    def is_expired(self):
        from datetime import date

        return self.expiry_date < date.today() if self.expiry_date else False

    @property
    def hidden_card_number(self):
        return f"•••• •••• •••• {self.card_number}"

    @property
    def name_for_list(self):
        return f"{self.type} ending •••• {self.card_number}"

    @property
    def card_classes(self):
        if self.type == "Visa":
            return "from-blue-600 to-blue-700"
        elif self.type == "MasterCard":
            return "from-red-600 to-red-700"
        elif self.type == "American Express":
            return "from-green-600 to-green-700"
        elif self.type == "Discover":
            return "from-yellow-600 to-yellow-700"
        elif self.type == "Diners Club":
            return "from-purple-600 to-purple-700"
        elif self.type == "JCB":
            return "from-pink-600 to-pink-700"
        else:
            return ""
