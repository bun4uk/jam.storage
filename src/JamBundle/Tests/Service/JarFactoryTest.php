<?php
/**
 * Created by PhpStorm.
 * User: v.bunchuk
 * Date: 10.01.17
 * Time: 17:25
 */

namespace JamBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Common\Persistence\ObjectRepository;

use Doctrine\ORM\EntityManager;
use JamBundle\Entity\Jar;
use JamBundle\Entity\Type;
use JamBundle\Entity\Year;
use JamBundle\Service\JarFactory;

class JarFactoryTest extends WebTestCase
{

    const JAR_FACTORY_YEAR = 2015;
    const JAR_FACTORY_TYPE = 'Blueberry Strain';
    const JAR_FACTORY_COMMENT = 'Blueberry gets its name from its fruity smell and sweet blueberry taste.';
    const JAR_FACTORY_AMOUNT = 3;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var ObjectRepository
     */
    private $jarRepository;

    /**
     * @var JarFactory
     */
    private $jarFactory;

    public function setUp()
    {
        $this->container = static::createClient()->getContainer();
        $this->jarFactory = $this->container->get('service.jar_factory');
        $this->jarRepository = $this->container->get('doctrine')->getRepository('JamBundle:Jar');
        $this->entityManager = $this->container->get('doctrine')->getManager();
        $this->entityManager->beginTransaction();
    }

    public function testPersisAdditional()
    {
        $year = new Year();
        $year->setYear(self::JAR_FACTORY_YEAR);

        $type = new Type();
        $type->setType(self::JAR_FACTORY_TYPE);

        $jar = new Jar();
        $jar->setYear($year);
        $jar->setType($type);
        $jar->setComment(self::JAR_FACTORY_COMMENT);
        $jar->setAmount(self::JAR_FACTORY_AMOUNT);


        $this->jarFactory->persistAdditional($jar);
        $this->entityManager->persist($jar);
        $this->entityManager->flush();

        $jamJars = $this->jarRepository->findByComment(self::JAR_FACTORY_COMMENT);

        $this->assertCount(self::JAR_FACTORY_AMOUNT, $jamJars);
    }

    public function tearDown()
    {
        $this->entityManager->rollback();
    }
}
