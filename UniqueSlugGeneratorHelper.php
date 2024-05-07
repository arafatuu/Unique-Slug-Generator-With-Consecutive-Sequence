<?php

use Illuminate\Support\Str;

class UniqueSlugGeneratorHelper
{
    function generateUniqueSlug($model, $title, $suffix = null)
    {
        $slug = Str::slug($title);
        if ($suffix !== null) {
            $slug .= '-' . $suffix;
        }
        if ($model::where('slug', $slug)->exists()) {
            return $this->generateUniqueSlug($title, ($suffix ?? 0) + 1);
        }
        return $slug;
    }
}
