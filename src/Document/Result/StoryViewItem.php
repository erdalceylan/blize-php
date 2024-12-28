<?php

namespace App\Document\Result;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeInterface;

#[MongoDB\QueryResultDocument]
class StoryViewItem
{
    #[MongoDB\Field(type: "int")]
    #[Groups(["story"])]
    private int $from;

    #[MongoDB\Field(type: "date")]
    #[Groups(["story"])]
    private DateTimeInterface $date;

    public function getFrom(): int
    {
        return $this->from;
    }

    public function setFrom(int $from): self
    {
        $this->from = $from;
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

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}