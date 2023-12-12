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
        ],

        'page' => [
            'type' => 'page',
            'labels' => [
                'name' => 'Pages',
                'singular_name' => 'Page',
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'taxonomies' => [],
            'has_archive' => true,
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
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => false,
        ],

        'custom_tax' => [
            'taxonomy' => 'custom_tax',
            'labels' => [
                'name' => 'Custom Taxonomies',
                'singular_name' => 'Custom Taxonomy',
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
