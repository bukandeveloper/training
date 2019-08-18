<?php
namespace App\Libs;

class Util
{
    /**
     * Save image to the path after trimming.
     *
     * @param $imagePath
     * @param $trimming_w
     * @param $trimming_h
     * @return Exception|bool|\Exception
     * @throws RuntimeException
     */
    public static function image_create($imagePath, $trimming_w, $trimming_h)
    {
        // create background image
        $createImage = imagecreatetruecolor($trimming_w, $trimming_h);
        imagefill($createImage, 0, 0, 0xFFFFFF);

        $getImage = '';
        $imageInfo = getimagesize($imagePath);
        switch($imageInfo['mime']) {
            case 'image/jpeg':
                $getImage = imagecreatefromjpeg($imagePath);
                break;
            case 'image/gif':
                $getImage = imagecreatefromgif($imagePath);
                break;
            case 'image/png':
                $getImage = imagecreatefrompng($imagePath);
                break;
            default:
                throw new RuntimeException('対応していないファイル形式です。: ', $imageInfo['mime']);
        }

        if ($trimming_w >= $imageInfo[0] && $trimming_h >= $imageInfo[1]) {
            // get position
            $position_w = ($trimming_w - $imageInfo[0]) / 2;
            $position_h = ($trimming_h - $imageInfo[1]) / 2;

            // create image
            imagecopy($createImage, $getImage, $position_w, $position_h, 0, 0, $imageInfo[0], $imageInfo[1]);
        } else if ($trimming_w <= $imageInfo[0] && $trimming_h >= $imageInfo[1]) {
            // resize
            $size_w = $trimming_w;
            $size_h = ($trimming_w / $imageInfo[0]) * $imageInfo[1];
            $resizeImage = imagecreatetruecolor($size_w, $size_h);
            imagecopyresampled($resizeImage, $getImage, 0, 0, 0, 0, $size_w, $size_h, $imageInfo[0], $imageInfo[1]);

            // create image
            imagecopy($createImage, $resizeImage, 0, ($trimming_h - $size_h) / 2, 0, 0, $size_w, $size_h);
        } else if ($trimming_w >= $imageInfo[0] && $trimming_h <= $imageInfo[1]) {

            // resize
            $size_w = ($trimming_h / $imageInfo[1]) * $imageInfo[0];
            $size_h = $trimming_h;
            $resizeImage = imagecreatetruecolor($size_w, $size_h);
            imagecopyresampled($resizeImage, $getImage, 0, 0, 0, 0, $size_w, $size_h, $imageInfo[0], $imageInfo[1]);

            // create image
            imagecopy($createImage, $resizeImage, ($trimming_w - $size_w) / 2, 0, 0, 0, $size_w, $size_h);
        } else {

            // check size
            $ratio_w = $trimming_w / $imageInfo[0];
            $ratio_h = $trimming_h / $imageInfo[1];
            if ($ratio_w <= $ratio_h) {
                // resize
                $size_w = $trimming_w;
                $size_h = ($trimming_w / $imageInfo[0]) * $imageInfo[1];
                $resizeImage = imagecreatetruecolor($size_w, $size_h);
                imagecopyresampled($resizeImage, $getImage, 0, 0, 0, 0, $size_w, $size_h, $imageInfo[0], $imageInfo[1]);

                // create image
                imagecopy($createImage, $resizeImage, 0, ($trimming_h - $size_h) / 2, 0, 0, $size_w, $size_h);
            } else {
                // resize
                $size_w = ($trimming_h / $imageInfo[1]) * $imageInfo[0];
                $size_h = $trimming_h;
                $resizeImage = imagecreatetruecolor($size_w, $size_h);
                imagecopyresampled($resizeImage, $getImage, 0, 0, 0, 0, $size_w, $size_h, $imageInfo[0], $imageInfo[1]);

                // create image
                imagecopy($createImage, $resizeImage, ($trimming_w - $size_w) / 2, 0, 0, 0, $size_w, $size_h);
            }
        }

        // save image
        try {
            switch($imageInfo['mime']) {
                case 'image/jpeg':
                    imagepng($createImage, $imagePath);
                    break;
                case 'image/gif':
                    imagejpeg($createImage, $imagePath);
                    break;
                case 'image/png':
                    imagegif($createImage, $imagePath);
                    break;
            }

            // delete image on memory
            imagedestroy($createImage);

            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * getFileVersionByLastMod
     *
     * @param $filename
     * @return datetime
     */
    public static function getFileVersionByLastMod($filename) {
        if (file_exists($filename)) {
           $modDateTime = date("YmdHis", filemtime($filename));
           return 'v='.$modDateTime;
        }
    }
}
