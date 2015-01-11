<?php
	
/**
 * Accessible HTML5 Video Player for Contao Open Source CMS
 *
 * @copyright wangaz. GbR 2015
 * @author Wangaz. GbR <hallo@wangaz.com>
 * @license !TODO
 */


/*
 * Register the classes
 */
ClassLoader::addClasses(array('Contao\ContentAccessibleVideoPlayer' => 'system/modules/accessible-html5-video-player/elements/ContentAccessibleVideoPlayer.php'));


/*
 * Register the templates
 */
TemplateLoader::addFiles(array('ce_acessible_video_player' => 'system/modules/accessible-html5-video-player/templates'));
