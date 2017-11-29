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

use AppBundle\Entity\SubjectInterface;
use AppBundle\Model\AbstractSubjectManager;

/**
 * Class SubjectManager.
 */
class SubjectManager extends AbstractSubjectManager
{
    use ObjectManagerTrait;

    /**
     * {@inheritdoc}
     */
    public function updateSubject(
        SubjectInterface $subject,
        $andFlush = true
    ) {
        $this->updateEntity($subject, $andFlush);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteSubject(SubjectInterface $subject)
    {
        $this->deleteEntity($subject);
    }

    /**
     * {@inheritdoc}
     */
    public function findSubjectBy(array $criteria)
    {
        return $this->findEntityBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findSubjectsBy(
        array $criteria,
        array $order = []
    ) {
        return $this->findEntitiesBy($criteria, $order);
    }

    /**
     * {@inheritdoc}
     */
    public function findSubjects($order = [])
    {
        return $this->findAllEntities($order);
    }
}
