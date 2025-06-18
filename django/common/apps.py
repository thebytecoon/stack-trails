from django.apps import AppConfig
from .utils import slugify_field
from django.db.models.signals import pre_save


class CommonConfig(AppConfig):
    default_auto_field = 'django.db.models.BigAutoField'
    name = 'common'

    def ready(self):
        pre_save.connect(slugify_field)
