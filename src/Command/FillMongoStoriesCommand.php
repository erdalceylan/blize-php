<?php

namespace App\Command;

use App\Document\Story;
use App\Repository\UserRepository;
use App\Service\MongoStoryService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'fill:mongo-stories',
    description: 'Mongo veritabanına hikayeler ekler.'
)]
class FillMongoStoriesCommand extends Command
{
    private UserRepository $userRepository;
    private DocumentManager $dm;
    private MongoStoryService $mongoStoryService;

    public function __construct(
        UserRepository $userRepository,
        DocumentManager $dm,
        MongoStoryService $mongoStoryService
    ) {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->dm = $dm;
        $this->mongoStoryService = $mongoStoryService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
        $stories = $this->dm->getRepository(Story::class)->findAll();
        $xDate = new \DateTime();
        $xDate->modify(" - ".rand(0,60*60*24*30)." second");
        foreach ($stories as $index => $story) {
        $story->setDate($xDate->modify(" + ".$index." second"));
        $this->dm->flush();
        }
        return 1;
         */
        $io = new SymfonyStyle($input, $output);

        $users = $this->userRepository->findBy([], ['id' => 'ASC'], 500, 0);

        foreach ($users as $user) {

            for ($i = 0; $i <= rand(0, 7); $i++) {
                $imageUrl = "https://picsum.photos/600/1050";

                try {

                    $fileInfo = $this->mongoStoryService->uploadImage($imageUrl);

                    $story = new Story();
                    $story->setFrom($user->getId());
                    $story->setRootPath($fileInfo->getRootPath());
                    $story->setPath($fileInfo->getFilePath());
                    $story->setFileName($fileInfo->getFileName());
                    $story->setDate((new \DateTimeImmutable())->modify(" - " . rand(0, 60 * 60 * 24 * 30) . " second"));

                    $this->dm->persist($story);
                    $this->dm->flush();
                    $this->dm->clear();

                    $io->writeln($user->getUsername()." story created");

                } catch (\Throwable $throwable) {
                    $io->error($throwable->getMessage());
                    continue;
                }
            }
        }

        $io->success('Hikayeler başarıyla oluşturuldu!');

        return Command::SUCCESS;
    }

}