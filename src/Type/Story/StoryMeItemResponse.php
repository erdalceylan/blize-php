<?php

namespace App\Type\Story;

use App\Document\Result\StoryMeItem;
use App\Document\Result\StoryViewItem;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class StoryMeItemResponse
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
    private array $views = []; // Başlangıç değeri eklendi

    #[Groups(["story"])]
    private int $viewsLength;

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

    public function getViews(): array
    {
        return $this->views;
    }

    public function setViews(array $views): self
    {
        $this->views = $views;
        return $this;
    }

    public function addView(StoryViewItemResponse $viewItemResponse): self // Return type eklendi
    {
        $this->views[] = $viewItemResponse;
        return $this;
    }

    public function getViewsLength(): int
    {
        return $this->viewsLength;
    }

    public function setViewsLength(int $viewsLength): self
    {
        $this->viewsLength = $viewsLength;
        return $this;
    }

    public static function fill(User $user, StoryMeItem $storyMeItem): self // Return type eklendi
    {
        $self = new self();
        $self
            ->setId($storyMeItem->getId())
            ->setUser($user)
            ->setRootPath($storyMeItem->getRootPath())
            ->setPath($storyMeItem->getPath())
            ->setFileName($storyMeItem->getFileName())
            ->setDate($storyMeItem->getDate())
            ->setViewsLength($storyMeItem->getViewsLength());

        return $self;
    }
}