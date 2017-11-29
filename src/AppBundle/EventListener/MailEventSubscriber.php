<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventListener;

use AppBundle\Event\MailEvent;
use AppBundle\Event\MailEvents;
use AppBundle\Logger\StudentLogger;
use AppBundle\Mailer\MailManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MailEventSubscriber.
 */
class MailEventSubscriber implements EventSubscriberInterface
{
    /** @var MailManagerInterface */
    private $mailManager;

    /** @var StudentLogger */
    private $logger;

    /**
     * MailEventSubscriber constructor.
     *
     * @param \AppBundle\Mailer\MailManagerInterface $mailManager
     * @param \AppBundle\Logger\StudentLogger        $logger
     */
    public function __construct(
        MailManagerInterface $mailManager,
        StudentLogger $logger
    ) {
        $this->mailManager = $mailManager;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            MailEvents::SEND_EMAIL => 'sendMail',
        ];
    }

    /**
     * @param \AppBundle\Event\MailEvent $event
     */
    public function sendMail(MailEvent $event)
    {
        if ($event->isHtml()) {
            $this->mailManager->sendEmailHTMLMessage($event->getMailSubject());
        } else {
            $this->mailManager->sendEmailMessage($event->getMailSubject());
        }

        // Sends log.
        $this->logger->info('Email inviata a '.$event->getMailSubject()
                                                     ->getTo());
    }
}
