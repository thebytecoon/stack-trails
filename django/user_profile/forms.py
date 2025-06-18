from django import forms
from datetime import datetime
from orders.models import Order
from django.db.models.functions import ExtractYear


class OrderFiltersForm(forms.Form):
    date = forms.ChoiceField(
        label=False,
        required=False,
        choices=[
            ("", "All orders"),
            ("0-30", "Last 30 days"),
            ("0-90", "Last 90 days"),
            ("0-180", "Last 180 days"),
        ],
        widget=forms.Select(
            attrs={
                "onchange": "this.form.submit()",
                "class": "border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-store-blue",
            }
        ),
    )
    search = forms.CharField(
        label=False,
        required=False,
        widget=forms.TextInput(
            attrs={
                "placeholder": "Search all orders",
                "class": "border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-store-blue w-64",
            }
        ),
    )

    def __init__(self, user, *args, **kwargs):
        super().__init__(*args, **kwargs)

        years = (
            Order.objects.filter(user_id=1)
            .annotate(year=ExtractYear("created_at"))
            .values("year")
            .distinct()
        )

        current_choices = self.fields["date"].choices.copy()
        for year in years:
            if year["year"] == datetime.now().year:
                continue
            current_choices.append((year["year"], str(year["year"])))

        self.fields["date"].choices = current_choices
