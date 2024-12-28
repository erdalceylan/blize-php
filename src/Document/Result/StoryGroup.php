<?php

namespace App\Document\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

#[MongoDB\QueryResultDocument]
class StoryGroup
{
    #[MongoDB\Field(type: "int")]
    #[Groups(["story"])]
    private int $from;

    #[MongoDB\EmbedMany(targetDocument: StoryGroupItem::class)]
    #[Groups(["story"])]
    private ArrayCollection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    public function setItems(ArrayCollection $items): self
    {
        $this->items = $items;
        return $this;
    }
}