<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.01.18
 * Time: 12:11
 */

namespace AppBundle\Command;

use AppBundle\Repository\LinkRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DropOldLinkCommand extends Command
{

    /**
     * @var LinkRepository
     */
    private $linkRepository;


    /**
     * @var ObjectManager
     */
    private $manager;


    /**
     * DropOldLinkCommand constructor.
     * @param LinkRepository $linkRepository
     * @param ObjectManager $manager
     */
    public function __construct(LinkRepository $linkRepository, ObjectManager $manager)
    {
        $this->linkRepository = $linkRepository;
        $this->manager = $manager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('app:drop-old-link')
            ->setDescription('Drop old link')
            ->setHelp('Drop link over 15 days');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $links = $this->linkRepository->findAll();

        $countRemoveLink = 0;

        foreach ($links as $link) {
            if($link->getDifferenceDays() < 15 ){
                continue;
            }

            $countRemoveLink += 1;
            $this->manager->remove($link);
        }

        $this->manager->flush();

        $output->writeln('The number of remote references - ' . $countRemoveLink);
    }
}