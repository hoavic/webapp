<?php

namespace Hoadev\CoreBlog\Classes;

use Hoadev\CoreBlog\Models\Media;

class Image {

    public $parent_path;
    public $image;
    public $originImageName;
    public string $name;
    public string $imageName;
    public $size;
    public $width;
    public $height;
    public $mime_type;
    public $extension;
    public $imageData;

    public function loadFile($image, $parent_path = 'uploads/media/', $convert_to_webp = false)
    {
        $this->parent_path = $parent_path;
        $this->image = $image->move($this->parent_path, $image->getClientOriginalName());
        $this->size = $this->image->getSize();
        $dataDemen = getimagesize($this->image);
        $this->width = $dataDemen[0];
        $this->height = $dataDemen[1];
        $this->mime_type = $image->getClientmimeType();
        $this->extension = $image->getClientOriginalExtension();//Getting extension
        $this->loadImageData();
        $this->name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $this->originImageName = $this->name.'.'.$this->extension;
        if($convert_to_webp) {
            $this->convertToWebp();
        } else {
            $this->imageName = $image->getClientOriginalName();
        }
    }

    public function convertToWebp() {
        $this->mime_type ===  'image/webp';
        $this->imageName = $this->name.'.webp';
        $this->extension = '.webp';
        $this->saveImage($this->imageData);
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

    //con loi ko ngay center
    public function setThumbnailSize() {
        $size = min(imagesx($this->imageData), imagesy($this->imageData));
        $croped_image = imagecrop($this->imageData, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);

        $thumbnail = $this->resize_to_width(150, $croped_image, $size, $size);

        imagedestroy($croped_image);
        return $this->saveImage($thumbnail, '_150px');
    }

    public function setMediumSize() {
        $medium = $this->resize_to_width(300, $this->imageData, $this->width, $this->height);
        return $this->saveImage($medium, '_300px');
    }

    public function setMediumLargeSize() {
        $medium = $this->resize_to_width(600, $this->imageData, $this->width, $this->height);
        return $this->saveImage($medium, '_600px');
    }

    public function setLargeSize() {
        $large = $this->resize_to_width(800, $this->imageData, $this->width, $this->height);
        return $this->saveImage($large, '_800px');
    }

    public function setWideSize() {
        $wide = $this->resize_to_width(1200, $this->imageData, $this->width, $this->height);
        return $this->saveImage($wide, '_1200px');
    }

    public function setExtraSize() {
        $extra = $this->resize_to_width(1500, $this->imageData, $this->width, $this->height);
        return $this->saveImage($extra, '_1500px');
    }

    public function setFullSize() {
        $extra = $this->resize_to_width(1920, $this->imageData, $this->width, $this->height);
        return $this->saveImage($extra, '_1920px');
    }

    public function setResponsive($optimized_for_blog = true, $optimized_for_product = false, $optimized_for_template = false) {
        $res = [];

        if($this->width > 150) {
            $res['thumbnail'] = $this->setThumbnailSize();
        }

        if($this->width > 300) {
            $res['medium'] = $this->setMediumSize();
        }

        if($optimized_for_blog) {

            if($this->width > 600) {
                $res['medium_large'] = $this->setMediumLargeSize();
            }

            if($this->width > 800) {
                $res['large'] = $this->setLargeSize();
            }

            if($this->width > 1200) {
                $res['wide'] = $this->setWideSize();
            }

        }

        if($optimized_for_product) {

            if($this->width > 1500) {
                $res['extra'] = $this->setExtraSize();
            }

        }

        if($optimized_for_template) {

            if($this->width > 1920) {
                $res['full'] = $this->setFullSize();
            }

        }

        return $res;
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

        $path = $this->parent_path.$this->name.$prefix.$this->extension;

        if ($this->mime_type ===  'image/jpeg') {

            imagejpeg($new_image, $path, $quality);

        } elseif ($this->mime_type ===  'image/webp') {

            imagewebp($new_image, $path, $quality);

        }elseif ($this->mime_type ===  'image/png') {

            imagepng($new_image, $path, $quality/10);

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

    public function getOriginUrl() : string {
        return '/'.$this->parent_path.$this->originImageName;
    }

}
