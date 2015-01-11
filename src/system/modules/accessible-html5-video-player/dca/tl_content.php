<?php
	
/**
 * Accessible HTML5 Video Player for Contao Open Source CMS
 *
 * @copyright wangaz. GbR 2015
 * @author Wangaz. GbR <hallo@wangaz.com>
 * @link https://wangaz.com
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
 

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['avp'] = '{type_legend},type,headline;{source_legend},videoSRC;{poster_legend:hide},previewSRC;{caption_legend},captionSRC;{player_legend},playerSize;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';


/*
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_content']['fields'], 0, array(
	'videoSRC' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_content']['videoSRC'],
		'exclude'                 => true,
		'inputType'               => 'fileTree',
		'eval'                    => array('multiple' => true, 'fieldType' => 'checkbox', 'files' => true, 'mandatory' => true),
		'sql'                     => "blob NULL"
	),
	'previewSRC' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_content']['posterSRC'],
		'exclude'                 => true,
		'inputType'               => 'fileTree',
		'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory' => true),
		'sql'                     => "binary(16) NULL"	
	),
	'captionSRC' => array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_content']['captionSRC'],
		'exclude'                 => true,
		'inputType'               => 'fileTree',
		'eval'                    => array('filesOnly' => true, 'fieldType' => 'radio'),
		'sql'                     => "binary(16) NULL"
	),
));
