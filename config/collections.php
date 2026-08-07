<?php

/**
 * Public content for Sara Bonella's academic site.
 *
 * The two small page collections below give the static exporter durable
 * list routes (/leadership and /contact) without seeding database
 * entries. Their fields remain intentionally page-like; committees, courses,
 * awards, statistics, and contact intents are not split into extra entities.
 */

return [

    'pages' => [
        'label'          => 'Pages',
        'label_singular' => 'Page',
        'icon'           => 'file',
        'route'          => '/{slug}',
        'template'       => 'page.twig',
        'order_by'       => 'updated_at DESC',
        'fields' => [
            'title'            => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'             => ['type' => 'slug', 'required' => true, 'label' => 'Slug', 'help' => 'URL path, lowercase letters, numbers, dashes.'],
            'summary'          => ['type' => 'textarea', 'label' => 'Summary'],
            'body'             => ['type' => 'markdown', 'label' => 'Body', 'help' => 'Markdown supported.'],
            'lead_image'       => ['type' => 'text', 'label' => 'Lead image', 'help' => 'Root-relative path from Media, e.g. /uploads/portrait/name.jpg.'],
            'meta_description' => ['type' => 'textarea', 'label' => 'Meta description', 'help' => 'Aim for 50–160 characters.'],
        ],
    ],

    'research_areas' => [
        'label'          => 'Research areas',
        'label_singular' => 'Research area',
        'icon'           => 'layers',
        'route'          => '/research/{slug}',
        'template'       => 'research.twig',
        'list_template'  => 'research-list.twig',
        'order_by'       => 'display_order ASC',
        'list_limit'     => 100,
        'fields' => [
            'title'         => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'          => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'summary'       => ['type' => 'textarea', 'label' => 'Summary'],
            'body'          => ['type' => 'markdown', 'label' => 'Body'],
            'lead_image'    => ['type' => 'text', 'label' => 'Lead image', 'help' => 'Root-relative path from Media, e.g. /uploads/research/name.jpg.'],
            'category'      => ['type' => 'select', 'label' => 'Category', 'options' => ['Statistical physics', 'Quantum dynamics', 'Molecular simulation', 'Electrochemical interfaces', 'Open tools & infrastructure']],
            'featured'      => ['type' => 'boolean', 'label' => 'Featured'],
            'display_order' => ['type' => 'number', 'label' => 'Display order'],
        ],
    ],

    'publications' => [
        'label'          => 'Publications',
        'label_singular' => 'Publication',
        'icon'           => 'edit',
        'route'          => '/publications/{slug}',
        'template'       => 'publication.twig',
        'list_template'  => 'publication-list.twig',
        'order_by'       => 'year DESC',
        'list_limit'     => 100,
        'fields' => [
            'title'    => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'     => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'authors'  => ['type' => 'textarea', 'label' => 'Authors'],
            'venue'    => ['type' => 'text', 'label' => 'Venue'],
            'year'     => ['type' => 'number', 'label' => 'Year'],
            'doi_url'  => ['type' => 'url', 'label' => 'DOI URL'],
            'abstract' => ['type' => 'textarea', 'label' => 'Abstract'],
            'category' => ['type' => 'select', 'label' => 'Category', 'options' => ['Statistical physics', 'Quantum dynamics', 'Molecular simulation', 'Electrochemical interfaces', 'Open tools & infrastructure']],
            'image'     => ['type' => 'text', 'label' => 'Card image', 'help' => 'Root-relative path, e.g. /uploads/publications/name.webp. Upload in Media first, then paste the path. Leave empty for no image.'],
            'image_alt' => ['type' => 'text', 'label' => 'Card image description', 'help' => 'What the image shows, for screen readers. Leave empty if it is decorative.'],
            'featured' => ['type' => 'boolean', 'label' => 'Featured', 'help' => 'Featured publications are the ones shown under “Where to start”.'],
            'display_order' => ['type' => 'number', 'label' => 'Display order', 'help' => 'Lower numbers come first within a year.'],
        ],
    ],

    'leadership_pages' => [
        'label'          => 'Teaching & community',
        'label_singular' => 'Teaching & community note',
        'icon'           => 'file',
        'route'          => '/leadership/{slug}',
        'template'       => 'page.twig',
        'list_template'  => 'leadership-list.twig',
        'order_by'       => 'updated_at DESC',
        'fields' => [
            'title'      => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'       => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'summary'    => ['type' => 'textarea', 'label' => 'Summary'],
            'body'       => ['type' => 'markdown', 'label' => 'Body'],
            'lead_image' => ['type' => 'text', 'label' => 'Lead image', 'help' => 'Root-relative path from Media.'],
        ],
    ],

    'contact_pages' => [
        'label'          => 'Contact page',
        'label_singular' => 'Contact page note',
        'icon'           => 'file',
        'route'          => '/contact/{slug}',
        'template'       => 'page.twig',
        'list_template'  => 'contact-list.twig',
        'order_by'       => 'updated_at DESC',
        'fields' => [
            'title'      => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'       => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'summary'    => ['type' => 'textarea', 'label' => 'Summary'],
            'body'       => ['type' => 'markdown', 'label' => 'Body'],
            'lead_image' => ['type' => 'text', 'label' => 'Lead image', 'help' => 'Root-relative path from Media.'],
        ],
    ],

    // Crawlable route for the themed static 404 page.
    'errorpage' => [
        'label'          => '404 Page',
        'label_singular' => '404 Page',
        'icon'           => 'file',
        'route'          => '/404/{slug}',
        'template'       => 'page.twig',
        'list_template'  => '404.twig',
        'order_by'       => 'updated_at DESC',
        'fields' => [
            'title' => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'  => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
        ],
    ],
];
