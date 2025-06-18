from django import forms
from categories.models import Category
from brands.models import Brand
from django.db.models import OuterRef, Subquery, Count
from products.models import Product


class ProductFilters(forms.Form):
    categories = forms.ChoiceField(
        label="Categories",
        required=False,
        choices=[],
        widget=forms.CheckboxSelectMultiple(
            attrs={"onclick": "this.form.submit()", "class": "space-y-2"}
        ),
    )
    price = forms.ChoiceField(
        label="Price range",
        choices=[
            ("0-100", "Under $100"),
            ("100-500", "$100 - $500"),
            ("500-1000", "$500 - $1000"),
            ("1000-10000", "Over $1000"),
        ],
        required=False,
        widget=forms.RadioSelect(
            attrs={"onclick": "this.form.submit()", "class": "space-y-2"}
        ),
    )
    brands = forms.ChoiceField(
        label="Brands",
        required=False,
        choices=[],
        widget=forms.CheckboxSelectMultiple(
            attrs={"onclick": "this.form.submit()", "class": "space-y-2"}
        ),
    )
    sort_by = forms.ChoiceField(
        label=False,
        required=False,
        choices=[
            ("", "Sort by"),
            ("featured", "Featured"),
            ("price-asc", "Price: Low to High"),
            ("price-desc", "Price: High to Low"),
            ("newest", "Newest First"),
            ("best-selling", "Best Selling"),
        ],
        widget=forms.Select(
            attrs={
                "onchange": "this.form.submit()",
                "class": "border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-store-blue",
            }
        ),
    )

    def __init__(self, *args, **kwargs):
        super(ProductFilters, self).__init__(*args, **kwargs)

        product_category_count_subquery = (
            Product.objects.filter(category=OuterRef("pk"))
            .wherePublished()
            .values("category")
            .annotate(count=Count("*"))
            .values("count")[:1]
        )

        categories = Category.objects.annotate(
            product_count=Subquery(product_category_count_subquery)
        )

        category_list = {}
        for category in categories:
            category_list[category.name] = (
                category.display_name + f" ({category.product_count})"
            )
        category_list = list(category_list.items())

        self.fields["categories"].choices = category_list

        product_brand_count_subquery = (
            Product.objects.filter(brand=OuterRef("pk"))
            .wherePublished()
            .values("brand")
            .annotate(count=Count("*"))
            .values("count")[:1]
        )

        brands = Brand.objects.annotate(
            product_count=Subquery(product_brand_count_subquery)
        )

        brands_list = {}
        for brand in brands:
            brands_list[brand.name] = brand.display_name + f" ({brand.product_count})"
        brands_list = list(brands_list.items())

        self.fields["brands"].choices = brands_list


class ProductForm(forms.Form):
    name = forms.CharField(
        label="Product name",
        widget=forms.TextInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    price = forms.IntegerField(
        label="Price",
        widget=forms.NumberInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    category = forms.CharField(
        label="Category",
        widget=forms.TextInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    stock = forms.IntegerField(
        label="Stick quantity",
        widget=forms.NumberInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    image = forms.FileField(
        label="Image",
        required=False,
        widget=forms.ClearableFileInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    brand = forms.CharField(
        label="Brand",
        widget=forms.TextInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    sku = forms.CharField(
        label="SKU",
        widget=forms.TextInput(
            attrs={
                "class": "w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            }
        ),
    )
    featured = forms.BooleanField(
        label="Featured product",
        required=False,
        widget=forms.CheckboxInput(
            attrs={
                "class": "h-5 w-5 text-blue-600 focus:ring-2 focus:ring-blue-600 mr-2"
            }
        ),
    )
