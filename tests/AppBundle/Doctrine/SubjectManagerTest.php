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

use AppBundle\Doctrine\SubjectManager;
use AppBundle\Entity\SubjectInterface;
use AppBundle\Model\SubjectManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class SubjectManagerTest.
 */
class SubjectManagerTest extends KernelTestCase
{
    /**
     * @var SubjectManagerInterface
     */
    private $sm;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->sm = $kernel->getContainer()
                           ->get(SubjectManager::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->sm = null;
    }

    public function testIfSubjectSearchedByNameExists()
    {
        /** @var SubjectInterface $subject */
        $subject = $this->sm->findSubjectByName('Italiano');

        $this->assertNotNull($subject, '$subject must be null');
        $this->assertTrue('Italiano' === $subject->getName(), sprintf("Subject name must be '%s'", 'Italiano'));
    }

    public function testIfSubjectSearchedByNameNotExists()
    {
        /** @var SubjectInterface $subject */
        $subject = $this->sm->findSubjectByName('Scienze');

        $this->assertNull($subject, '$subject must be null');
    }

    public function testSubjectsCount()
    {
        /** @var SubjectInterface[] $ubjects */
        $subjects = $this->sm->findSubjects();

        $this->assertCount(3, $subjects, sprintf('Expected subjects count is %s', 3));
    }

    public function testSubjectInsert()
    {
        /** @var SubjectInterface $subject */
        $subject = $this->sm->createSubject();
        $subject->setName('Fisica');
        $this->sm->updateSubject($subject);

        /** @var SubjectInterface[] $subjects */
        $subjects = $this->sm->findSubjects();
        $this->assertCount(4, $subjects, sprintf('Expected subjects count is %s', 4));
    }

    public function testSubjectUpdate()
    {
        /** @var SubjectInterface $subject */
        $subject = $this->sm->findSubjectBy(['id' => 1]);
        $subject->setName('Scienze');
        $this->sm->updateSubject($subject);
        $subject = $this->sm->findSubjectBy(['name' => 'Scienze']);

        $this->assertTrue('Scienze' === $subject->getName(), sprintf('Expected subject name is %s', 'Scienze'));
    }

    public function testSubjectDelete()
    {
        /** @var SubjectInterface $subject */
        $subject = $this->sm->findSubjectBy(['name' => 'Fisica']);
        $this->sm->deleteSubject($subject);
        /** @var SubjectInterface[] $subjects */
        $subjects = $this->sm->findSubjects();
        $this->assertCount(3, $subjects, sprintf('Expected subjects count is %s', 3));
    }
}
