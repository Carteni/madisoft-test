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

/**
 * Class AbstractMarkManager.
 *
 * Abstract Mark Manager implementation which can be used as base class for concrete manager.
 */
abstract class AbstractMarkManager implements MarkManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createMark()
    {
        $class = $this->getClass();
        $mark = new $class();

        return $mark;
    }
}
