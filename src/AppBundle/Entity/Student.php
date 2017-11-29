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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Student.
 *
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student extends Person implements StudentInterface
{
    /**
     * @var ArrayCollection
     *
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Mark", mappedBy="student", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"lastModified" = "DESC", "subject" = "ASC"})
     */
    protected $marks;

    /**
     * @var float
     */
    protected $average;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->marks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName().' '.$this->getSurname();
    }

    /**
     * @return float
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * @param $average
     *
     * @return StudentInterface
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * @param \AppBundle\Entity\MarkInterface $mark
     *
     * @return StudentInterface
     */
    public function addMark(MarkInterface $mark)
    {
        if ($this->marks->contains($mark)) {
            return;
        }

        $this->marks->add($mark);
        $mark->setStudent($this);

        return $this;
    }

    /**
     * Remove mark.
     *
     * @param MarkInterface $mark
     */
    public function removeMark(MarkInterface $mark)
    {
        if (!$this->marks->contains($mark)) {
            return;
        }

        $this->marks->removeElement($mark);
    }

    /**
     * Remove all marks.
     *
     * @return StudentInterface
     */
    public function removeAllMarks()
    {
        $this->marks = new ArrayCollection();
    }

    /**
     * Get marks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarks()
    {
        return $this->marks;
    }
}
