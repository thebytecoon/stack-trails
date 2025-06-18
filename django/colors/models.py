from django.db import models

# Create your models here.
class Color(models.Model):
    name = models.CharField(max_length=100, unique=True)
    display_name = models.CharField(max_length=100, unique=True)
    hex_code = models.CharField(max_length=7, unique=True)

    class Meta:
        db_table = 'colors'

    def __str__(self):
        return self.name
    
    def sluggable(self):
        return {
            'name': {
                'source': 'display_name',
            }
        }