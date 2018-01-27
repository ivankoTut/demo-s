<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 25.01.18
 * Time: 14:59
 */

namespace AppBundle\EventListener;

use AppBundle\Utils\Helpers;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Link;

class CreateShortLink
{
    /**
     * @var Helpers
     */
    private $helper;

    /**
     * CreateShortLink constructor.
     * @param Helpers $helpers
     */
    public function __construct(Helpers $helpers)
    {
        $this->helper = $helpers;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool|void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        /**
         * @var $r Link
         */
        if (!$entity instanceof Link) {
            return;
        }

        if($entity->getShortLink() != 'generate'){
            return true;
        }

        $this->createShortLink($args);
    }

    /**
     * @param $args
     * @return bool
     */
    public function createShortLink($args)
    {

        $short = $this->helper->randomString();

        $link = $args->getEntityManager()->getRepository('AppBundle:Link')->findOneBy(['shortLink' => $short]);
        if(null === $link){
            $args->getEntity()->setShortLink($short);
            return true;
        }

        return $this->createShortLink($args);
    }

}