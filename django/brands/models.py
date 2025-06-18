from django.db import models

class Brand(models.Model):
    name = models.CharField(max_length=255, editable=False)
    display_name = models.CharField(max_length=255)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        db_table = 'brands'
    
    def __str__(self):
        return self.display_name
    
    
    def sluggable(self):
        return {
            'name': {
                'source': 'display_name',
            }
        }