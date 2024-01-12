<?php

return [

    'menu' => [
        'dashboard' => [
            'name' => 'Dashboard',
            'link' => null,
            'routeName' => 'dashboard'
        ],
/*         'dashboard' => [
            'name' => 'Dashboard',
            'link' => route('dashboard')
        ], */
    ],

    'admin_bar' => [
        'dashboard' => [
            'name' => 'Dashboard',
            'link' => null,
            'routeName' => 'dashboard'
        ]
    ],

    //Custom Post types config
    'post_types' => [
        'post' => [
            'type' => 'post',
            'labels' => [
                'name' => 'Posts',
                'singular_name' => 'Post',
                'vietsub' => 'Bài viết'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'taxonomies' => [
                'category',
                'tag'
            ],
            'has_archive' => true,
            'archive_page' => 'blog',
        ],

        'page' => [
            'type' => 'page',
            'labels' => [
                'name' => 'Pages',
                'singular_name' => 'Page',
                'vietsub' => 'Trang'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'taxonomies' => [],
            'has_archive' => false,
            'archive_page' => '',
        ],

        'product' => [
            'type' => 'product',
            'labels' => [
                'name' => 'Products',
                'singular_name' => 'Product',
                'vietsub' => 'Sản phẩm'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'taxonomies' => [
                'product_category',
                'brand'
            ],
            'has_archive' => true,
            'archive_page' => 'san-pham',
        ],

/*         'custom' => [
            'type' => 'custom',
            'labels' => [
                'name' => 'Customs',
                'singular_name' => 'Custom',
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'taxonomies' => [
                'custom_tax'
            ],
            'has_archive' => true,
        ], */
    ],

    //Custom taxinomies config
    'taxonomies' => [

        'category' => [
            'taxonomy' => 'category',
            'labels' => [
                'name' => 'Categories',
                'singular_name' => 'Category',
                'vietsub' => 'Chuyên mục'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
        ],

        'tag' => [
            'taxonomy' => 'tag',
            'labels' => [
                'name' => 'Tags',
                'singular_name' => 'Tag',
                'vietsub' => 'Từ khóa'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => false,
        ],

        'product_category' => [
            'taxonomy' => 'product_category',
            'labels' => [
                'name' => 'Product Categories',
                'singular_name' => 'Product Category',
                'vietsub' => 'Danh mục sản phẩm'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
        ],

        'brand' => [
            'taxonomy' => 'brand',
            'labels' => [
                'name' => 'Brands',
                'singular_name' => 'Brand',
                'vietsub' => 'Thương hiệu'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
        ],

        'custom_tax' => [
            'taxonomy' => 'custom_tax',
            'labels' => [
                'name' => 'Custom Taxonomies',
                'singular_name' => 'Custom Taxonomy',
                'vietsub' => 'Custom Taxonomy'
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
        ],
    ]


];
