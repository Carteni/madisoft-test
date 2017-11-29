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
 * Class SwiftMailerSubjectFactory.
 */
class SwiftMailerSubjectFactory implements SubjectFactoryInterface
{
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return SubjectFactoryInterface
     */
    public static function createFactory()
    {
        if (null === self::$instance) {
            $c = __CLASS__;
            self::$instance = new $c();
        }

        return self::$instance;
    }

    /**
     * {@inheritdoc}
     */
    public function makeMailSubject(
        $to,
        $from,
        $template,
        $context = []
    ) {
        $swiftMailSubject = new SwiftMailerSubject();
        $swiftMailSubject->setTo($to);
        $swiftMailSubject->setFrom($from);
        $swiftMailSubject->setTemplate($template);
        $swiftMailSubject->setContext($context);

        return $swiftMailSubject;
    }
}
