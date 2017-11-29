<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\StudentInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\QueryBuilder;

/**
 * Class StudentRepository.
 */
class StudentRepository extends EntityRepository
{
    /**
     * @param string $order
     *
     * @return array
     */
    public function findAllWithMarksAverage($order)
    {
        $sql = "SELECT s.id, s.name, s.surname, s.email, ROUND(AVG(m.score),1) AS average
FROM student s INNER JOIN mark m ON m.student_id = s.id
GROUP BY s.id
ORDER BY s.surname $order";

        /** @var ResultSetMappingBuilder $rsm */
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata('AppBundle:Student', 's');
        //$rsm->addJoinedEntityFromClassMetadata('AppBundle:Mark', 'm', 's', 'marks', ['id' => 'student_id']);
        $rsm->addMetaResult('s', 'average', 'average', false);

        $query = $this->getEntityManager()
                      ->createNativeQuery($sql, $rsm);

        return $query->getArrayResult();
    }

    /**
     * @param \AppBundle\Entity\StudentInterface $student
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return null|mixed
     */
    public function findMarksAverageByStudent(StudentInterface $student)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('s');

        $qb->select('ROUND(AVG(m.score),1) AS average')
           ->join('AppBundle:Mark', 'm', 'WITH', 's.id = m.student')
           ->andWhere('s.id = :student_id')
           ->setParameter('student_id', $student->getId())
           ->groupBy('s.id');

        try {
            return $qb->getQuery()
                      ->getSingleResult()['average'];
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
