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
 * Interface SubjectInterface.
 */
interface SubjectInterface extends ObjectInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return SubjectInterface
     */
    public function setName($name);

    /**
     * Add mark.
     *
     * @param \AppBundle\Entity\MarkInterface $mark
     *
     * @return Subject
     */
    public function addMark(MarkInterface $mark);

    /**
     * Remove mark.
     *
     * @param \AppBundle\Entity\MarkInterface $mark
     */
    public function removeMark(MarkInterface $mark);

    /**
     * Get marks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks();
}
