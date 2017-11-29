<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * Interface FactoryInterface.
 */
interface FactoryInterface
{
    /**
     * @return FormInterface
     */
    public function createForm();
}
