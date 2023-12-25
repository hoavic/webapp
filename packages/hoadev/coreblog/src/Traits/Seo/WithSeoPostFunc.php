<?php

namespace Hoadev\CoreBlog\Traits\Seo;

trait WithSeoPostFunc {

    public function getMetaTitle()
    {
        if(isset($this->postMetas['meta_title']) || $this->postMetas['meta_title'][0] !== '') {
            return $this->postMetas['meta_title'][0];
        }

        return $this->title;
    }

    public function getMetaDescription()
    {
        if(isset($this->postMetas['meta_description']) && $this->postMetas['meta_description'][0] !== '') {
            return $this->postMetas['meta_description'][0];
        }

        return $this->getExcerpt(15, '');
    }

}
