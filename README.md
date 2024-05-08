# Unique Slug generator in PHP (Laravel)

### Description
Create Slug avoiding the hassle of any sort of regex match. It creates an unique slug but maintain a sequential numeric suffix if needed.

### Usage Guide
- Just integrate UniqueSlugGeneratorHelper::class inside your project and call generateUniqueSlug() with specific params

## parameters
- $model (required) ; It defines model name
- $title (required) ; It defines title that you need to convert as slug
- $suffix (optional) ; If you want to add a suffix as your wish



----------------------------------------------------




# Alternative way with laravel Eloquent Builder macro

Add this code to the `boot` method of your `AppServiceProvider` in your project.

```php
use Illuminate\Database\Eloquent\Builder;

Builder::macro('withSlug', function (string $sourceAttributeName = 'title', string $slugAttributeName = 'slug') {
    /** @var \Illuminate\Database\Eloquent\Model $this */
    $model = $this->getModel();

    $generator = function ($model, $count = 0) use ($sourceAttributeName, $slugAttributeName, &$generator) {
        $slug = Str::slug($model->getAttribute($sourceAttributeName));
        $slug = $count === 0 ? $slug : $slug . '-' . $count;
        $exists = $model->where($slugAttributeName, $slug)->exists();
        return $exists ? $generator($model, $count + 1) : $slug;
    };

    $model::creating(function ($model) use ($slugAttributeName, $generator) {
        $model->setAttribute($slugAttributeName, $generator($model));
    });

    return $this;
});
```

### Usage Guide
After adding the builder macro, you will gain access to the `withSlug` method, which generates a unique slug. This method not only generates the slug but also sets it within the model attributes.

#### Parameters
- $sourceAttributeName: Name of the attribute used to fetch text for the slug.
- $slugAttributeName: Name of the attribute used to store the slug.

```php
ContentType::withSlug('name_en', 'slug')->create([
    'name_en' => 'Blog',
    'name_bn' => 'ব্লগ',
]);
```


### Contributed by

<b>Arafat Rahman</b> <br>
Software Engineer <br>
Email: atrahmanbd5@gmail.com <br>




