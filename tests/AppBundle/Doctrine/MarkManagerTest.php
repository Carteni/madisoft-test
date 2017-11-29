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

use AppBundle\Doctrine\MarkManager;
use AppBundle\Doctrine\StudentManager;
use AppBundle\Doctrine\SubjectManager;
use AppBundle\Entity\MarkInterface;
use AppBundle\Entity\StudentInterface;
use AppBundle\Entity\SubjectInterface;
use AppBundle\Model\MarkManagerInterface;
use AppBundle\Model\StudentManagerInterface;
use AppBundle\Model\SubjectManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class MarkManagerTest.
 */
class MarkManagerTest extends KernelTestCase
{
    /**
     * @var MarkManagerInterface
     */
    private $mm;

    /**
     * @var StudentManagerInterface
     */
    private $sm;

    /**
     * @var SubjectManagerInterface
     */
    private $sum;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->mm = $kernel->getContainer()
                           ->get(MarkManager::class);

        $this->sm = $kernel->getContainer()
                           ->get(StudentManager::class);

        $this->sum = $kernel->getContainer()
                            ->get(SubjectManager::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->mm = null;
        $this->sm = null;
        $this->sum = null;
    }

    public function testMarkInsert()
    {
        /** @var StudentInterface $tasso */
        $tasso = $this->sm->findStudentBy(['surname' => 'Tasso']);

        /** @var SubjectInterface $subject */
        $subject = $this->sum->findSubjectBy(['id' => 1]);

        /** @var MarkInterface $mark */
        $mark = $this->mm->createMark();
        $mark->setStudent($tasso);
        $mark->setSubject($subject);
        $mark->setScore(10);
        $mark->setNotes('Nunc ullamcorper vehicula ante, et tempor nibh tempus sit amet.');

        //$this->mm->updateMark($mark);
        $this->sm->updateStudent($tasso);

        $this->assertCount(7, $this->mm->findMarks(), sprintf('Expected marks count is %s', 7));
    }

    public function testStudentMarksCount()
    {
        /** @var StudentInterface $tasso */
        $tasso = $this->sm->findStudentBy(['surname' => 'Tasso']);

        /** @var MarkInterface[] $marks */
        $marks = $this->mm->findMarksBy(['student' => $tasso]);

        $this->assertCount(3, $marks, sprintf('Expected tasso marks count is %s', 3));
    }

    public function testIfMarkSearchedByStudentExists()
    {
        /** @var StudentInterface $tasso */
        $tasso = $this->sm->findStudentBy(['surname' => 'Tasso']);

        /** @var MarkInterface $mark */
        $mark = $this->mm->findMarkBy(['student' => $tasso]);

        $this->assertTrue('Tasso' === $mark->getStudent()
                                           ->getSurname(), sprintf('Expected student surname is %s', 'Tasso'));
    }

    public function testIfMarkIsDeletedThroughStudent()
    {
        /** @var StudentInterface $tasso */
        $tasso = $this->sm->findStudentBy(['surname' => 'Tasso']);

        /** @var MarkInterface $mark */
        $mark = $this->mm->findMarkBy(['id' => 7]);

        $tasso->removeMark($mark);
        $this->sm->updateStudent($tasso);

        /** @var MarkInterface[] $marks */
        $marks = $this->mm->findMarksBy(['student' => $tasso]);

        $this->assertCount(2, $marks, sprintf('Expected tasso marks count is %s', 2));
    }

    public function testIfMarkIsDeleted()
    {
        /** @var MarkInterface $mark */
        $mark = $this->mm->findMarkBy(['id' => 6]);

        $this->mm->deleteMark($mark);

        /** @var MarkInterface[] $marks */
        $mark = $this->mm->findMarkBy(['id' => 6]);

        $this->assertNull($mark);
    }
}
