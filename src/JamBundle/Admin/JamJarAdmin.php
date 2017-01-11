<?php
/**
 * Created by PhpStorm.
 * User: v.bunchuk
 * Date: 03.01.17
 * Time: 18:36
 */

namespace JamBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\Range;
use JamBundle\Service\JarFactory;
use JamBundle\Entity\Jar;

class JamJarAdmin extends AbstractAdmin
{
    /**
     * @var JarFactory
     */
    private $jarFactory;

    /**
     * JamJarAdmin constructor.
     *
     * @param string     $code
     * @param string     $class
     * @param string     $baseControllerName
     * @param JarFactory $jarFactory
     */
    public function __construct($code, $class, $baseControllerName, JarFactory $jarFactory)
    {
        $this->jarFactory = $jarFactory;
        parent::__construct($code, $class, $baseControllerName);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type')
            ->add('year')
            ->add('comment');

        $jar = $formMapper->getFormBuilder()->getData();
        if (!$jar || empty($jar->getId())) {
            $formMapper->add(
                'amount',
                'text',
                [
                    'label' => 'Amount',
                    'required' => true,
                    'data' => 1, 'constraints' => [new Range(['min' => 1, 'max' => 100])],
                ]
            );
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('type');
        $datagridMapper->add('year');
        $datagridMapper->add('comment');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier(
            'type',
            'text',
            [
                'route' => [
                    'name' => 'show'
                ]
            ]
        );
        $listMapper->addIdentifier(
            'year',
            'text',
            [
                'route' => [
                    'name' => 'show'
                ]
            ]
        );
        $listMapper->addIdentifier(
            'comment',
            null,
            [
                'route' => [
                    'name' => 'show'
                ]
            ]
        );
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->tab('Jam') // the tab call is optional
            ->with(
                'Jar',
                [
                    'class'       => 'col-md-5',
                    'box_class'   => 'box box-solid box-info',
                    'description' => 'Lorem ipsum',
                ]
            )
            ->add('id')
            ->add('type')
            ->add('year')
            ->add('comment');
    }

    /**
     * @param mixed $jarEntity
     */
    public function prePersist($jarEntity)
    {
        $this->jarFactory->persistAdditional($jarEntity);
        parent::prePersist($jarEntity);
    }
}
