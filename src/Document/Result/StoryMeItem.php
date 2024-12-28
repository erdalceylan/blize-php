<?php

namespace App\Document\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;

#[MongoDB\QueryResultDocument]
class StoryMeItem
{
    #[MongoDB\Id]
    #[Groups(["story"])]
    private string $id;

    #[MongoDB\Field(type: "int")]
    #[Groups(["story"])]
    private int $from;

    #[MongoDB\Field(type: "string")]
    #[Groups(["story"])]
    private string $rootPath;

    #[MongoDB\Field(type: "string")]
    #[Groups(["story"])]
    private string $path;

    #[MongoDB\Field(type: "string")]
    #[Groups(["story"])]
    private string $fileName;

    #[MongoDB\Field(type: "date")]
    #[Groups(["story"])]
    private DateTimeInterface $date;

    #[MongoDB\EmbedMany(targetDocument: StoryViewItem::class)]
    #[Groups(["story"])]
    private ArrayCollection $views;

    #[MongoDB\Field(type: "int")]
    #[Groups(["story"])]
    private int $viewsLength;

    public function __construct()
    {
        $this->views = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFrom(): int
    {
        return $this->from;
    }

    public function setFrom(int $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function setRootPath(string $rootPath): self
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getViews(): ArrayCollection
    {
        return $this->views;
    }

    public function setViews(array $views): self
    {
        $this->views = new ArrayCollection($views);
        return $this;
    }

    public function getViewsLength(): int
    {
        return $this->viewsLength;
    }

    public function setViewsLength(int $viewsLength): self
    {
        $this->viewsLength = $viewsLength;
        return $this;
    }
}