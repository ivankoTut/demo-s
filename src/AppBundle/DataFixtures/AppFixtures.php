<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Link;
use AppBundle\Repository\LinkRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Utils\Helpers;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AppFixtures extends Fixture
{

    private $crawler;

    private $urlLists = [];

    private $count = 0;

    private $linkRepository;

    private $helper;

    private $validator;

    public function __construct(LinkRepository $linkRepository, Helpers $helpers, ValidatorInterface $validator)
    {
        $this->linkRepository = $linkRepository;
        $this->helper = $helpers;
        $this->validator = $validator;

        $this->loadUrlLists();
    }

    public function load(ObjectManager $manager)
    {

        foreach ($this->urlLists as $url) {
            $link = new Link();
            $link->setFullLink($url);
            $link->setShortLink($this->helper->randomString());
            $link->setCountVisit(0);

            $errors = $this->validator->validate($link);

            if(count($errors) == 0) {
                $manager->persist($link);
            }
        }

        $manager->flush();
    }

    private function createLink()
    {
        if ($this->count === 0) {
            $url = 'https://www.google.com.ua/search?q=symfony+best+practice&ei=vIpnWqjeBYatswG3zpPQBw&start=0&sa=N&biw=1433&bih=967';
        } else {
            $url = 'https://www.google.com.ua/search?q=symfony+best+practice&ei=vIpnWqjeBYatswG3zpPQBw&start=' . $this->count . '&sa=N&biw=1433&bih=967';
        }

        $this->count += 10;
        return $url;
    }

    private function loadUrlLists()
    {
        if($this->count > 100) return true;

        $this->crawler = new Crawler(file_get_contents($this->createLink()));

        $this->crawler->filter('#ires .r a')->each(function (Crawler $node, $i) {
            $this->urlLists[] = str_replace('/url?q=','',$node->attr('href'));
        });

        return $this->loadUrlLists();
    }
}