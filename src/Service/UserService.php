<?php

namespace App\Service;

use App\Entity\User;
use App\Type\Image\Uploaded;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private EntityManagerInterface $entityManager;
    private ImageUploadService $imageUploadService;
    private ParameterBagInterface $parameterBag;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        ImageUploadService $imageUploadService,
        ParameterBagInterface $parameterBag,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        $this->entityManager = $entityManager;
        $this->imageUploadService = $imageUploadService;
        $this->parameterBag = $parameterBag;
        $this->passwordHasher = $passwordHasher;
    }

    public function create(User $user)
    {
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setLastSeen(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function updateLasSeen(User $user)
    {
        $user->setlastSeen(new \DateTime());
        $this->entityManager->flush();
    }

    /**
     * @param string $fileUrl
     * @return Uploaded
     * @throws \ImagickException
     */
    public function uploadImage(string $fileUrl): Uploaded
    {
        $rootFolder = $this->parameterBag->get("uploaded_images_path");
        $publicPath = $this->parameterBag->get("kernel.project_dir")."/public";
        $filePath = "/user/".date("Y/m/d/");
        $fileName = md5(microtime().rand()).".jpeg";
        $imagick = $this->imageUploadService->load($fileUrl);

        $this->imageUploadService
            ->checkSize($imagick, ImageUploadService::CROP_128, ImageUploadService::CROP_128)
            ->resizeMin($imagick, ImageUploadService::CROP_128, ImageUploadService::CROP_128)
            ->cropRatio($imagick, 1)
            ->save($imagick, $publicPath . $rootFolder . $filePath . $fileName);

        return new Uploaded($rootFolder, $filePath, $fileName, $imagick);
    }
}
