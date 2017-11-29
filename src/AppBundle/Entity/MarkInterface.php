<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

/**
 * Interface MarkInterface.
 */
interface MarkInterface extends ObjectInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return MarkInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Get lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified();

    /**
     * Set lastModified.
     *
     * @param \DateTime $lastModified
     *
     * @return MarkInterface
     */
    public function setLastModified(\DateTime $lastModified);

    /**
     * Get score.
     *
     * @return int
     */
    public function getScore();

    /**
     * Set score.
     *
     * @param int $score
     *
     * @return MarkInterface
     */
    public function setScore($score);

    /**
     * Get notes.
     *
     * @return string
     */
    public function getNotes();

    /**
     * Set notes.
     *
     * @param string $notes
     *
     * @return MarkInterface
     */
    public function setNotes($notes);

    /**
     * Get student.
     *
     * @return \AppBundle\Entity\StudentInterface
     */
    public function getStudent();

    /**
     * @param \AppBundle\Entity\StudentInterface $student
     *
     * @return MarkInterface
     */
    public function setStudent(StudentInterface $student);

    /**
     * Get subject.
     *
     * @return \AppBundle\Entity\SubjectInterface
     */
    public function getSubject();

    /**
     * Set subject.
     *
     * @param \AppBundle\Entity\SubjectInterface $subject
     *
     * @return MarkInterface
     */
    public function setSubject(SubjectInterface $subject);
}
