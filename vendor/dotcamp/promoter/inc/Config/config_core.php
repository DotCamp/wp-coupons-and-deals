<?php
/**
 * Core configuration.
 *
 * @package DotCamp\Promoter
 */

$config_core = array(
	'frontend' => array(
		'editor_script' => array(
			'handle' => 'dotcamp-promoter-editor_main',
			'path'   => 'dist/dotcampPromoter.build.js',
			'deps'   => 'dist/dotcampPromoter.build.asset.php',
		),
		'editor_styles' => array(
			'handle' => 'dotcamp-promoter-editor_main_styles',
			'path'   => 'dist/dotcampPromoter.css',
		),
	),
	'ajax'     => array(
		'promotion_black_list' => array(
			'action'    => 'dotcamp_promoter_promotion_blacklist',
			'option_id' => 'dotcamp_promoter_promotion_blacklist',
		),
		'promotion_install'    => array(
			'action' => 'dotcamp_promoter_promotion_install',
		),
	),
);

return $config_core;
