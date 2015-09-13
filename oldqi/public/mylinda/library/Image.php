<?php

class Image {
	
	public static function isImage($img) {
		if(!$img || !is_readable($img)) return false;
		if (getimagesize($img) == FALSE) return false;
		return true;
	}
	
	public static function make($img, $filename, $image_path, $width = null, $height = null) {
		if ($width == null) $limitWidth = 640;
		else $limitWidth = $width;
		if ($height == null) $limitHeight = 390;
		else $limitHeight = $height;
		
		if (!is_dir($image_path)) mkdir($image_path, 0777, true);
		$image = imagecreatefromstring(file_get_contents($img));
		
		if ($image == FALSE) return false;
		
		self::fixOrientation($image, $img);
		
		imagejpeg($image, $image_path . $filename, 100);
		
		$new_image_src = self::crop($image_path . $filename, $limitWidth, $limitHeight);
		
		imagejpeg($new_image_src, $image_path . $filename, 100);
		
		imagedestroy($image);
		imagedestroy($new_image_src);
		
		return $image;
	}
	
	public static function save($img, $filename, $image_path) {
	
		if (!is_dir($image_path)) mkdir($image_path, 0777, true);
		$image = imagecreatefromstring(file_get_contents($img));
	
		if ($image == FALSE) return false;
		
		self::fixOrientation($image, $img);
	
		imagejpeg($image, $image_path . $filename, 100);
		
		imagedestroy($image);
	
		return $image;
	}
			
	public static function resize($filename, $target, $width, $height) {
	    list($orig_width, $orig_height) = getimagesize($filename);
	    		
	    $image_p = imagecreatetruecolor($width, $height);
	    $image = imagecreatefromstring(file_get_contents($filename));
	
	    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
	}
	
	public static function fixOrientation(&$image, $filename) {
	    $exif = @exif_read_data($filename);
	
	    if (!empty($exif['Orientation'])) {
	        switch ($exif['Orientation']) {
	            case 3: $image = imagerotate($image, 180, 0); break;	
	            case 6: $image = imagerotate($image, -90, 0); break;
	            case 8: $image = imagerotate($image, 90, 0); break;
	        }
	    }
	    return $image;
	}
	
	public static function resizeImage($filename, $targetWidth, $targetHeight) {
		list($originalWidth, $originalHeight) = getimagesize($filename);
		
		$originalImage = imagecreatefromstring(file_get_contents($filename));
		
		$ratio = $originalWidth / $originalHeight;
		if ($ratio < 1) $targetWidth = $targetHeight * $ratio;
		else $targetHeight = $targetWidth / $ratio;
			    
	    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
		imagecopyresampled($targetImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $originalWidth, $originalHeight);
		
		imagedestroy($originalImage);
	    
	    return $targetImage;
	}
	
	public static function crop($filename, $thumb_width, $thumb_height) {
		
		list($width, $height) = getimagesize($filename);
		
		if ($width == null) return false;
		
		$image = imagecreatefromstring(file_get_contents($filename));
		
		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;
		
		if ( $original_aspect >= $thumb_aspect ) {
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		} else {
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}
		
		$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
		imagecopyresampled($thumb, $image, 0 - ($new_width - $thumb_width) / 2, 0 - ($new_height - $thumb_height) / 2, 0, 0, $new_width, $new_height, $width, $height);
		imagedestroy($image);
		
		return $thumb;
					
	}
	
}
?>
