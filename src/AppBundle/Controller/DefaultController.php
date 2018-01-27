<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Repository\LinkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/{shortLink}", name="redirect_to_link")
     * @param $shortLink
     * @param LinkRepository $linkRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function redirectAction($shortLink, LinkRepository $linkRepository)
    {
        /**
         * @var $link Link
         */
        $link = $linkRepository->findOneBy(['shortLink' => $shortLink]);

        if (null === $link) {
            $response = new Response('', 404);

            return $this->render('default/404.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            ], $response);
        }

        $linkRepository->increaseCount($link);

        return $this->redirect($link->getFullLink(), 301);
    }
}
