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

    /**
     * @return string|null
     */
    public function getRootPath(): ?string
    {
        return $this->rootPath;
    }

    /**
     * @param string|null $rootPath
     * @return Uploaded
     */
    public function setRootPath(?string $rootPath): Uploaded
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string|null $filePath
     * @return Uploaded
     */
    public function setFilePath(?string $filePath): Uploaded
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     * @return Uploaded
     */
    public function setFileName(?string $fileName): Uploaded
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return \Imagick|null
     */
    public function getImagick(): ?\Imagick
    {
        return $this->imagick;
    }

    /**
     * @param \Imagick|null $imagick
     * @return Uploaded
     */
    public function setImagick(?\Imagick $imagick): Uploaded
    {
        $this->imagick = $imagick;
        return $this;
    }

}
