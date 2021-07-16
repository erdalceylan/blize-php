<?php


namespace App\Type\Message;


use App\Document\Message;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class Item
{
    /**
     * @var string
     * @Groups({"message"})
     */
    protected $id;

    /**
     * @var User
     * @Groups({"message"})
     */
    protected $from;

    /**
     * @var User
     * @Groups({"message"})
     */
    protected $to;

    /**
     * @var string
     * @Groups({"message"})
     */
    private $text;

    /**
     * @var \DateTimeInterface
     * @Groups({"message"})
     */
    private $date;

    /**
     * @var bool
     * @Groups({"message"})
     */
    private $read;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Item
     */
    public function setId(string $id): Item
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getFrom(): User
    {
        return $this->from;
    }

    /**
     * @param User $from
     * @return Item
     */
    public function setFrom(User $from): Item
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return User
     */
    public function getTo(): User
    {
        return $this->to;
    }

    /**
     * @param User $to
     * @return Item
     */
    public function setTo(User $to): Item
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
     * @return Item
     */
    public function setText(string $text): Item
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
     * @return Item
     */
    public function setDate(\DateTimeInterface $date): Item
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * @param bool $read
     * @return Item
     */
    public function setRead(bool $read): Item
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @param Message $message
     * @param User $sessionUser
     * @param User $otherUser
     * @return Item
     */
    public static function map(Message $message, User $sessionUser, User $otherUser)
    {
        $self = new self();
        $self
            ->setId($message->getId())
            ->setTo( $message->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($message->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setText($message->getText())
            ->setDate($message->getDate())
            ->setRead($message->isRead());

        return $self;
    }
}
