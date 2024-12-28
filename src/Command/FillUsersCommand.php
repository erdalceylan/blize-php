<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'fill:fill_users',
    description: 'Creates default users and Marvel users from API.'
)]
class FillUsersCommand extends Command
{
    private UserPasswordHasherInterface $encoder;
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;
    private UserService $userService;

    public function __construct(
        UserPasswordHasherInterface $encoder,
        HttpClientInterface $httpClient,
        EntityManagerInterface $entityManager,
        UserService $userService
    )
    {
        parent::__construct();

        $this->encoder = $encoder;
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->userService = $userService;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->insertDefault();
        $this->insertMarvel();

        return Command::SUCCESS;
    }

    private function insertMarvel()
    {
        //testformarvelapi
        $privateKey = "3d037b2391ebb04e17ff86ee55257334d355f2de";
        $publicKey = "88407e08345941124a7db1309d680edb";
        $query = [
            "ts" => time(),
            "apikey" => $publicKey,
            "hash" => md5(time() . $privateKey . $publicKey),
            "limit" => 100,
            "offset" => 1500
        ];

        $res = $this->httpClient->request("GET", "http://gateway.marvel.com/v1/public/characters", ['query' => $query])->toArray();

        foreach ($res['data']['results'] as $character) {

            $username = preg_replace("/[^a-zA-Z0-9]/","", $character['name']);
            $fileUrl = null;

            if (!str_contains($character['thumbnail']['path'], "image_not_available")) {
                $image = $character['thumbnail']['path'].".".$character['thumbnail']['extension'];

                $imageInfo = $this->userService->uploadImage($image);

                $fileUrl = $imageInfo->getRootPath().$imageInfo->getFilePath().$imageInfo->getFileName();
            }

            $this->insertUser(
                $character['name'],
                "MRVL",
                strtolower($username),
                strtolower($username)."@mrvl.com",
                $fileUrl
            );
        }

    }

    private function insertDefault()
    {
        $users = array(
            array('email' => 'erdalceylan@example.com','username' => 'erdalceylan','first_name' => 'Erdal','last_name' => 'CEYLAN','image' => NULL),
            array('email' => 'johnsmit@example.com','username' => 'johnsmit','first_name' => 'John','last_name' => 'Smith','image' => NULL),
            array('email' => 'cuneytozdemir@example.com','username' => 'cuneytozdemir','first_name' => 'Cüneyt','last_name' => 'Özdemir','image' => NULL),
            array('email' => 'tijen@example.com','username' => 'tijenkarakas','first_name' => 'Tijen','last_name' => 'Karakaş','image' => NULL),
            array('email' => 'hayko@example.com','username' => 'hayko','first_name' => 'Hyko','last_name' => 'Cepkin','image' => NULL),
            array('email' => 'ryangosling@example.com','username' => 'ryangosling','first_name' => 'Ryan','last_name' => 'GOSLING','image' => NULL),
            array('email' => 'hughjackman@example.com','username' => 'hughjackman','first_name' => 'Hugh','last_name' => 'Jackman','image' => NULL),
            array('email' => 'maxplank@example.com','username' => 'maxplank','first_name' => 'Max','last_name' => 'Plank','image' => NULL),
            array('email' => 'mariacurie@example.com','username' => 'mariacurie','first_name' => 'Maria','last_name' => 'Curie','image' => NULL),
            array('email' => 'margotrobbie@example.com','username' => 'margotrobbie','first_name' => 'Margot','last_name' => 'Robbie','image' => NULL),
            array('email' => 'erwinschrodinger@example.com','username' => 'erwinschrodinger','first_name' => 'Erwin','last_name' => 'Schrödinger','image' => NULL),
            array('email' => 'platon@example.com','username' => 'platon','first_name' => 'Platon','last_name' => 'Philosopher','image' => NULL),
            array('email' => 'aristoteles@example.com','username' => 'aristoteles','first_name' => 'Aristoteles','last_name' => 'Philosopher','image' => NULL),
            array('email' => 'sokrates@example.com','username' => 'sokrates','first_name' => 'Sokrates','last_name' => 'Philosopher','image' => NULL),
            array('email' => 'archimedes@example.com','username' => 'archimedes','first_name' => 'Archimedes','last_name' => 'Physicist,','image' => NULL),
        );

        foreach ($users as $item) {
            $this->insertUser($item['first_name'], $item['last_name'], $item['username'], $item['email']);
        }
    }

    private function insertUser($name = null, $lastName= null, $userName = null, $email= null, $image = null)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $userName]);

        if ($user) {
            return;
        }

        $user = new User();
        $user->setFirstName($name);
        $user->setLastName($lastName);
        $user->setUsername($userName);
        $user->setEmail($email);
        $user->setImage($image);
        $user->setRoles(['ROLE_USER']);
        $user->setLastSeen(new \DateTime());
        $user->setPassword($this->encoder->hashPassword($user, '123456'));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
