<?php

add_action('acf/init', 'starterkit_init_block_types');
function starterkit_init_block_types()
{

	// Check function exists.
	if (function_exists('acf_register_block_type')) {

		// registers hero one block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-one',
			'title'				=> __('Hero Section One'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Background Image).png',
					)
				)
			),
		));

		// registers hero two block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-two',
			'title'				=> __('Hero Section Two'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Half Image Half Content).png',
					)
				)
			),
		));

		// registers hero three block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-three',
			'title'				=> __('Hero Section Three'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Half Image Half Content Full Width).png',
					)
				)
			),
		));

		// registers hero four block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-four',
			'title'				=> __('Hero Section Four'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Video Popup).png',
					)
				)
			),
		));

		// registers hero five block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-five',
			'title'				=> __('Hero Section Five'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Newsletter).png',
					)
				)
			),
		));

		// registers hero Six block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-six',
			'title'				=> __('Hero Section Six'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Newsletter)-2.png',
					)
				)
			),
		));

		// registers hero seven block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-seven',
			'title'				=> __('Hero Section Seven'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Portrait Image).png',
					)
				)
			),
		));

		// registers hero eight block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-eight',
			'title'				=> __('Hero Section Eight'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Half Content Half Video Popup).png',
					)
				)
			),
		));

		// registers hero nine block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-hero-nine',
			'title'				=> __('Hero Section Nine'),
			'description'		=> __('A custom Hero section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Hero (Login Form).png',
					)
				)
			),
		));

		// registers Testimonial section One.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-one',
			'title'				=> __('Testimonial Section One'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (Single Slide).png',
					)
				)
			),
		));

		// registers Testimonial section Two.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-two',
			'title'				=> __('Testimonial Section Two'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (Single Slide Left Align).png',
					)
				)
			),
		));

		// registers Testimonial section Three.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-three',
			'title'				=> __('Testimonial Section Three'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (2 Column Grid Layout).png',
					)
				)
			),
		));

		// registers Testimonial section Four.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-four',
			'title'				=> __('Testimonial Section Four'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (Half Content Half Image).png',
					)
				)
			),
		));

		// registers Testimonial section Five.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-five',
			'title'				=> __('Testimonial Section Five'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (Slider with Thumb).png',
					)
				)
			),
		));

		// registers Testimonial section Six.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-Six',
			'title'				=> __('Testimonial Section Six'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (Half Content Half Testimonial).png',
					)
				)
			),
		));

		// registers Testimonial section Seven.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-testimonial-Seven',
			'title'				=> __('Testimonial Section Seven'),
			'description'		=> __('A custom Testimonial section block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'testimonial',
			'keywords'			=> array('content', 'testimonials'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Testimonials (Video Popup).png',
					)
				)
			),
		));

		// register a Content one block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-one',
			'title'				=> __('Content One to Four'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Half Content Half Image.png',
					)
				)
			),
		));

		// register a Content Five block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-five',
			'title'				=> __('Content Five & Six'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Half Content Half Image (Full Height).png',
					)
				)
			),
		));

		// register a Content Seven block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-seven',
			'title'				=> __('Content Seven'),
			'description'		=> __('A custom content with short description block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('Content with short description'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Intro Block.png',
					)
				)
			),
		));

		// register a Content Eight block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-eight',
			'title'				=> __('Content Eight'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('Content '),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Intro Block Secondary.png',
					)
				)
			),
		));

		// register a Content Nine block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-nine',
			'title'				=> __('Content Nine'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('Content '),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Content (2 Column Text Grid Layout).png',
					)
				)
			),
		));

		// register a Content Ten block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-ten',
			'title'				=> __('Content Ten'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('Content '),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Content (Image Grid).png',
					)
				)
			),
		));

		// register a Content Eleven block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-eleven',
			'title'				=> __('Content Eleven'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Content (3 Column Image Grid Layout).png',
					)
				)
			),
		));

		// register a Content Twelven block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-twelven',
			'title'				=> __('Content Twelven'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Counter Percentage.png',
					)
				)
			),
		));

		// register a Content Thirteen block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-thirteen',
			'title'				=> __('Content Thirteen'),
			'description'		=> __('A custom content block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Counter Number.png',
					)
				)
			),
		));

		// register a cta one.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-cta-one',
			'title'				=> __('Call To Action One '),
			'description'		=> __('A custom full cta  one block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('full width CTA', 'Call to action'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Call To Action.png',
					)
				)
			),
			// 'enqueue_style' => get_stylesheet_uri(),
		));
		// register a cta two.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-cta-two',
			'title'				=> __('Call To Action Two '),
			'description'		=> __('A custom full cta  Two block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('full width CTA', 'Call to action'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Call To Action (Newsletter).png',
					)
				)
			),
		));
		// register a cta three.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-cta-three',
			'title'				=> __('Call To Action Three '),
			'description'		=> __('A custom Call To Action Three block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('CTA', 'Call to action', 'cta with background'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Call To Action (Background).png',
					)
				)
			),
		));

		// register a cta four.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-cta-four',
			'title'				=> __('Call To Action Four '),
			'description'		=> __('A custom full cta  four block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('full width CTA', 'Call to action'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Call To Action (2 Column Grid).png',
					)
				)
			),
		));
		// register a cta five.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-cta-five',
			'title'				=> __('Call To Action Five '),
			'description'		=> __('A custom full Call To Action five  block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('full width CTA', 'Call to action'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Call To Action (Single Row).png',
					)
				)
			),
		));
		// register a cta six.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-cta-six',
			'title'				=> __('Call To Action Six '),
			'description'		=> __('A custom full Call To Action Six  block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('full width CTA', 'Call to action'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Call To Action (Image + Form).png',
					)
				)
			),
		));



		// Register a Prices Table One Block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-price-table-one',
			'title'				=> __('Price Table One'),
			'description'		=> __('A custom price table one block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'money-alt',
			'keywords'			=> array('price', 'price tables'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Price Table (3 Column).png',
					)
				)
			),
		));

		// Register a Prices Table Two Block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-price-table-two',
			'title'				=> __('Price Table Two'),
			'description'		=> __('A custom price table two block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'money-alt',
			'keywords'			=> array('price', 'price tables'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Price Table (4 Column).png',
					)
				)
			),
		));

		// Register a Prices Table Three Block.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-price-table-three',
			'title'				=> __('Price Table Three'),
			'description'		=> __('A custom price table three block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'money-alt',
			'keywords'			=> array('price', 'price tables'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Price Table (Half Content Half Table).png',
					)
				)
			),
		));

		// register a ecommerce-one.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-ecommerce-one',
			'title'				=> __('Ecommerce One'),
			'description'		=> __('A custom woocommerce product listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Ecommerce one', 'Woocommerce', 'Products', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Product Listing (3 Column Grid Layout).png',
					)
				)
			),
		));

		// register a ecommerce-two.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-ecommerce-two',
			'title'				=> __('Ecommerce Two'),
			'description'		=> __('A custom woocommerce product listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Ecommerce two', 'Woocommerce', 'Products', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Product Listing (4 + 2 Column Grid Layout).png',
					)
				)
			),
		));

		// register a ecommerce-three.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-ecommerce-three',
			'title'				=> __('Ecommerce Three'),
			'description'		=> __('A custom woocommerce product listing block with ajax filtering.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Ecommerce three', 'Woocommerce', 'Products', 'Listing', 'Ajax', 'Filtering'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Product Listing With Filter.png',
					)
				)
			),
		));

		// register a ecommerce-four.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-ecommerce-four',
			'title'				=> __('Ecommerce Four'),
			'description'		=> __('A custom woocommerce product listing block with filtering.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Ecommerce four', 'Woocommerce', 'Products', 'Listing', 'Filtering'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Product Listing With Filter.png',
					)
				)
			),
		));

		// register a Feature One to six.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-one-to-six',
			'title'				=> __('Feature One to Six'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature One', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Multiple Column Icon Text.png',
					)
				)
			),
		));

		// register a Feature Seven to Nine.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-seven-to-nine',
			'title'				=> __('Feature Seven to Nine'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature Seven', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Multiple Column Image Text.png',
					)
				)
			),
		));

		// register a Feature Ten to Eleven.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-ten-to-eleven',
			'title'				=> __('Feature Ten to Eleven'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature Ten', 'Feature eleven', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Multiple Column Counter Text.png',
					)
				)
			),
		));

		// register a Feature Twelve.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-twelven',
			'title'				=> __('Feature Twelven'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature Twelven', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Half Content Half Accordion.png',
					)
				)
			),
		));

		// register a Feature thirteen.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-thirteen',
			'title'				=> __('Feature Thirteen'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature thirteen', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Tabs.png',
					)
				)
			),
		));

		// register a Feature Fourteen.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-fourteen',
			'title'				=> __('Feature Fourteen'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature Ten', 'Feature eleven', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Four Column Icon Text.png',
					)
				)
			),
		));

		// register a Feature Fifteen.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-fifteen',
			'title'				=> __('Feature Fifteen'),
			'description'		=> __('A coustom feature listing block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature fifteen', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Brands Listing.png',
					)
				)
			),
		));

		// register a Feature Sixteen.
		acf_register_block_type(array(
			'name'				=> 'starter-kit-feature-sixteen',
			'title'				=> __('Feature Sixteen'),
			'description'		=> __('A coustom feature FAQ block.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature sisteen', 'FAQ'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Accordion.png',
					)
				)
			),
		));

		// register a custom block for Blog listing 1
		acf_register_block_type(array(
			'name'				=> 'starter-kit-blog-listing-one',
			'title'				=> __('Blog Listing 1'),
			'description'		=> __('A coustom blog post listing.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('blog'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Blog Listing (Featured Post + 3 Column Grid).png',
					)
				)
			),
		));

		// register a custom block for Blog listing 2
		acf_register_block_type(array(
			'name'				=> 'starter-kit-blog-listing-two',
			'title'				=> __('Blog Listing 2'),
			'description'		=> __('A coustom blog post listing.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('blog'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Blog Listing (3 Column Grid Layout).png',
					)
				)
			),
		));

		// register a custom block for Blog listing 3
		acf_register_block_type(array(
			'name'				=> 'starter-kit-blog-listing-three',
			'title'				=> __('Blog Listing 3'),
			'description'		=> __('A coustom blog post listing.'),
			'render_callback'	=> 'starterkit_block_render_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('blog'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => STARTERKIT_IMAGES_DIR . 'acf-block-preview/Blog Listing (Featured Post + 3 Row Grid).png',
					)
				)
			),
		));
	}
}
