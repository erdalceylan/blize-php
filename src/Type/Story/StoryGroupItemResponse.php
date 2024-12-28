<?php

namespace App\Type\Story;

use App\Document\Result\StoryGroupItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryGroupItemResponse
{
    #[Groups(["story"])]
    protected string $id;

    #[Groups(["story"])]
    private User $user;

    #[Groups(["story"])]
    private string $rootPath;

    #[Groups(["story"])]
    private string $path;

    #[Groups(["story"])]
    private string $fileName;

    #[Groups(["story"])]
    private \DateTimeInterface $date;

    #[Groups(["story"])]
    private bool $seen;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function setRootPath(string $rootPath): self
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
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

    public function isSeen(): bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;
        return $this;
    }

    public static function fill(StoryGroupItem $groupItem, User $user): self // Return type eklendi
    {
        $self = new self();
        $self
            ->setId($groupItem->getId())
            ->setUser($user)
            ->setRootPath($groupItem->getRootPath())
            ->setPath($groupItem->getPath())
            ->setFileName($groupItem->getFileName())
            ->setDate($groupItem->getDate())
            ->setSeen($groupItem->getSeen());

        return $self;
    }
}