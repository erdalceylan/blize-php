<?php

namespace App\Command;

use App\Document\Message;
use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'fill:mongo-messages',
    description: 'Fills MongoDB with dummy messages.',
)]
class FillMongoMessagesCommand extends Command
{
    private EntityManagerInterface $em;
    private UserRepository $userRepository;
    private DocumentManager $dm;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        DocumentManager $dm
    ) {
        parent::__construct();
        ini_set('memory_limit', '-1');
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->dm = $dm;
    }

    /**
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @throws \DateMalformedStringException
     * @throws \Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->userRepository->findBy([], ['id' => 'ASC'], 500, 0);

        if (empty($users)) {
            $io->error('No users found in the database. Please create users first.');
            return Command::FAILURE;
        }

        $text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Why do we use it? It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).Where does it come from? Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet.., comes from a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from de Finibus Bonorum et Malorum by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham. Where can I get some? There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.";
        $count = strlen($text);
        $batchSize = 1000;

        for ($i = 0; $i < 500000; $i++) {
            $u1 = $users[array_rand($users)];
            $u2 = $users[array_rand($users)];

            if ($u1->getId() !== $u2->getId()) {
                $start = random_int(0, $count - 100);
                $end = random_int($start, $count);
                $t = substr($text, $start, $end);
                $t = substr($t, 0, random_int(0, min(strlen($t), 100)));

                if (strlen($t) < 5) {
                    continue;
                }

                if (strlen($t) === 30) {
                    $t = substr($t, 0, random_int(10, 100));
                }

                $message = new Message();
                $message->setFrom($u2->getId());
                $message->setTo($u1->getId());
                $message->setText($t);
                $message->setRead(false);
                $message->setDate(new \DateTimeImmutable('- ' . $i . ' seconds'));
                $this->dm->persist($message);

                if (($i % $batchSize) === 0) {
                    $this->dm->flush();
                    $this->dm->clear();
                    $io->writeln("Flushed " . $i . " messages.");
                }
            }
        }

        $this->dm->flush();
        $this->dm->clear();

        $io->success('Messages generated successfully!');

        return Command::SUCCESS;
    }
}