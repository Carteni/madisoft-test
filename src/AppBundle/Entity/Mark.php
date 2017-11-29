<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Mark.
 *
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarkRepository")
 */
class Mark implements MarkInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modified", type="datetime")
     */
    protected $lastModified;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="marks", fetch="EAGER")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    protected $student;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="marks", fetch="EAGER")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     *
     * @Assert\NotBlank(message="app.blank")
     */
    protected $subject;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="app.blank")
     * @Assert\Regex(
     *     pattern="/^[0-9]{1,2}$/",
     *     message="app.invalid"
     * )
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "app.score.short",
     *      maxMessage = "app.score.long"
     * )
     */
    protected $score;

    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     * @Assert\Length(
     *     max=100,
     *     maxMessage="app.long"
     * )
     */
    protected $notes;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return MarkInterface
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get lastModified.
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set lastModified.
     *
     * @param \DateTime $lastModified
     *
     * @return MarkInterface
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get score.
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set score.
     *
     * @param int $score
     *
     * @return MarkInterface
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get notes.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set notes.
     *
     * @param string $notes
     *
     * @return MarkInterface
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get student.
     *
     * @return \AppBundle\Entity\StudentInterface
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param \AppBundle\Entity\StudentInterface $student
     *
     * @return MarkInterface
     */
    public function setStudent(StudentInterface $student)
    {
        $this->student = $student;
        $student->addMark($this);

        return $this;
    }

    /**
     * Get subject.
     *
     * @return \AppBundle\Entity\SubjectInterface
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject.
     *
     * @param \AppBundle\Entity\SubjectInterface $subject
     *
     * @return MarkInterface
     */
    public function setSubject(SubjectInterface $subject = null)
    {
        $this->subject = $subject;
        if (!empty($subject)) {
            $subject->addMark($this);
        }

        return $this;
    }
}
