<?php
/**
 * Default promotions.
 *
 * @package DotCamp\Promoter
 */

// Supply all keys for individual promotion data to avoid PHP notices, even if they are empty.
$default_promotions = array(
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Advanced Heading Block for WordPress lets you add beautiful headings with more customizations.',
		'blocks_to_use' => array(
			'core/heading',
		),
		'link_href'     => 'https://ultimateblocks.com/advanced-heading-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Styled List Block for WordPress lets you add beautiful styled lists to your WordPress Posts and Pages.',
		'blocks_to_use' => array(
			'core/list',
			'core/list-item',
		),
		'link_href'     => 'https://ultimateblocks.com/styled-list-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Image Slider Block for WordPress lets you add beautiful image sliders to your WordPress Posts/pages.',
		'blocks_to_use' => array(
			'core/image',
			'core/media-text',
			'core/gallery',
		),
		'link_href'     => 'https://ultimateblocks.com/image-slider-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Video Block is designed to enhance your web content presentation by displaying videos into web posts and pages.',
		'blocks_to_use' => array(
			'core/video',
		),
		'link_href'     => 'https://ultimateblocks.com/video-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Content Toggle (Accordion) Block for WordPress lets you add content in accordions. It can be used for FAQs, Collapsed/Expandable Content, and more.',
		'blocks_to_use' => array(
			'core/details',
		),
		'link_href'     => 'https://ultimateblocks.com/content-toggle-accordion-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Button (Improved) Block for WordPress lets you add beautiful buttons to your WordPress posts and pages. It comes with a lot of customization.',
		'blocks_to_use' => array(
			'core/button',
			'core/buttons',
		),
		'link_href'     => 'https://ultimateblocks.com/improved-button-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Ultimate Blocks',
		'plugin_id'     => 'ultimate-blocks/ultimate-blocks.php',
		'description'   => 'The Divider Block for WordPress lets you add dividers between blocks in WordPress with full of customizations and styles.',
		'blocks_to_use' => array(
			'core/separator',
			'core/nextpage',
		),
		'link_href'     => 'https://ultimateblocks.com/divider-block/',
		'link_label'    => 'Demo',
	),
	array(
		'plugin_name'   => 'Tableberg',
		'plugin_id'     => 'tableberg/tableberg.php',
		'description'   => 'Seamlessly craft stunning, fully customizable tables with tableberg.',
		'blocks_to_use' => array(
			'core/table',
		),
		'link_href'     => 'https://tableberg.com',
		'link_label'    => 'Learn More',
	),
);

return $default_promotions;
