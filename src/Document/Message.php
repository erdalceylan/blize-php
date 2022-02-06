<?php


namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @MongoDB\Document(collection="message")
 */
class Message
{
    /**
     * @MongoDB\Id
     * @Groups({"message"})
     */
    protected $id;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Message
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     * @return Message
     */
    public function setFrom(int $from): Message
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
     * @return Message
     */
    public function setTo(int $to): Message
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
     * @return Message
     */
    public function setText(string $text): Message
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
     * @return Message
     */
    public function setDate(\DateTimeInterface $date): Message
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
     * @return Message
     */
    public function setRead(bool $read): Message
    {
        $this->read = $read;
        return $this;
    }

}
