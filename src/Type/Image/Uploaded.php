<?php

namespace App\Type\Image;

class Uploaded
{
    private ?string $rootPath;
    private ?string $filePath;
    private ?string $fileName;
    private ?\Imagick $imagick;

    public function __construct(
        ?string $rootPath = null,
        ?string $filePath = null,
        ?string $fileName = null,
        ?\Imagick $imagick = null
    )
    {
        $this
            ->setRootPath($rootPath)
            ->setFilePath($filePath)
            ->setFileName($fileName)
            ->setImagick($imagick);
    }

    public function getRootPath(): ?string
    {
        return $this->rootPath;
    }

    public function setRootPath(?string $rootPath): Uploaded
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): Uploaded
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): Uploaded
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getImagick(): ?\Imagick
    {
        return $this->imagick;
    }

    public function setImagick(?\Imagick $imagick): Uploaded
    {
        $this->imagick = $imagick;
        return $this;
    }

}
