<?php

class ContentAwareImage {

    protected static $start_time = 0.0;

    public static function start() {
        self::$start_time = microtime(true);
    }

    public static function mark() {
        $end_time = (microtime(true) - self::$start_time) * 1000;
        return sprintf("%.1fms" ,$end_time);
    }
    
    /**
     *
     * @param Imagick $image
     * @return int
     */
    protected function area(Imagick $image) {
        $size = $image->getImageGeometry();
        return $size['height'] * $size['width'];
    }

    /**
     * Calculate the entropy for this image
     *
     * @param Imagick $image
     * @param int $area - the amount of pixels for this image
     * @return float
     */
    protected function grayscaleEntropy(Imagick $image) {
        $area = $this->area($image);
        $histogram = $image->getImageHistogram();
        $value = 0.0;

        for($idx = 0; $idx < count($histogram); $idx++) {
            $p = $histogram[$idx]->getColorCount() / $area;
            $value = $value + $p * log($p, 2);
        }

        return -$value;
    }

    /**
     *
     * @param type $r
     * @param type $g
     * @param type $b
     * @return type
     */
    protected function colorEntropy(Imagick $image) {
        $area = $this->area($image);
        $histogram = $image->getImageHistogram();
        $value = 0.0;

        $newHistogram = array();

        for($idx = 0; $idx < count($histogram); $idx++) {
            $colors = $histogram[$idx]->getColor();
            $grey = (($colors['r']*0.299)+($colors['g']*0.587)+($colors['b']*0.114));
            
            if(!isset($result[$grey])) {
                $newHistogram[$grey] = $histogram[$idx]->getColorCount();
            } else {
                $newHistogram[$grey] += $histogram[$idx]->getColorCount();
            }
        }

        foreach($newHistogram as $colorCount) {
            $p = $colorCount / $area;
            $value = $value + $p * log($p, 2);
        }
        
        return -$value;
        
    }

    /**
     *
     * @param Imagick $image
     * @param int $targetHeight
     * @param int $targetHeight
     * @param int $sliceSize
     * @return array
     */
    protected function getAdaptiveOffset(Imagick $image, $targetWidth, $targetHeight) {
        $size = $image->getImageGeometry();
        $originalWidth = $scanWidth = $size['width'];
        $originalHeight = $scanHeight = $size['height'];
        $goalY = $goalX = 0;

        $sliceSize = ceil($this->area($image) / (1024 * 2));

        $firstImage = $otherImage = null;

        while($scanHeight-$goalY > $targetHeight) {
            $slizeSize = min(array($scanHeight - $goalY - $targetHeight, $sliceSize));
            if(!$firstImage) {
                $firstImage = clone($image);
                $firstImage->cropImage($originalWidth, $slizeSize, 0, $goalY);
            }
            if(!$otherImage) {
                $otherImage = clone($image);
                $otherImage->cropImage($originalWidth, $slizeSize, 0, $scanHeight - $slizeSize);
            }
            if($this->grayscaleEntropy($firstImage) < $this->grayscaleEntropy($otherImage)) {
                $goalY += $slizeSize; $firstImage = null;
            } else {
                $scanHeight -= $slizeSize; $otherImage = null;
            }
        }

        $firstImage = $otherImage = null;

        while($scanWidth-$goalX > $targetWidth) {
            $sliceSize = min(array(($scanWidth-$goalX-$targetWidth), $sliceSize));
            if(!$firstImage) {
                $firstImage = clone($image);
                $firstImage->cropImage($sliceSize, $originalHeight, $goalX, 0);
            }
            if(!$otherImage) {
                $otherImage = clone($image);
                $otherImage->cropImage($sliceSize, $originalHeight, $scanWidth - $sliceSize, 0);
            }
            // $firstImage has more entropy, so keep $otherImage
            if($this->grayscaleEntropy($firstImage) < $this->grayscaleEntropy($otherImage)) {
                $goalX += $sliceSize; $firstImage = null;
            } else {
                $scanWidth -= $sliceSize; $otherImage = null;
            }
        }

        return array('x' => $goalX, 'y' => $goalY);
    }

    /**
     *
     * @param Imagick $original
     * @param int $targetWidth
     * @param int $targetHeight
     * @return array
     */
    protected function getOffset(Imagick $original, $targetWidth, $targetHeight) {

        $image = clone($original);

        // Enhance edges within the image
        #$image->edgeimage($radius = 1);
        // Turn image into a grayscale
        #$image->modulateImage(100, 0, 100);
        // Force all pixels below this to be totally black
        #$image->blackThresholdImage("#0f0f0f");

            // Turn image into a grayscale
        $image->modulateImage(100, 0, 100);
        // Force all pixels below this to be totally black
        $image->modulateImage(100, 0, 100);
        #$image->blackThresholdImage("#000000");
        $image->whitethresholdimage("#9f9f9f");
        $image->edgeimage($radius = 1);

        #$original->modulateImage(100, 0, 100);
        
        #$original->blackThresholdImage("#5f5f5f");
        #$original->whitethresholdimage("#9f9f9f");
        #$original->contrastStretchImage(0,1);
        #$original->edgeimage($radius = 0.5);

        return $this->getAdaptiveOffset($image, $targetWidth, $targetHeight);
    }

    /**
     *
     * @param Imagick $image
     * @param int $targetWidth
     * @param int $targetHeight
     * @return array
     */
    protected function getMiddleOffset($image, $targetWidth, $targetHeight) {
        $size = $image->getImageGeometry();
        $originalWidth = $size['width'];
        $originalHeight = $size['height'];
        $goalX = (int)(($originalWidth-$targetWidth)/2);
        $goalY = (int)(($originalHeight-$targetHeight)/2);
        return array('x' => $goalX, 'y' => $goalY);
    }



    /**
     *
     * @param Imagick $image
     * @param int $targetWidth
     * @param int $targetHeight
     * @return array
     */
    protected function getOutsideCropSize(Imagick $image, $targetWidth, $targetHeight) {
        $source = $image->getImageGeometry();
        if(($source['width'] / $source['height']) < ($targetWidth / $targetHeight)) {
            $scale = $source['width'] / $targetWidth;
        } else {
            $scale = $source['height'] / $targetHeight;
        }
        return array('width' => (int) ($source['width'] / $scale), 'height' => (int) ($source['height'] / $scale));
    }

    /**
     *
     * @param string $raw
     * @param int $targetWidth
     * @param int $targetHeight
     * @return boolean|\Imagick
     */
    public function crop($raw, $targetWidth, $targetHeight) {
        try {
            $image = new Imagick();
            $image->readImageBlob($raw);
        } catch(ImagickException $e) {
            return false;
        }
        
        // First get the size that we can use to safely trim down the image to
        // without cropping any sides
        $crop = $this->getOutsideCropSize($image, $targetWidth, $targetHeight);
        $image->resizeImage($crop['width'], $crop['height'], Imagick::FILTER_CATROM, 0.5);

        // Get the offset for cropping the image further
        #$offset = $this->getOffset($image, $targetWidth, $targetHeight);
        $offset = $this->getMiddleOffset($image, $targetWidth, $targetHeight);
        $image->cropImage($targetWidth, $targetHeight, $offset['x'], $offset['y']);

        $image->setImageCompression(imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality(75);
        $image->stripImage();
        return $image;
    }
}