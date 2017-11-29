<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Mailer;

/**
 * Class SwiftMailerManager.
 */
class SwiftMailerManager implements MailManagerInterface
{
    /** @var \Swift_Mailer */
    protected $mailer;

    /** @var \Twig_Environment */
    protected $templating;

    /**
     * SwiftMailerManager constructor.
     *
     * @param \Swift_Mailer     $mailer
     * @param \Twig_Environment $templating
     */
    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $templating
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param \AppBundle\Mailer\MailSubjectInterface $mailSubject
     */
    public function sendEmailMessage(MailSubjectInterface $mailSubject)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($this->templating->render(
            $mailSubject->getTemplate(),
                                                                      $mailSubject->getContext()
        )));
        $subject = array_shift($renderedLines);
        $body = implode("\n", $renderedLines);

        $message = (new \Swift_Message())->setSubject($subject)
                                         ->setFrom($mailSubject->getFrom())
                                         ->setTo($mailSubject->getTo())
                                         ->setBody($body);

        $this->mailer->send($message);
    }

    /**
     * @param \AppBundle\Mailer\MailSubjectInterface $mailSubject
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function sendEmailHTMLMessage(MailSubjectInterface $mailSubject)
    {
        $template = $this->templating->load($mailSubject->getTemplate());
        $context = $mailSubject->getContext();
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);

        $htmlBody = '';

        if ($template->hasBlock('body_html', $context)) {
            $htmlBody = $template->renderBlock('body_html', $context);
        }

        $message = (new \Swift_Message())->setSubject($subject)
                                         ->setFrom($mailSubject->getFrom())
                                         ->setTo($mailSubject->getTo());

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                    ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }
}
