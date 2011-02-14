<?php
/*
 * GD Watermark Lib Plugin Definition File
 *
 * This file contains the plugin definition for the GD Watermark Lib for PHP Thumb
 *
 * PHP Version 5 with GD 2.0+
 * PhpThumb : PHP Thumb Library <http://phpthumb.gxdlabs.com>
 * Copyright (c) 2009, Ian Selby/Gen X Design
 *
 * Author(s): Cleber Willian dos Santos <e@binho.net>
 *
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author Cleber Willian dos Santos <e@binho.net>
 * @copyright Copyright (c) 2009 Gen X Design
 * @link http://phpthumb.gxdlabs.com
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 3.0
 * @package PhpThumb
 * @filesource
 */

/*
 * GD Watermark Lib Plugin
 *
 * This plugin allows you to create watermark on your photos
 *
 * @package PhpThumb
 * @subpackage Plugins
 */
class GdWatermarkLib
{
	/*
	 * Instance of GdThumb passed to this class
	 * @var GdThumb
	 */
	protected $parentInstance;
	protected $currentDimensions;
	protected $workingImage;
	protected $newImage;
	protected $options;
	protected $originPath;

	/*
	 * Create a watermark on working image, where $image_path is the watermark image file
	 * @param string $image_path
	 * @param int $right_margin
	 * @param int $bottom_margin
	 * @return object
	 */
	public function createWatermark($image_path, $right_margin, $bottom_margin, &$that)
	{
		$this->parentInstance    = $that;
		$this->currentDimensions = $this->parentInstance->getCurrentDimensions();
		$this->workingImage		 = $this->parentInstance->getWorkingImage();
		$this->newImage			 = $this->parentInstance->getOldImage();
		$this->options			 = $this->parentInstance->getOptions();
		$this->originPath        = $this->parentInstance->getFileName();

		// load image used as watermark
		$stamp = imagecreatefrompng( $image_path );

		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		imagecopy($this->workingImage,
				  $stamp,
				  imagesx($this->workingImage) - $sx - $right_margin,
				  imagesy($this->workingImage) - $sy - $bottom_margin,
				  0,
				  0,
				  imagesx($stamp),
				  imagesy($stamp));

		$this->parentInstance->setOldImage( $this->workingImage );

		return $that;
	}
}

$pt = PhpThumb::getInstance();
$pt->registerPlugin('GdWatermarkLib', 'gd');