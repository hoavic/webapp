<?php

namespace Hoadev\CoreBlog\Classes;

class ItemListElement {

    public string $type = 'ListItem';
    public string $position;
    public string $name;
    public string $item;

    public function __construct($position, $name, $item)
    {
        $this->position = $position;
        $this->name = $name;
        $this->item = $item;
    }

}
