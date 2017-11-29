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
 * Class AbstractStudentManager.
 *
 * Abstract Student Manager implementation which can be used as base class for concrete manager.
 */
abstract class AbstractStudentManager implements StudentManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createStudent()
    {
        $class = $this->getClass();
        $student = new $class();

        return $student;
    }

    /**
     * {@inheritdoc}
     */
    public function findStudentByEmail($email)
    {
        return $this->findStudentBy(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function findStudentBySurnameOrEmail($surnameOrEmail)
    {
        if (preg_match('/^.+\@\S+\.\S+$/', $surnameOrEmail)) {
            return $this->findStudentByEmail($surnameOrEmail);
        }

        return $this->findStudentBy(['surname' => $surnameOrEmail]);
    }
}
