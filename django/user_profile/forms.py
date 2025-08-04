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


class ReviewForm(forms.Form):
    rating = forms.IntegerField(
        label="Rating",
        required=True,
        min_value=1,
        max_value=5,
        widget=forms.HiddenInput(),
    )
    title = forms.CharField(
        label="Title",
        max_length=100,
        widget=forms.TextInput(
            attrs={
                "class": "w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent",
                "placeholder": "Review title",
            }
        ),
        required=True,
    )
    comment = forms.CharField(
        label="Comment",
        widget=forms.Textarea(
            attrs={
                "class": "w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent resize-none",
                "rows": 4,
                "placeholder": "Write your review here...",
            }
        ),
        required=False,
    )
