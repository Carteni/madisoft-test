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
 * Interface ObjectManagerInterface.
 */
interface ObjectManagerInterface
{
    /**
     * Returns the subject's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}
