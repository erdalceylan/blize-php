<?php

namespace App\Service;

use \Imagick;
use \ImagickException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

class ImageUploadService
{
    const CROP_64 = 64;
    const CROP_128 = 128;
    const CROP_256 = 256;
    const CROP_512 = 512;
    const CROP_1024 = 1024;

    private TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator
    )
    {
        $this->translator = $translator;
    }

    /**
     * @throws ImagickException
     */
    public function load(string $from): Imagick
    {
        return new Imagick($from);
    }

    /**
     * @throws ImagickException
     */
    public function cropFlatRatio(Imagick $imagick, int $type = self::CROP_64): self
    {
        $this->checkSize($imagick, $type, $type);
        $imagick->cropThumbnailImage($type, $type);

        return $this;
    }

    /**
     * @param Imagick $imagick
     * @param float|int $ratio
     * @return static
     * @throws ImagickException
     */
    public function cropRatio(Imagick $imagick, $ratio = 16/9): self
    {
        $imageWidth = $imagick->getImageWidth();
        $imageHeight = $imagick->getImageHeight();

        $w = $imageHeight*$ratio;
        $h = $imageHeight;

        if ($w > $imageWidth) {
            $diff = $imageWidth / $w;
            $w  = $w * $diff;
            $h = $h * $diff;
        }

        $imagick->cropThumbnailImage($w, $h);

        return $this;
    }

    /**
     * @throws ImagickException
     */
    public function resizeMin(\Imagick $imagick, int $width, int $height): self
    {
        $imageWidth = $imagick->getImageWidth();
        $imageHeight = $imagick->getImageHeight();

        if ($imageWidth > $width || $imageHeight > $height) {

            $w = $width;
            $h = $height;

            if ($imageWidth > $imageHeight) {
                $w = 0;
            } else {
                $h = 0;
            }

            $imagick->scaleImage($w, $h);
        }

        return $this;
    }

    /**
     * @throws ImagickException
     */
    public function checkSize(\Imagick $imagick, int $width, int $height): self
    {
        if ($imagick->getImageWidth() < $width) {
            throw new BadRequestHttpException($this->translator->trans("IMAGE_SMALL_SIZE_ERROR",['size'=> $width."px"]));
        }

        if ($imagick->getImageHeight() < $height) {
            throw new BadRequestHttpException($this->translator->trans("IMAGE_SMALL_SIZE_ERROR",['size'=> $height."px"]));
        }

        return $this;
    }

    private function createDir($path)
    {

        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                throw new BadRequestHttpException("DIRECTORY_PERMISSION_ERROR");
            }
        }
    }

    /**
     * @throws ImagickException
     */
    public function save(Imagick $imagick, $to = null): bool
    {
        $pathInfo = pathinfo($to);
        $this->createDir($pathInfo['dirname']);
        return $imagick->writeImage($to);
    }

}
