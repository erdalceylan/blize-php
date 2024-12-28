<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;

#[MongoDB\Document(collection: "story")]
class Story
{
    #[MongoDB\Id]
    #[Groups(["story"])]
    private string $id; // Nullable değil

    #[MongoDB\Field(type: "int")]
    #[Groups(["story"])]
    private int $from; // Nullable değil

    #[MongoDB\Field(type: "string")]
    #[Groups(["story"])]
    private string $rootPath; // Nullable değil

    #[MongoDB\Field(type: "string")]
    #[Groups(["story"])]
    private string $path; // Nullable değil

    #[MongoDB\Field(type: "string")]
    #[Groups(["story"])]
    private string $fileName; // Nullable değil

    #[MongoDB\Field(type: "date")]
    #[Groups(["story"])]
    private DateTimeInterface $date; // Nullable değil

    #[MongoDB\Field(type: "date", nullable: true)]
    #[Groups(["story"])]
    private ?DateTimeInterface $startDate; // Sizin eklediğiniz nullable

    #[MongoDB\Field(type: "date", nullable: true)]
    #[Groups(["story"])]
    private ?DateTimeInterface $endDate;   // Sizin eklediğiniz nullable


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

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}