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

use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractCSVExportDelegate.
 */
abstract class AbstractCSVExportDelegate implements ExportDelegateInterface
{
    /**
     * @param string $format
     * @param string $key
     *
     * @return bool
     */
    public function supports(
        $format,
        $key
    ) {
        return $this->supportsFormat($format) && $this->supportsKey($key);
    }

    /**
     * @param string $format
     * @param string $key
     *
     * @return Response
     */
    abstract public function export(
        $format,
        $key
    );

    /**
     * @param $format
     *
     * @return bool
     */
    protected function supportsFormat($format)
    {
        return 'csv' === $format;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    abstract protected function supportsKey($key);
}
