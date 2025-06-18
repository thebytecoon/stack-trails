from django import forms


class AddressForm(forms.Form):
    name = forms.CharField(
        max_length=100,
        required=True,
        label="Name",
    )
    names = forms.CharField(
        max_length=100,
        required=False,
        label="Names",
    )
    address_line_1 = forms.CharField(
        max_length=255,
        required=True,
        label="Address Line 1",
    )
    address_line_2 = forms.CharField(
        max_length=255,
        required=True,
        label="Address Line 2",
    )
    phone_number = forms.CharField(
        max_length=20,
        required=True,
        label="Phone Number",
    )
    city = forms.CharField(
        max_length=100,
        required=True,
        label="City",
    )
    state = forms.CharField(
        max_length=100,
        required=True,
        label="State",
    )
    postal_code = forms.CharField(
        max_length=20,
        required=True,
        label="Postal Code",
    )
    country = forms.CharField(
        max_length=100,
        required=True,
        label="Country",
    )
    default = forms.BooleanField(
        required=False,
        label="Use as default",
    )

    INPUT_CLASSES = "w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-store-blue"
    CHECKBOX_CLASSES = (
        "h-4 w-4 text-store-blue focus:ring-store-blue border-gray-300 rounded"
    )

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        for name, field in self.fields.items():
            if isinstance(field, forms.BooleanField):
                # checkbox styling
                field.widget.attrs.update({"class": self.CHECKBOX_CLASSES})
            else:
                # text/select/etc styling + placeholder
                field.widget.attrs.update(
                    {
                        "class": self.INPUT_CLASSES,
                        "placeholder": field.label or name.replace("_", " ").title(),
                    }
                )
