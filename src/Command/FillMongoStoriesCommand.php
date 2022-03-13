<?php

namespace App\Command;

use App\Document\Story;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\MongoStoryService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Imagick;
use ImagickDraw;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FillMongoStoriesCommand extends Command
{
    protected static $defaultName = 'fill:mongo-stories';

    private UserRepository $userRepository;
    private DocumentManager $dm;
    private MongoStoryService $mongoStoryService;


    public function __construct(
        UserRepository $userRepository,
        DocumentManager $dm,
        MongoStoryService $mongoStoryService
    )
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->dm = $dm;
        $this->mongoStoryService = $mongoStoryService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**@var $stories Story[]*/
        /**
        $stories = $this->dm->getRepository(Story::class)->findAll();
        $xDate = new \DateTime();
        $xDate->modify(" - ".rand(0,60*60*24*30)." second");
        foreach ($stories as $index => $story) {
            $story->setDate($xDate->modify(" + ".$index." second"));
            $this->dm->flush();
        }

        return 1;*/
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $users = $this->userRepository->findBy([],['id'=>'ASC'],500, 0);
        $images = [
            'https://picsum.photos/600/1050',
            'https://picsum.photos/600/1050',
            'https://picsum.photos/600/1050',
            'https://picsum.photos/600/1050',
            'https://picsum.photos/600/1050'
        ];

        foreach ($users as $user) {

            shuffle($images);

            for($i=0; $i<= rand(0,3); $i++){
                $imageUrl = $images[$i];

                try {
                    $file = $this->uploadImage($imageUrl, $user, $i);
                }catch (\Throwable $throwable){
                    $io->error($throwable->getMessage());
                    continue;
                }


                $story = new Story();
                $story->setFrom($user->getId());
                $story->setRootPath($file->getRootPath());
                $story->setPath($file->getFilePath());
                $story->setFileName($file->getFileName());
                $story->setDate((new \DateTime())->modify(" - ".rand(0,60*60*24*30)." second"));

                $this->dm->persist($story);
                $this->dm->flush();
            }
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }

    /**
     * @param $fileUrl
     * @param User $user
     * @param $index
     * @return \App\Type\Image\Uploaded
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    private function uploadImage($fileUrl, User $user, $index)
    {

        $fileInfo = $this->mongoStoryService->uploadImage($fileUrl);

        $draw = new ImagickDraw();

        // watermark
        //$draw->setFont('Arial');
        $draw->setFontSize(40);
        $draw->setFillColor('white');
        $draw->setStrokeColor('black');
        $draw->setStrokeOpacity(0.5);
        $draw->setGravity(Imagick::GRAVITY_CENTER);
        $fileInfo->getImagick()->annotateImage($draw, 10, 12, 0, $user->getUsername()." - ". $index);
        $fileInfo->getImagick()->writeImage();

        return $fileInfo;
    }
}
