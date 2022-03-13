<?php


namespace App\Type\Message;


use App\Document\Result\MessageGroupItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageGroupItemResponse
{
    /**
     * @var User|null
     * @Groups({"message"})
     */
    private $from;

    /**
     * @var User|null
     * @Groups({"message"})
     */
    private $to;

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
     * @var int|null
     * @Groups({"message"})
     */
    private $unReadCount;

    /**
     * @return User
     */
    public function getFrom(): ?User
    {
        return $this->from;
    }

    /**
     * @param User|null $from
     * @return self
     */
    public function setFrom(?User $from): self
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getTo(): ?User
    {
        return $this->to;
    }

    /**
     * @param User|null $to
     * @return self
     */
    public function setTo(?User $to): self
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
     * @return int|null
     */
    public function getUnReadCount(): ?int
    {
        return $this->unReadCount;
    }

    /**
     * @param int|null $unReadCount
     * @return self
     */
    public function setUnReadCount(?int $unReadCount): self
    {
        $this->unReadCount = $unReadCount;
        return $this;
    }


    /**
     * @param MessageGroupItem $result
     * @param User $sessionUser
     * @param User|null $otherUser
     * @return self
     */
    public static function fill(MessageGroupItem $result, User $sessionUser, ?User $otherUser)
    {
        $self = new self();
        $self
            ->setTo( $result->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($result->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setText($result->getText())
            ->setDate($result->getDate())
            ->setRead($result->isRead())
            ->setUnReadCount($result->getUnReadCount());

        return $self;
    }

}
