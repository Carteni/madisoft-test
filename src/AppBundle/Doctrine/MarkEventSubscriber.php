<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Doctrine;

use AppBundle\Entity\MarkInterface;
use AppBundle\Entity\StudentInterface;
use AppBundle\Event\MailEvent;
use AppBundle\Event\MailEvents;
use AppBundle\Mailer\MailManagerInterface;
use AppBundle\Mailer\MailSubjectInterface;
use AppBundle\Mailer\SwiftMailerSubjectFactory;
use AppBundle\Model\StudentManagerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class MarkEventSubscriber.
 */
class MarkEventSubscriber implements EventSubscriber
{
    /** @var MailManagerInterface */
    private $mailManager;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var Container */
    private $container;

    /**
     * MarkEventSubscriber constructor.
     *
     * @param \AppBundle\Mailer\MailManagerInterface                      $mailManager
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param \Symfony\Component\DependencyInjection\Container            $container
     */
    public function __construct(
        MailManagerInterface $mailManager,
        EventDispatcherInterface $dispatcher,
        Container $container
    ) {
        $this->mailManager = $mailManager;
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
            'postPersist',
            'postUpdate',
        ];
    }

    /**
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var MarkInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof MarkInterface) {
            return;
        }

        $date = new \DateTime();
        $entity->setCreatedAt($date);
        $entity->setLastModified($date);
    }

    /**
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        /** @var MarkInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof MarkInterface) {
            return;
        }

        $entity->setLastModified(new \DateTime());
        $this->recomputeChangeSet($args->getObjectManager(), $entity);
    }

    /**
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        /** @var MarkInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof MarkInterface) {
            return;
        }

        $this->sendEmail($entity);
    }

    /**
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        /** @var MarkInterface $entity */
        $entity = $args->getObject();

        if (!$entity instanceof MarkInterface) {
            return;
        }

        $this->sendEmail($entity);
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     * @param \AppBundle\Entity\MarkInterface            $mark
     */
    private function recomputeChangeSet(
        ObjectManager $om,
        MarkInterface $mark
    ) {
        $meta = $om->getClassMetadata(get_class($mark));

        $om->getUnitOfWork()
           ->recomputeSingleEntityChangeSet($meta, $mark);
    }

    /**
     * @param \AppBundle\Entity\MarkInterface $mark
     */
    private function sendEmail(MarkInterface $mark)
    {
        /** @var StudentInterface $student */
        $student = $mark->getStudent();

        /** @var StudentManagerInterface $studentManager */
        $studentManager = $this->container->get(StudentManager::class);

        $studentManager->setStudentAverage($student);

        /** @var MailSubjectInterface $mailSubject */
        $mailSubject = SwiftMailerSubjectFactory::createFactory()
                                                ->makeMailSubject(
                                                    $student->getEmail(),
                                                    'myschool@school.com',
                                                                  '::email/mark.html.twig',
                                                    ['mark' => $mark]
                                                );

        $this->dispatcher->dispatch(MailEvents::SEND_EMAIL, new MailEvent($mailSubject));
    }
}
