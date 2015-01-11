<?php
	
/**
 * Accessible HTML5 Video Player for Contao Open Source CMS
 *
 * @copyright wangaz. GbR 2015
 * @author Wangaz. GbR <hallo@wangaz.com>
 * @license !TODO
 */

 
namespace Contao;


/**
 * Class ContentAccessibleVideoPlayer
 *
 * @copyright wangaz. GbR 2015
 * @author Wangaz. GbR <hallo@wangaz.com>
 * @license !TODO
 */
class ContentAccessibleVideoPlayer extends \ContentElement 
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_acessible_video_player';


	/**
	 * Extend the parent method
	 * @return string
	 */
	public function generate() 
	{
		if ($this->videoSRC == '')
			return '';

		$source = deserialize($this->videoSRC);

		if (!is_array($source) || empty($source))
			return '';

		$objFiles = \FilesModel::findMultipleByUuidsAndExtensions($source, array('mp4','m4v','mov','wmv','webm','ogv'));

		if ($objFiles === null)
			return '';

		// display a list of files in the back end
		if (TL_MODE == 'BE') 
		{
			$return = '<ul>';

			while ($objFiles->next()) 
			{
				$objFile = new \File($objFiles->path, true);
				$return .= '<li><img src="' . TL_ASSETS_URL . 'assets/contao/images/' . $objFile->icon . '" width="18" height="18" alt="" class="mime_icon"> <span>' . $objFile->name . '</span> <span class="size">(' . $this->getReadableSize($objFile->size) . ')</span></li>';
			}

			return $return . '</ul>';
		}

		$this->objFiles = $objFiles;
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile() 
	{
		global $objPage;
		
		// add the scripts
		$GLOBALS['TL_CSS'][] = 'assets/accessible-html5-video-player/css/px-video.css|static';
		$GLOBALS['TL_JAVASCRIPT'][] = 'assets/accessible-html5-video-player/js/px-video.js|static';
		
		// set the size
		$this->Template->size = '';

		if ($this->playerSize != '')
		{
			$size = deserialize($this->playerSize);

			if (is_array($size))
				$this->Template->size = ' width="' . $size[0] . '" height="' . $size[1] . '"';
		}

		// optional preview
		$this->Template->preview = false;

		if ($this->previewSRC != '')
			if (($objFile = \FilesModel::findByUuid($this->previewSRC)) !== null)
				$this->Template->preview = $objFile->path;
		
		// optional caption
		$this->Template->caption = false;
		
		if ($this->captionSRC != '')
			if (($objFile = \FilesModel::findByUuid($this->captionSRC)) !== null)
				$this->Template->caption = $objFile->path;

		// pre-sort the array by preference
		$arrFiles = array('mp4' => null, 'm4v' => null, 'mov' => null, 'wmv' => null, 'webm' => null, 'ogv' => null);

		$this->objFiles->reset();

		// convert the language to a locale
		$strLanguage = str_replace('-', '_', $objPage->language);

		// pass File objects to the template
		while ($this->objFiles->next())
		{
			$arrMeta = deserialize($this->objFiles->meta);

			if (is_array($arrMeta) && isset($arrMeta[$strLanguage]))
				$strTitle = $arrMeta[$strLanguage]['title'];
			else
				$strTitle = $this->objFiles->name;

			$objFile = new \File($this->objFiles->path, true);
			$objFile->title = specialchars($strTitle);

			$arrFiles[$objFile->extension] = $objFile;
		}

		$this->Template->files = array_values(array_filter($arrFiles));
		$this->Template->autoplay = $this->autoplay;
		
		// labels
		$this->Template->lang = $GLOBALS['TL_LANGUAGE'];
		$this->Template->label = $GLOBALS['TL_LANG']['MSC']['avpCaption'];
		$this->Template->download = $GLOBALS['TL_LANG']['MSC']['avpDownload'];
	}
}