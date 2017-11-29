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

use AppBundle\Entity\MarkInterface;
use AppBundle\Model\AbstractMarkManager;

/**
 * Class MarkManager.
 */
class MarkManager extends AbstractMarkManager
{
    use ObjectManagerTrait;

    /**
     * {@inheritdoc}
     */
    public function updateMark(
        MarkInterface $mark,
        $andFlush = true
    ) {
        $this->updateEntity($mark, $andFlush);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMark(MarkInterface $mark)
    {
        $this->deleteEntity($mark);
    }

    /**
     * {@inheritdoc}
     */
    public function findMarkBy(array $criteria)
    {
        return $this->findEntityBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findMarksBy(
        array $criteria,
        array $order = []
    ) {
        return $this->findEntitiesBy($criteria, $order);
    }

    /**
     * {@inheritdoc}
     */
    public function findMarks($order = [])
    {
        return $this->findAllEntities($order);
    }
}
