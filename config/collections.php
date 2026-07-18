<?php

/**
 * Public content for Sara Bonella's academic site.
 *
 * The three small page collections below give the static exporter durable
 * list routes (/leadership, /outreach, /contact) without seeding database
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
            'lead_image'       => ['type' => 'url', 'label' => 'Lead image', 'help' => 'Root-relative URL from /admin/media.'],
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
            'lead_image'    => ['type' => 'url', 'label' => 'Lead image', 'help' => 'Root-relative URL from /admin/media.'],
            'category'      => ['type' => 'select', 'label' => 'Category', 'options' => ['Statistical physics', 'Quantum dynamics', 'Molecular simulation', 'HPC & infrastructure', 'Scientific leadership']],
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
            'category' => ['type' => 'select', 'label' => 'Category', 'options' => ['Statistical physics', 'Quantum dynamics', 'Molecular simulation', 'HPC & infrastructure', 'Scientific leadership']],
            'featured' => ['type' => 'boolean', 'label' => 'Featured'],
        ],
    ],

    'leadership_pages' => [
        'label'          => 'Leadership page',
        'label_singular' => 'Leadership page note',
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
            'lead_image' => ['type' => 'url', 'label' => 'Lead image'],
        ],
    ],

    'outreach_pages' => [
        'label'          => 'Outreach page',
        'label_singular' => 'Outreach page note',
        'icon'           => 'file',
        'route'          => '/outreach/{slug}',
        'template'       => 'page.twig',
        'list_template'  => 'outreach-list.twig',
        'order_by'       => 'updated_at DESC',
        'fields' => [
            'title'      => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'       => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'summary'    => ['type' => 'textarea', 'label' => 'Summary'],
            'body'       => ['type' => 'markdown', 'label' => 'Body'],
            'lead_image' => ['type' => 'url', 'label' => 'Lead image'],
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
            'lead_image' => ['type' => 'url', 'label' => 'Lead image'],
        ],
    ],

    // Retained for future editorial work, but intentionally has no public
    // route until Sara chooses to publish news.
    'posts' => [
        'label'          => 'Posts',
        'label_singular' => 'Post',
        'icon'           => 'edit',
        'order_by'       => 'publish_at DESC',
        'fields' => [
            'title'   => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'    => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'excerpt' => ['type' => 'textarea', 'label' => 'Excerpt'],
            'body'    => ['type' => 'markdown', 'required' => true, 'label' => 'Body'],
            'author'  => ['type' => 'text', 'label' => 'Author'],
        ],
    ],

    // Pebblestack compatibility only. The public static site uses a mailto
    // route and never exposes this POST endpoint.
    'contact' => [
        'label'          => 'Contact',
        'label_singular' => 'Submission',
        'is_form'        => true,
        'fields' => [
            'name'    => ['type' => 'text', 'required' => true, 'label' => 'Name'],
            'email'   => ['type' => 'text', 'required' => true, 'label' => 'Email'],
            'message' => ['type' => 'textarea', 'required' => true, 'label' => 'Message'],
        ],
    ],
];
