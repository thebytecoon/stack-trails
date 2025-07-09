<?php

namespace App\Concerns;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (!method_exists($model, 'sluggable')) {
                return;
            }

            $sluggable = $model->sluggable();

            if (
                !array_key_exists('source', $sluggable) ||
                !array_key_exists('dest', $sluggable)
            ) {
                return;
            }

            $source_field_name = $sluggable['source'];

            $slug = str($model->{$source_field_name})->slug();

            if (!$slug) {
                return;
            }

            $i = 1;
            while (true) {
                $found = $model->query()->where($source_field_name, $slug)->exists();

                if (!$found) {
                    $model->{$sluggable['dest']} = $slug;
                    break;
                }

                $slug = $slug . '_' . $i;
                $i++;
            }
        });
    }
}
