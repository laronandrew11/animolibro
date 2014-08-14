<?php 
include('authenticator.php');
  /* * File: SimpleImage.php * Author: Simon Jarvis * Copyright: 2006 Simon Jarvis * Date: 08/11/06 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php * * This program is free software; you can redistribute it and/or * modify it under the terms of the GNU General Public License * as published by the Free Software Foundation; either version 2 * of the License, or (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the * GNU General Public License for more details: * http://www.gnu.org/licenses/gpl.html * */   class SimpleImage {   var $image; var $image_type;   function load($filename) {   $image_info = getimagesize($filename); $this->image_type = $image_info[2]; if( $this->image_type == IMAGETYPE_JPEG ) {   $this->image = imagecreatefromjpeg($filename); } elseif( $this->image_type == IMAGETYPE_GIF ) {   $this->image = imagecreatefromgif($filename); } elseif( $this->image_type == IMAGETYPE_PNG ) {   $this->image = imagecreatefrompng($filename); } } function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {   if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($this->image,$filename,$compression); } elseif( $image_type == IMAGETYPE_GIF ) {   imagegif($this->image,$filename); } elseif( $image_type == IMAGETYPE_PNG ) {   imagepng($this->image,$filename); } if( $permissions != null) {   chmod($filename,$permissions); } } function output($image_type=IMAGETYPE_JPEG) {   if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($this->image); } elseif( $image_type == IMAGETYPE_GIF ) {   imagegif($this->image); } elseif( $image_type == IMAGETYPE_PNG ) {   imagepng($this->image); } } 
function thumbnail($width, $height = null) {

		// Determine height
		$height = $height ?: $width;

		// Determine aspect ratios
		$current_aspect_ratio = $this->height / $this->width;
		$new_aspect_ratio = $height / $width;

		// Fit to height/width
		if ($new_aspect_ratio > $current_aspect_ratio) {
			$this->resizeToHeight($height);
		} else {
			$this->resizeToWidth($width);
		}
		/*$left = floor(($this->width / 2) - ($width / 2));
		$top = floor(($this->height / 2) - ($height / 2));*/

		// Return trimmed image
		return $this/*->crop($left, $top, $width + $left, $height + $top)*/;

	}	
	function crop($x1, $y1, $x2, $y2) {

		// Determine crop size
		if ($x2 < $x1) {
			list($x1, $x2) = array($x2, $x1);
		}
		if ($y2 < $y1) {
			list($y1, $y2) = array($y2, $y1);
		}
		$crop_width = $x2 - $x1;
		$crop_height = $y2 - $y1;

		// Perform crop
		$new = imagecreatetruecolor($crop_width, $crop_height);
		imagealphablending($new, false);
		imagesavealpha($new, true);
		imagecopyresampled($new, $this->image, 0, 0, $x1, $y1, $crop_width, $crop_height, $crop_width, $crop_height);

		// Update meta data
		$this->width = $crop_width;
		$this->height = $crop_height;
		$this->image = $new;

		return $this;

	}
function getWidth() {   return imagesx($this->image); } function getHeight() {   return imagesy($this->image); } function resizeToHeight($height) {   $ratio = $height / $this->getHeight(); $width = $this->getWidth() * $ratio; $this->resize($width,$height); }   function resizeToWidth($width) { $ratio = $width / $this->getWidth(); $height = $this->getheight() * $ratio; $this->resize($width,$height); }   function scale($scale) { $width = $this->getWidth() * $scale/100; $height = $this->getheight() * $scale/100; $this->resize($width,$height); }   function resize($width,$height) { $new_image = imagecreatetruecolor($width, $height); imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight()); $this->image = $new_image; }   } ?> 