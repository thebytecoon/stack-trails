from django import template
from urllib.parse import urlencode

register = template.Library()

@register.simple_tag(takes_context=True)
def querystring(context, **kwargs):
    request = context['request']
    query = request.GET.copy()
    for key, value in kwargs.items():
        query[key] = value
    return '?' + urlencode(query)