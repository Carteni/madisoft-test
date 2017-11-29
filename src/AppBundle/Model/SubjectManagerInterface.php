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

use AppBundle\Entity\SubjectInterface;

/**
 * Interface SubjectManagerInterface.
 */
interface SubjectManagerInterface extends ObjectManagerInterface
{
    /**
     * Creates an empty subject instance.
     *
     * @return SubjectInterface
     */
    public function createSubject();

    /**
     * Updates a subject.
     *
     * @param SubjectInterface $subject
     */
    public function updateSubject(SubjectInterface $subject);

    /**
     * Deletes a subject.
     *
     * @param SubjectInterface $subject
     */
    public function deleteSubject(SubjectInterface $subject);

    /**
     * Finds one subject by the given criteria.
     *
     * @param array $criteria
     *
     * @return SubjectInterface
     */
    public function findSubjectBy(array $criteria);

    /**
     * Finds a subject by its name.
     *
     * @param string $name
     *
     * @return SubjectInterface or null if subject does not exist
     */
    public function findSubjectByName($name);

    /**
     * Finds a subjects collection by the given criteria.
     *
     * @param array $criteria
     * @param array $order
     *
     * @return SubjectInterface[]
     */
    public function findSubjectsBy(
        array $criteria,
        array $order = []
    );

    /**
     * Returns a collection with all subject instances.
     *
     * @param $order
     *
     * @return \Traversable
     */
    public function findSubjects($order = []);
}
