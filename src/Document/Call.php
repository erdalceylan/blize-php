<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;

#[MongoDB\Document(collection: "call")]
class Call
{
    #[MongoDB\Id]
    #[Groups(["call"])]
    private ?string $id;

    #[MongoDB\Field(type: "int")]
    #[Groups(["call"])]
    private ?int $from;

    #[MongoDB\Field(type: "int")]
    #[Groups(["call"])]
    private ?int $to;

    #[MongoDB\Field(type: "date")]
    #[Groups(["call"])]
    private ?DateTimeInterface $date;

    #[MongoDB\Field(type: "bool")]
    #[Groups(["call"])]
    private ?bool $video;

    #[MongoDB\Field(type: "date", nullable: true)]
    #[Groups(["call"])]
    private ?DateTimeInterface $startDate;

    #[MongoDB\Field(type: "date", nullable: true)]
    #[Groups(["call"])]
    private ?DateTimeInterface $endDate;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFrom(): ?int
    {
        return $this->from;
    }

    public function setFrom(int $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getTo(): int
    {
        return $this->to;
    }

    public function setTo(int $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function isVideo(): bool
    {
        return $this->video;
    }

    public function setVideo(bool $video): self
    {
        $this->video = $video;
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
