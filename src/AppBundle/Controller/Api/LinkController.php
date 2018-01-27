<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 23.01.18
 * Time: 21:00
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Link;
use AppBundle\Repository\LinkRepository;
use AppBundle\Utils\Helpers;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;


/**
 * Class LinkController
 * @package AppBundle\Controller\Api
 */
class LinkController extends FOSRestController
{

    /**
     * @Rest\Get("/api/link")
     * @param LinkRepository $linkRepository
     * @return array|View
     */
    public function getAction(LinkRepository $linkRepository)
    {
        $links = $linkRepository->getAllLinks();

        if ($links === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $links;
    }


    /**
     * @Rest\Post("/api/link")
     * @param Request $request
     * @param LinkRepository $linkRepository
     * @param Helpers $helpers
     * @return array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postAction(Request $request,  LinkRepository $linkRepository, Helpers $helpers)
    {
        /**
         * @var $link Link
         */
        $link = $linkRepository->getNewLink($request->request->all());

        if($errors = $helpers->validateEntity($link)){
            return ['status' => 'error', 'errors' => $errors];
        }

        if($status = $linkRepository->addLink($link) === true){
            return ['status' => 'success'];
        } else{
           return ['status' => 'error', 'message'=>$status];
        }

    }

}