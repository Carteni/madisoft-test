<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Model;

use AppBundle\Entity\StudentInterface;

/**
 * Interface StudentManagerInterface.
 */
interface StudentManagerInterface extends ObjectManagerInterface
{
    /**
     * Creates an empty student instance.
     *
     * @return StudentInterface
     */
    public function createStudent();

    /**
     * Updates a student.
     *
     * @param StudentInterface $student
     */
    public function updateStudent(StudentInterface $student);

    /**
     * Deletes a student.
     *
     * @param StudentInterface $student
     */
    public function deleteStudent(StudentInterface $student);

    /**
     * Finds one student by the given criteria.
     *
     * @param array $criteria
     *
     * @return StudentInterface
     */
    public function findStudentBy(array $criteria);

    /**
     * Finds a student by its email.
     *
     * @param string $email
     *
     * @return StudentInterface or null if student does not exist
     */
    public function findStudentByEmail($email);

    /**
     * Finds a student by its surname or email.
     *
     * @param string $surnameOrEmail
     *
     * @return StudentInterface or null if student does not exist
     */
    public function findStudentBySurnameOrEmail($surnameOrEmail);

    /**
     * Finds a students collection by the given criteria.
     *
     * @param array $criteria
     * @param array $order
     *
     * @return StudentInterface[]
     */
    public function findStudentsBy(
        array $criteria,
        array $order = []
    );

    /**
     * Returns a collection with all student instances.
     *
     * @param $order
     *
     * @return \Traversable
     */
    public function findStudents($order = []);

    /**
     * Returns a collection with all student instances along with marks average.
     *
     * @param $order
     *
     * @return \Traversable
     */
    public function findStudentsWithMarksAverage($order = 'ASC');

    /**
     * @param \AppBundle\Entity\StudentInterface $student
     *
     * @return int
     */
    public function findMarksAverageByStudent(StudentInterface $student);

    /**
     * @param \AppBundle\Entity\StudentInterface $student
     */
    public function setStudentAverage(StudentInterface $student);
}
