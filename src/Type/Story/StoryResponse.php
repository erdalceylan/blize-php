<?php

namespace App\Type\Story;

use App\Document\Story;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryResponse
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

    public static function fill(Story $story, User $user): self
    {
        $self = new self();
        $self
            ->setId($story->getId())
            ->setUser($user)
            ->setRootPath($story->getRootPath())
            ->setPath($story->getPath())
            ->setFileName($story->getFileName())
            ->setDate($story->getDate());

        return $self;
    }
}