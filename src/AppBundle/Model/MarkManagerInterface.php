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

use AppBundle\Entity\MarkInterface;

/**
 * Interface MarkManagerInterface.
 */
interface MarkManagerInterface extends ObjectManagerInterface
{
    /**
     * Creates an empty mark instance.
     *
     * @return MarkInterface
     */
    public function createMark();

    /**
     * Updates a mark.
     *
     * @param MarkInterface $mark
     */
    public function updateMark(MarkInterface $mark);

    /**
     * Deletes a mark.
     *
     * @param MarkInterface $mark
     */
    public function deleteMark(MarkInterface $mark);

    /**
     * Finds one mark by the given criteria.
     *
     * @param array $criteria
     *
     * @return MarkInterface
     */
    public function findMarkBy(array $criteria);

    /**
     * Finds a marks collection by the given criteria.
     *
     * @param array $criteria
     * @param array $order
     *
     * @return MarkInterface[]
     */
    public function findMarksBy(
        array $criteria,
        array $order = []
    );

    /**
     * Returns a collection with all mark instances.
     *
     * @param $order
     *
     * @return \Traversable
     */
    public function findMarks($order = []);
}
