<?php

namespace App\Type\Call;

use App\Document\Call;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class CallResponse
{
    #[Groups(["call"])]
    protected string $id;

    #[Groups(["call"])]
    private User $from;

    #[Groups(["call"])]
    private User $to;

    #[Groups(["call"])]
    private bool $video;

    #[Groups(["call"])]
    private \DateTimeInterface $date;

    #[Groups(["call"])]
    private ?\DateTimeInterface $startDate = null;

    #[Groups(["call"])]
    private ?\DateTimeInterface $endDate = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function getTo(): User
    {
        return $this->to;
    }

    public function setTo(User $to): self
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

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public static function fill(Call $call, User $sessionUser, User $otherUser): self
    {
        $self = new self();
        $self
            ->setId($call->getId())
            ->setTo($call->getTo() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setFrom($call->getFrom() === $sessionUser->getId() ? $sessionUser : $otherUser)
            ->setVideo($call->isVideo())
            ->setStartDate($call->getStartDate())
            ->setEndDate($call->getEndDate())
            ->setDate($call->getDate());

        return $self;
    }
}