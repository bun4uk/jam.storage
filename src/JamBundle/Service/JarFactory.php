<?php
/**
 * Created by PhpStorm.
 * User: v.bunchuk
 * Date: 10.01.17
 * Time: 12:43
 */

namespace JamBundle\Service;

use Doctrine\ORM\EntityManager;
use JamBundle\Entity\Jar;

class JarFactory
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * JarFactory constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Jar $jarEntity
     */
    public function persistAdditional(Jar $jarEntity)
    {
        for ($amount = $jarEntity->getAmount(); $amount > 1; $amount--) {
            $this->entityManager->persist(clone $jarEntity);
        }
        $this->entityManager->flush();
    }
}
