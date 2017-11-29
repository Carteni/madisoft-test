<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Doctrine;

use AppBundle\Entity\ObjectInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Class ObjectManagerTrait.
 */
trait ObjectManagerTrait
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    private $class;

    /**
     * @return string
     */
    public function getClass()
    {
        if (false !== strpos($this->class, ':')) {
            $metadata = $this->objectManager->getClassMetadata($this->class);
            $this->class = $metadata->getName();
        }

        return $this->class;
    }

    /**
     * @param $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     */
    public function setObjectManager(ObjectManager $om)
    {
        $this->objectManager = $om;
    }

    /**
     * @param \AppBundle\Entity\ObjectInterface $object
     * @param bool|true                         $andFlush
     */
    protected function updateEntity(
        ObjectInterface $object,
        $andFlush = true
    ) {
        $this->objectManager->persist($object);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * @param \AppBundle\Entity\ObjectInterface $object
     */
    protected function deleteEntity(ObjectInterface $object)
    {
        $this->objectManager->remove($object);
        $this->objectManager->flush();
    }

    /**
     * @param array $criteria
     *
     * @return ObjectInterface
     */
    protected function findEntityBy(array $criteria)
    {
        return $this->getRepository()
                    ->findOneBy($criteria);
    }

    /**
     * @param array $criteria
     * @param array $order
     *
     * @return ObjectInterface[]
     */
    protected function findEntitiesBy(
        array $criteria,
        array $order
    ) {
        return $this->getRepository()
                    ->findBy($criteria, $order);
    }

    /**
     * @param array $order
     *
     * @return ObjectInterface[]
     */
    protected function findAllEntities(array $order)
    {
        return $this->getRepository()
                    ->findBy([], $order);
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->objectManager->getRepository($this->getClass());
    }
}
