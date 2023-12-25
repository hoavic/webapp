<?php

namespace Hoadev\CoreBlog\Traits\Seo;

trait WithSeoTermFunc {

    public function getMetaTitle()
    {
        if(isset($this->termMetas['meta_title']) || $this->termMetas['meta_title'][0] !== '') {
            return $this->termMetas['meta_title'][0];
        }

        return $this->title;
    }

    public function getMetaDescription()
    {
        if(isset($this->termMetas['meta_description']) && $this->termMetas['meta_description'][0] !== '') {
            return $this->termMetas['meta_description'][0];
        }

        return $this->getExcerpt(15, '');
    }

}
