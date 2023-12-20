<?php

namespace Hoadev\CoreBlog\Classes;

use Hoadev\CoreBlog\Models\Media;

class Image {

    public $parent_path;
    public $image;
    public string $imageName;
    public $size;
    public $width;
    public $height;
    public $mime_type;
    public $extension;
    public $imageData;

    public function loadFile($image, $parent_path = 'uploads/media/')
    {
        $this->parent_path = $parent_path;
        $this->image = $image->move($this->parent_path, $image->getClientOriginalName());
        $this->imageName = $image->getClientOriginalName();
        $this->size = $this->image->getSize();
        $dataDemen = getimagesize($this->image);
        $this->width = $dataDemen[0];
        $this->height = $dataDemen[1];
        $this->mime_type = $image->getClientmimeType();
        $this->extension = $image->getClientOriginalExtension();//Getting extension
        $this->loadImageData();
    }

    public function loadImageData()
    {
        if ($this->mime_type ===  'image/jpeg') {

            $this->imageData = imagecreatefromjpeg($this->image);

        } elseif ($this->mime_type ===  'image/webp') {

            $this->imageData = imagecreatefromwebp($this->image);

        }elseif ($this->mime_type ===  'image/png') {

            $this->imageData = imagecreatefrompng($this->image);

        } elseif ($this->mime_type ===  'image/gif') {

            $this->imageData = imagecreatefromgif($this->image);

        }
    }

/*     public function setThumbnailSize() {
        $new_width = 150;
        $new_height = 150;
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $this->imageData, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $this->saveImage($new_image, 'thumbnail_');
    } */
    //con loi ko ngay center
    public function setThumbnailSize() {
        $size = min(imagesx($this->imageData), imagesy($this->imageData));
        $croped_image = imagecrop($this->imageData, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);

        $thumbnail = $this->resize_to_width(150, $croped_image, $size, $size);

        /* $new_width = 200;
        $new_height = 200;
        $resized_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($resized_image, $croped_image, 0, 0, 0, 0, $new_width, $new_height, $size, $size); */
        imagedestroy($croped_image);
        return $this->saveImage($thumbnail, 'thumbnail_');
    }

    public function setMediumSize() {
        if($this->width >= $this->height) {
            $medium = $this->resize_to_width(300, $this->imageData, $this->width, $this->height);
        } else {
            $medium = $this->resize_to_height(300, $this->imageData, $this->width, $this->height);
        }
        return $this->saveImage($medium, 'medium_');
    }

    public function setLargeSize() {
        if($this->width >= $this->height) {
            $large = $this->resize_to_width(768, $this->imageData, $this->width, $this->height);
        } else {
            $large = $this->resize_to_height(768, $this->imageData, $this->width, $this->height);
        }
        return $this->saveImage($large, 'large_');
    }

    public function setExtraSize() {
        if($this->width >= $this->height) {
            $extra = $this->resize_to_width(1024, $this->imageData, $this->width, $this->height);
        } else {
            $extra = $this->resize_to_height(1024, $this->imageData, $this->width, $this->height);
        }
        return $this->saveImage($extra, 'extra_');
    }

    public function setWideSize() {
        if($this->width >= $this->height) {
            $wide = $this->resize_to_width(1280, $this->imageData, $this->width, $this->height);
        } else {
            $wide = $this->resize_to_height(1280, $this->imageData, $this->width, $this->height);
        }
        return $this->saveImage($wide, 'wide_');
    }

    public function setResponsive() {
        return [
            'thumbnail' => $this->setThumbnailSize(),
            'medium' => $this->setMediumSize(),
            'large' => $this->setLargeSize(),
            'extra' => $this->setExtraSize(),
            'wide' => $this->setWideSize(),
        ];
    }

    //from
    function resize_image($new_width, $new_height, $image, $width, $height)
    {
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        return $new_image;
    }

    //from
    function resize_to_width($new_width, $image, $width, $height)
    {
        $resize_ratio = $new_width / $width;
        $new_height = $height * $resize_ratio;
        return $this->resize_image($new_width, $new_height, $image, $width, $height);
    }

    function resize_to_height($new_height, $image, $width, $height)
    {
        $ratio = $new_height / $height;
        $new_width = $width * $ratio;
        return $this->resize_image($new_width, $new_height, $image, $width, $height);
    }

    public function saveImage($new_image, $prefix = '', $quality=90)
    {

        $path = $this->parent_path.$prefix.$this->imageName;

        if ($this->mime_type ===  'image/jpeg') {
            imagejpeg($new_image, $path, $quality);

        } elseif ($this->mime_type ===  'image/webp') {

            imagewebp($new_image, $path, $quality);

        }elseif ($this->mime_type ===  'image/png') {

            imagepng($new_image, $path, $quality);

        } elseif ($this->mime_type ===  'image/gif') {

            imagegif($new_image, $path, $quality);

        }

        imagedestroy($new_image);

        return $path;
    }

    public function getPath() : string {
        return '/'.$this->parent_path.$this->imageName;
    }

    public function getUrl() : string {
        return '/'.$this->parent_path.$this->imageName;
    }

}
