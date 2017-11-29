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

use AppBundle\Entity\StudentInterface;
use AppBundle\Model\AbstractStudentManager;

/**
 * Class StudentManager.
 */
class StudentManager extends AbstractStudentManager
{
    use ObjectManagerTrait;

    /**
     * {@inheritdoc}
     */
    public function updateStudent(
        StudentInterface $student,
        $andFlush = true
    ) {
        $this->updateEntity($student, $andFlush);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteStudent(StudentInterface $student)
    {
        $this->deleteEntity($student);
    }

    /**
     * {@inheritdoc}
     */
    public function findStudentBy(array $criteria)
    {
        return $this->findEntityBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function findStudentsBy(
        array $criteria,
        array $order = []
    ) {
        return $this->findEntitiesBy($criteria, $order);
    }

    /**
     * {@inheritdoc}
     */
    public function findStudents($order = [])
    {
        return $this->findAllEntities($order);
    }

    /**
     * {@inheritdoc}
     */
    public function findStudentsWithMarksAverage($order = 'ASC')
    {
        return $this->getRepository()
                    ->findAllWithMarksAverage($order);
    }

    /**
     * {@inheritdoc}
     */
    public function findMarksAverageByStudent(StudentInterface $student)
    {
        return $this->getRepository()
                    ->findMarksAverageByStudent($student);
    }

    /**
     * {@inheritdoc}
     */
    public function setStudentAverage(StudentInterface $student)
    {
        $average = $this->findMarksAverageByStudent($student);
        $student->setAverage($average);
    }
}
