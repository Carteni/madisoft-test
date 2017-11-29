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

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Wamania\ZipStreamedResponseBundle\Response\ZipStreamedResponse;
use Wamania\ZipStreamedResponseBundle\Response\ZipStreamer\ZipStreamer;

/**
 * Class ZipStrategy.
 */
class ZipStrategy implements FileStrategyInterface
{
    /**
     * Creates a zip file.
     *
     * @param array $data
     *
     * @return Response
     */
    public function create(array $data)
    {
        $zipStreamer = new ZipStreamer($data['fileName']);

        $fileSystem = new Filesystem();

        foreach ($data['attributes']['zipFiles'] as $filenameInZip => $content) {
            if (!$fileSystem->exists($content) && is_string($content)) {
                $tmpFile = $fileSystem->tempnam(sys_get_temp_dir(), 'TMP_');
                $fileSystem->dumpFile($tmpFile, $content);
                $zipStreamer->add($tmpFile, $filenameInZip);
                $fileSystem->remove($tmpFile);
            } else {
                $zipStreamer->add($content, $filenameInZip);
            }
        }

        return new ZipStreamedResponse($zipStreamer);
    }
}
