<?php

namespace Hoadev\CoreBlog\Models;

use Hoadev\CoreBlog\Traits\Media\HasResponsive;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory, HasResponsive;

    protected $table = 'media';

    public const TYPE_OTHER = 'other';

/*     protected $appends = ['url']; */

    protected $guarded = [];
/*
    protected $appends = ['original_url', 'preview_url']; */

    protected $casts = [
        'manipulations' => 'array',
        'custom_properties' => 'array',
        'generated_conversions' => 'array',
        'responsive_images' => 'array',
    ];


    public function getFullUrl()
    {
        return config('app.url').$this->getPath();
    }

    public function getUrl()
    {
        return $this->custom_properties['url'];
    }

/*     public function getUrlAttribute()
    {
        return $this->custom_properties['url'];
    } */

    public function getFullPath() {
        return public_path().$this->getPath();
    }

    public function getPath()
    {
        return $this->custom_properties['path'];
    }

    public function getPathRelativeToRoot()
    {

    }

    public function getAvailableUrl(array $conversionNames)
    {

    }

    public function getAvailableFullUrl(array $conversionNames)
    {

    }

    public function getAvailablePath(array $conversionNames)
    {

    }

    protected function type(): Attribute
    {
        return Attribute::get(
            function () {
                $type = $this->getTypeFromExtension();

                if ($type !== self::TYPE_OTHER) {
                    return $type;
                }

                return $this->getTypeFromMime();
            }
        );
    }



}
