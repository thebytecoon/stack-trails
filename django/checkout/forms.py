from django import forms
from orders.models import ShippingOption
from django.urls import reverse


class ShippingRadioSelect(forms.RadioSelect):
    template_name = "checkout/forms/shipping_radio_select.html"

    def create_option(
        self, name, value, label, selected, index, subindex=None, attrs=None
    ):
        data = label.split("|")

        options = super().create_option(
            name, value, data[0], selected, index, subindex, attrs
        )

        options["price"] = float(data[1])
        options["description"] = data[2]

        return options


class AddressRadioSelect(forms.RadioSelect):
    template_name = "checkout/forms/address_radio_select.html"

    def create_option(
        self, name, value, label, selected, index, subindex=None, attrs=None
    ):
        data = label.split("|")

        options = super().create_option(
            name, value, data[0], selected, index, subindex, attrs
        )

        options["description"] = data[1]

        return options


class CheckoutForm(forms.Form):
    address = forms.ChoiceField(
        label="Shipping Address",
        choices=[],
        required=True,
        widget=AddressRadioSelect(),
    )
    shipping_option = forms.ChoiceField(
        label="Shipping Option",
        choices=[],
        required=True,
        widget=ShippingRadioSelect(),
    )
    payment_method = forms.ChoiceField(
        label="Payment Method",
        choices=[],
        required=True,
        widget=forms.Select(
            attrs={
                "class": "w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-revolut-blue focus:border-transparent mb-4"
            }
        ),
    )

    def __init__(self, user, order, *args, **kwargs):
        super().__init__(*args, **kwargs)

        payment_methods_list = []
        for payment_method in user.payment_methods.all():
            payment_methods_list.append(
                (payment_method.id, payment_method.name_for_list)
            )
        self.fields["payment_method"].choices = payment_methods_list

        shipping_address_list = []
        for shipping_address in ShippingOption.objects.all():
            shipping_address_list.append(
                (
                    shipping_address.id,
                    f"{shipping_address.name}|{shipping_address.price}|{shipping_address.description}",
                )
            )

        self.fields["shipping_option"].choices = shipping_address_list
        self.fields["shipping_option"].widget.attrs.update(
            {
                "hx-post": reverse("checkout.update_shipping", args=[order.code]),
                "hx-target": "#checkout-order-summary",
                "hx-trigger": "click",
            }
        )

        adddress_list = []
        for address in user.addresses.all():
            description = address.address_line_1
            adddress_list.append((address.id, f"{address.name}|{description}"))
        self.fields["address"].choices = adddress_list
