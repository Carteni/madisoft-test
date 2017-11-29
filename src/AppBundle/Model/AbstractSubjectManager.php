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
 * Class AbstractSubjectManager.
 *
 * Abstract Subject Manager implementation which can be used as base class for concrete manager.
 */
abstract class AbstractSubjectManager implements SubjectManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSubject()
    {
        $class = $this->getClass();
        $subject = new $class();

        return $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function findSubjectByName($name)
    {
        return $this->findSubjectBy(['name' => $name]);
    }
}
