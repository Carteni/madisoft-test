<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Doctrine;

use AppBundle\Doctrine\StudentManager;
use AppBundle\Entity\StudentInterface;
use AppBundle\Model\StudentManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class StudentManagerTest.
 */
class StudentManagerTest extends KernelTestCase
{
    /**
     * @var StudentManagerInterface
     */
    private $sm;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->sm = $kernel->getContainer()
                           ->get(StudentManager::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->sm = null;
    }

    public function testIfStudentSearchedByEmailExists()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->findStudentBySurnameOrEmail('torquato.tasso@gmail.com');

        $this->assertNotNull($student, '$student must be null');
        $this->assertTrue(
            'torquato.tasso@gmail.com' === $student->getEmail(),
                          sprintf("Email must be '%s'", 'torquato.tasso@gmail.com')
        );
    }

    public function testIfStudentSearchedByEmailNotExists()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->findStudentBySurnameOrEmail('anonymous@gmail.com');

        $this->assertNull($student, '$student must be null');
    }

    public function testIfStudentsSearchedBySurnameExists()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->findStudentBySurnameOrEmail('tasso');

        $this->assertNotNull($student);
        $this->assertTrue('Tasso' === $student->getSurname(), sprintf("Surname must be '%s'", 'Tasso'));
    }

    public function testIfStudentSearchedBySurnameNotExists()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->findStudentBySurnameOrEmail('anonymous');

        $this->assertNull($student, '$student must be null');
    }

    public function testStudentsCount()
    {
        /** @var StudentInterface[] $students */
        $students = $this->sm->findStudents();

        $this->assertCount(3, $students, sprintf('Expected students count is %s', 3));
    }

    public function testStudentUpdate()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->findStudentBy(['id' => 1]);
        $student->setName('Foo');
        $this->sm->updateStudent($student);
        $student = $this->sm->findStudentBy(['name' => 'Foo']);

        $this->assertTrue('Foo' === $student->getName(), sprintf('Expected student name is %s', 'Foo'));
    }

    public function testIfDoctrineThrowsUniqueConstraintViolationException()
    {
        $this->expectException(\Doctrine\DBAL\Exception\UniqueConstraintViolationException::class);

        $student = $this->sm->createStudent();
        $student->setName('Foo');
        $student->setSurname('Bar');
        $student->setEmail('torquato.tasso@gmail.com'); // <----- email already exists.
        $this->sm->updateStudent($student);
    }

    public function testStudentInsert()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->createStudent();
        $student->setName('Baz');
        $student->setSurname('Boom');
        $student->setEmail('baz.boom@gmail.com');
        $this->sm->updateStudent($student);

        /** @var StudentInterface[] $students */
        $students = $this->sm->findStudents();
        $this->assertCount(4, $students, sprintf('Expected students count is %s', 4));
    }

    public function testStudentDelete()
    {
        /** @var StudentInterface $student */
        $student = $this->sm->findStudentBy(['surname' => 'Boom']);
        $this->sm->deleteStudent($student);
        /** @var StudentInterface[] $students */
        $students = $this->sm->findStudents();
        $this->assertCount(3, $students, sprintf('Expected students count is %s', 3));
    }
}
