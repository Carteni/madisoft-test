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
 * Interface StudentInterface.
 */
interface StudentInterface extends PersonInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * @return float
     */
    public function getAverage();

    /**
     * @param $average
     *
     * @return StudentInterface
     */
    public function setAverage($average);

    /**
     * @param \AppBundle\Entity\MarkInterface $mark
     *
     * @return StudentInterface
     */
    public function addMark(MarkInterface $mark);

    /**
     * Remove mark.
     *
     * @param MarkInterface $mark
     */
    public function removeMark(MarkInterface $mark);

    /**
     * @return StudentInterface
     */
    public function removeAllMarks();

    /**
     * Get marks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks();
}
