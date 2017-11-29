<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Export;

/**
 * Class ExportDelegatingHandler.
 */
class ExportDelegatingHandler implements ExportDelegatingHandlerInterface
{
    /** @var array */
    private $delegates;

    /**
     * ExportDelegatingHandler constructor.
     *
     * @param array $delegates
     */
    public function __construct(array $delegates = [])
    {
        $this->delegates = [];

        /** @var ExportDelegateInterface $delegate */
        foreach ($delegates as $delegate) {
            $this->addDelegate($delegate);
        }
    }

    /**
     * @param \AppBundle\Export\ExportDelegateInterface $delegate
     */
    public function addDelegate(ExportDelegateInterface $delegate)
    {
        if (array_key_exists(spl_object_hash($delegate), $this->delegates)) {
            return;
        }

        $this->delegates[spl_object_hash($delegate)] = $delegate;
    }

    /**
     * @param string $format
     * @param string $key
     *
     * @return \Symfony\Component\BrowserKit\Response|void
     */
    public function export(
        $format,
        $key
    ) {
        /** @var ExportDelegateInterface $delegate */
        foreach ($this->delegates as $delegate) {
            if ($delegate->supports($format, $key)) {
                return $delegate->export($format, $key);
            }
        }
    }
}
