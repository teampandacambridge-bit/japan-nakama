<?php
// This file is generated. Do not modify it manually.
return array(
	'advert-horizontal' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/advert-horizontal',
		'version' => '0.1.0',
		'title' => 'Advert (Horizonta)',
		'category' => 'widgets',
		'icon' => 'location',
		'description' => 'Horizontal advert',
		'example' => array(
			
		),
		'attributes' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'advert-horizontal',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'attraction-overview' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/attraction-overview',
		'version' => '0.1.0',
		'title' => 'Attraction Overview',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays an overview for tourist attractions.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Overview'
			),
			'cost' => array(
				'type' => 'string',
				'default' => 'cost'
			),
			'address' => array(
				'type' => 'string',
				'default' => 'address'
			),
			'hours' => array(
				'type' => 'string',
				'default' => 'open hours'
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					array(
						'heading' => '',
						'description' => ''
					)
				),
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'heading' => array(
							'type' => 'string'
						),
						'description' => array(
							'type' => 'string'
						)
					)
				)
			),
			'bulletHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'bullets' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'cta' => array(
				'type' => 'object',
				'default' => array(
					'text' => '',
					'url' => ''
				),
				'properties' => array(
					'text' => array(
						'type' => 'string',
						'default' => ''
					),
					'url' => array(
						'type' => 'string',
						'default' => ''
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'attraction-overview',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'card-full-width' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/card-full-width',
		'version' => '0.1.0',
		'title' => 'Card Full Width',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays a full width card with background image and CTA.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'subHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'cta' => array(
				'type' => 'object',
				'default' => array(
					'text' => '',
					'url' => ''
				),
				'properties' => array(
					'text' => array(
						'type' => 'string',
						'default' => ''
					),
					'url' => array(
						'type' => 'string',
						'default' => ''
					)
				)
			),
			'imageUrl' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'full-width-card',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'card-slider-six' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/card-slider-six',
		'version' => '0.1.0',
		'title' => 'Card Slider Six',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays Six Card Slider.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'subHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'selectedCategory' => array(
				'type' => 'string',
				'default' => ''
			),
			'selectedTags' => array(
				'type' => 'array',
				'items' => array(
					'type' => 'number'
				),
				'default' => array(
					
				)
			),
			'selectedPosts' => array(
				'type' => 'array',
				'items' => array(
					'type' => 'number'
				),
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'card-slider-six',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'card-slider-three' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/card-slider-three',
		'version' => '0.1.0',
		'title' => 'Card Slider Three',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays Three Card Slider.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'subHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'selectedCategory' => array(
				'type' => 'string',
				'default' => ''
			),
			'selectedTags' => array(
				'type' => 'array',
				'items' => array(
					'type' => 'number'
				),
				'default' => array(
					
				)
			),
			'selectedPosts' => array(
				'type' => 'array',
				'items' => array(
					'type' => 'number'
				),
				'default' => array(
					
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'card-slider-three',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'card-two-solid-box' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/card-two-solid-box',
		'version' => '0.1.0',
		'title' => 'Card Two Solid Box',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays two cards with solid background colours, optional image, heading, text and CTA.',
		'example' => array(
			
		),
		'attributes' => array(
			'boxLeft' => array(
				'type' => 'object',
				'default' => array(
					'image' => '',
					'heading' => '',
					'text' => '',
					'cta' => array(
						'text' => '',
						'url' => ''
					)
				),
				'properties' => array(
					'image' => array(
						'type' => 'string',
						'default' => ''
					),
					'heading' => array(
						'type' => 'string',
						'default' => ''
					),
					'text' => array(
						'type' => 'string',
						'default' => ''
					),
					'cta' => array(
						'type' => 'object',
						'default' => array(
							'text' => '',
							'url' => ''
						),
						'properties' => array(
							'text' => array(
								'type' => 'string',
								'default' => ''
							),
							'url' => array(
								'type' => 'string',
								'default' => ''
							)
						)
					)
				)
			),
			'boxRight' => array(
				'type' => 'object',
				'default' => array(
					'image' => '',
					'heading' => '',
					'text' => '',
					'cta' => array(
						'text' => '',
						'url' => ''
					)
				),
				'properties' => array(
					'image' => array(
						'type' => 'string',
						'default' => ''
					),
					'heading' => array(
						'type' => 'string',
						'default' => ''
					),
					'text' => array(
						'type' => 'string',
						'default' => ''
					),
					'cta' => array(
						'type' => 'object',
						'default' => array(
							'text' => '',
							'url' => ''
						),
						'properties' => array(
							'text' => array(
								'type' => 'string',
								'default' => ''
							),
							'url' => array(
								'type' => 'string',
								'default' => ''
							)
						)
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'card-two-solid-box',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'event-overview' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/event-overview',
		'version' => '0.1.0',
		'title' => 'Event Overview',
		'category' => 'widgets',
		'icon' => 'tickets-alt',
		'description' => 'Displays an overview for events.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'cost' => array(
				'type' => 'string',
				'default' => ''
			),
			'isHeroMain' => array(
				'type' => 'boolean',
				'default' => false
			),
			'isSidebarFeatured' => array(
				'type' => 'boolean',
				'default' => false
			),
			'isFree' => array(
				'type' => 'boolean',
				'default' => false
			),
			'isSponsored' => array(
				'type' => 'boolean',
				'default' => false
			),
			'eventStatus' => array(
				'type' => 'string',
				'default' => ''
			),
			'eventVenue' => array(
				'type' => 'string',
				'default' => ''
			),
			'address' => array(
				'type' => 'string',
				'default' => ''
			),
			'startDate' => array(
				'type' => 'object',
				'default' => array(
					'date' => '',
					'time' => ''
				),
				'properties' => array(
					'date' => array(
						'type' => 'string',
						'format' => 'date',
						'default' => ''
					),
					'time' => array(
						'type' => 'string',
						'format' => 'time',
						'default' => ''
					)
				)
			),
			'endDate' => array(
				'type' => 'object',
				'default' => array(
					'date' => '',
					'time' => ''
				),
				'properties' => array(
					'date' => array(
						'type' => 'string',
						'format' => 'date',
						'default' => ''
					),
					'time' => array(
						'type' => 'string',
						'format' => 'time',
						'default' => ''
					)
				)
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					array(
						'heading' => '',
						'description' => ''
					)
				),
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'heading' => array(
							'type' => 'string'
						),
						'description' => array(
							'type' => 'string'
						)
					)
				)
			),
			'bulletHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'bullets' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'cta' => array(
				'type' => 'object',
				'default' => array(
					'text' => '',
					'url' => ''
				),
				'properties' => array(
					'text' => array(
						'type' => 'string',
						'default' => ''
					),
					'url' => array(
						'type' => 'string',
						'default' => ''
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'event-overview',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'faq' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/faq',
		'version' => '0.1.0',
		'title' => 'faq',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays a faq section.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'subHeading' => array(
				'type' => 'string',
				'default' => ''
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					
				),
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'question' => array(
							'type' => 'string',
							'default' => ''
						),
						'answer' => array(
							'type' => 'string',
							'default' => ''
						)
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'full-width-card',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'google-map' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/google-map',
		'version' => '0.1.0',
		'title' => 'Google Mao',
		'category' => 'widgets',
		'icon' => 'location',
		'description' => 'Google Map',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Overview'
			),
			'map' => array(
				'type' => 'string',
				'default' => ''
			),
			'addressEnglish' => array(
				'type' => 'string',
				'default' => ''
			),
			'addressJapanese' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'google-map',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'header-large-hero-text' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/heading-large-hero-text',
		'version' => '0.1.0',
		'title' => 'Heading With Large Hero & Text',
		'category' => 'widgets',
		'icon' => 'star-filled',
		'description' => 'Displays a hero with full width hero image and text.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading_1' => array(
				'type' => 'string',
				'default' => ''
			),
			'heading_2' => array(
				'type' => 'string',
				'default' => ''
			),
			'subHeading' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'heading-large-hero-text',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'interview-overview' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/interview-overview',
		'version' => '0.1.0',
		'title' => 'Interview Overview',
		'category' => 'widgets',
		'icon' => 'admin-users',
		'description' => 'Outputs structured data for interviews (Schema.org Interview).',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => ''
			),
			'description' => array(
				'type' => 'string',
				'default' => ''
			),
			'interviewee' => array(
				'type' => 'string',
				'default' => ''
			),
			'jobTitle' => array(
				'type' => 'string',
				'default' => ''
			),
			'organization' => array(
				'type' => 'string',
				'default' => ''
			),
			'interviewer' => array(
				'type' => 'string',
				'default' => ''
			),
			'datePublished' => array(
				'type' => 'string',
				'default' => ''
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'interview-overview',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js'
	),
	'review-product-overview' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/product-review',
		'version' => '0.1.0',
		'title' => 'Product Review',
		'category' => 'widgets',
		'icon' => 'cart',
		'description' => 'Displays a product review with key info, rating, and highlights.',
		'example' => array(
			
		),
		'attributes' => array(
			'heading' => array(
				'type' => 'string',
				'default' => 'Product Review'
			),
			'manufacturer' => array(
				'type' => 'string',
				'default' => 'Manufacturer name'
			),
			'price' => array(
				'type' => 'string',
				'default' => 'Price'
			),
			'rating' => array(
				'type' => 'number',
				'default' => 5
			),
			'items' => array(
				'type' => 'array',
				'default' => array(
					array(
						'heading' => '',
						'description' => ''
					)
				),
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'heading' => array(
							'type' => 'string'
						),
						'description' => array(
							'type' => 'string'
						)
					)
				)
			),
			'bulletHeading' => array(
				'type' => 'string',
				'default' => 'Pros'
			),
			'bullets' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'consHeading' => array(
				'type' => 'string',
				'default' => 'Cons'
			),
			'cons' => array(
				'type' => 'array',
				'default' => array(
					
				)
			),
			'cta' => array(
				'type' => 'object',
				'default' => array(
					'text' => '',
					'url' => ''
				),
				'properties' => array(
					'text' => array(
						'type' => 'string',
						'default' => ''
					),
					'url' => array(
						'type' => 'string',
						'default' => ''
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'product-review',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'table-of-contents' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'japannakama/table-of-contents',
		'version' => '0.1.0',
		'title' => 'Table of Contents',
		'category' => 'widgets',
		'icon' => 'list-view',
		'description' => 'Displays a table of contents based on page headings.',
		'textdomain' => 'table-of-contents',
		'attributes' => array(
			'title' => array(
				'type' => 'string',
				'default' => 'Table of Contents'
			),
			'headings' => array(
				'type' => 'array',
				'default' => array(
					
				),
				'items' => array(
					'type' => 'object',
					'properties' => array(
						'id' => array(
							'type' => 'string'
						),
						'text' => array(
							'type' => 'string'
						),
						'level' => array(
							'type' => 'number'
						),
						'children' => array(
							'type' => 'array',
							'items' => array(
								'type' => 'object',
								'properties' => array(
									'id' => array(
										'type' => 'string'
									),
									'text' => array(
										'type' => 'string'
									),
									'level' => array(
										'type' => 'number'
									)
								)
							)
						)
					)
				)
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	)
);
