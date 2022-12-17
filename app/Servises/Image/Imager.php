<?php

namespace App\Servises\Image;

class Imager
{


    static function resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom)
    {
        //Коэффициент размытия, где значение >  1 делает изображение более размытым, а значение < 1 - более резким.
        $imagick = new \Imagick(realpath($imagePath));

        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);

        $cropWidth = $imagick->getImageWidth();
        $cropHeight = $imagick->getImageHeight();

        if ($cropZoom) {
            $newWidth = $cropWidth / 2;
            $newHeight = $cropHeight / 2;

            $imagick->cropimage(
                $newWidth,
                $newHeight,
                ($cropWidth - $newWidth) / 2,
                ($cropHeight - $newHeight) / 2
            );

            $imagick->scaleimage(
                $imagick->getImageWidth() * 4,
                $imagick->getImageHeight() * 4
            );
        }


        header("Content-Type: image/jpg");
        echo $imagick->getImageBlob();
    }

}
