<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\QueryResultDocument()
 */
class MessageGroupItem
{
    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"message"})
     */
    protected $from;

    /**
     * @var int
     * @MongoDB\Field(type="integer")
     * @Groups({"message"})
     */
    protected $to;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     * @Groups({"message"})
     */
    private $text;

    /**
     * @var \DateTimeInterface
     * @MongoDB\Field(type="date")
     * @Groups({"message"})
     */
    private $date;

    /**
     * @var bool
     * @MongoDB\Field (type="boolean")
     * @Groups({"message"})
     */
    private $read;

    /**
     * @var int|null
     * @MongoDB\Field(type="integer")
     * @Groups({"message"})
     */
    private $unReadCount;

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     * @return MessageGroupItem
     */
    public function setFrom(int $from): MessageGroupItem
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }

    /**
     * @param int $to
     * @return MessageGroupItem
     */
    public function setTo(int $to): MessageGroupItem
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return MessageGroupItem
     */
    public function setText(string $text): MessageGroupItem
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return MessageGroupItem
     */
    public function setDate(\DateTimeInterface $date): MessageGroupItem
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRead(): ?bool
    {
        return $this->read;
    }

    /**
     * @param bool $read
     * @return MessageGroupItem
     */
    public function setRead(bool $read): MessageGroupItem
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUnReadCount(): ?int
    {
        return $this->unReadCount;
    }

    /**
     * @param int|null $unReadCount
     * @return MessageGroupItem
     */
    public function setUnReadCount(?int $unReadCount): MessageGroupItem
    {
        $this->unReadCount = $unReadCount;
        return $this;
    }


}
