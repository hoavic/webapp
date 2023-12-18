<?php

namespace Hoadev\CoreBlog\Traits\Media;

use Hoadev\CoreBlog\Models\Comment;
use Hoadev\CoreBlog\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Intervention\Image\ImageManager;

trait HasResponsive {

    /**
     * $iamge
     * $
     */
    public function setResponsive() {

        $manager = ImageManager::gd();
        dd($this->custom_properties);
        $readed = $manager->read($this->media->getFullPath());
        dd($readed);
    }

}
