<?php


namespace App\Type\Message;


use App\Document\Message;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageResponse
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
     * @return self
     */
    public function setId(string $id): self
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
     * @return self
     */
    public function setFrom(User $from): self
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
     * @return self
     */
    public function setTo(User $to): self
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
     * @return self
     */
    public function setText(string $text): self
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
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
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
     * @return self
     */
    public function setRead(bool $read): self
    {
        $this->read = $read;
        return $this;
    }

    /**
     * @param Message $message
     * @param User $sessionUser
     * @param User $otherUser
     * @return self
     */
    public static function fill(Message $message, User $sessionUser, User $otherUser)
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
