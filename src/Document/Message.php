<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;

#[MongoDB\Document(collection: "message")]
class Message
{
    #[MongoDB\Id]
    #[Groups(["message"])]
    private ?string $id;

    #[MongoDB\Field(type: "int")]
    #[Groups(["message"])]
    private ?int $from;

    #[MongoDB\Field(type: "int")]
    #[Groups(["message"])]
    private ?int $to;

    #[MongoDB\Field(type: "string")]
    #[Groups(["message"])]
    private ?string $text;

    #[MongoDB\Field(type: "date")]
    #[Groups(["message"])]
    private ?DateTimeInterface $date;

    #[MongoDB\Field(type: "bool")]
    #[Groups(["message"])]
    private ?bool $read;

    public function getId(): ?string
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

    public function getTo(): int
    {
        return $this->to;
    }

    public function setTo(int $to): self
    {
        $this->to = $to;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
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

    public function isRead(): ?bool
    {
        return $this->read;
    }

    public function setRead(?bool $read): self
    {
        $this->read = $read;
        return $this;
    }
}
