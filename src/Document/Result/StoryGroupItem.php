<?php

namespace App\Document\Result;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;

#[MongoDB\QueryResultDocument]
class StoryGroupItem
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

    #[MongoDB\Field(type: "bool")]
    #[Groups(["story"])]
    private ?bool $seen; // Zaten nullable

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

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(?bool $seen): self
    {
        $this->seen = $seen;
        return $this;
    }
}