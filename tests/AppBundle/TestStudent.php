<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle;

use AppBundle\Entity\Student;

/**
 * Class TestStudent.
 */
class TestStudent extends Student
{
    public static function createDummy()
    {
        $student = new self();
        $student->setId(1)
                ->setName('Foo')
                ->setSurname('Bar')
                ->setEmail('foo.bar@gmail.com')
                ->setAverage(5);
    }

    /**
     * @param $id
     *
     * @return TestStudent
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
