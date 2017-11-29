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

use AppBundle\Entity\StudentInterface;
use AppBundle\Model\StudentManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CSVExportStudentsAdapter.
 */
class CSVExportStudentsWithAverageDelegate extends AbstractCSVExportDelegate
{
    /** @var StudentManagerInterface */
    private $studentManager;

    /** @var SerializerInterface */
    private $serializer;

    /** @var FileStrategyContextBuilderInterface */
    private $fileStrategyContextBuilder;

    /**
     * CSVExportStudentsWithAverageDelegate constructor.
     *
     * @param \AppBundle\Model\StudentManagerInterface              $studentManager
     * @param \Symfony\Component\Serializer\SerializerInterface     $serializer
     * @param \AppBundle\Export\FileStrategyContextBuilderInterface $fileStrategyContextBuilder
     */
    public function __construct(
        StudentManagerInterface $studentManager,
        SerializerInterface $serializer,
        FileStrategyContextBuilderInterface $fileStrategyContextBuilder
    ) {
        $this->studentManager = $studentManager;
        $this->serializer = $serializer;
        $this->fileStrategyContextBuilder = $fileStrategyContextBuilder;
    }

    /**
     * @param string $format
     * @param string $key
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function export(
        $format,
        $key
    ) {
        /** @var StudentInterface[] */
        $students = $this->studentManager->findStudentsWithMarksAverage();

        /** @var array $dataSet */
        $dataSet = [];

        foreach ($students as $student) {
            $dataSet[] = [
                'id' => $student['id'],
                'name' => $student['name'],
                'surname' => $student['surname'],
                'average' => $student['average'] + 0,
            ];
        }

        unset($students); // avoids memory leaks.

        return $this->createFile($dataSet, $format);
    }

    /**
     * @param array  $dataSet
     * @param string $format
     *
     * @return Response
     */
    protected function createFile(
        array $dataSet,
        $format
    ) {
        $strategyContext = $this->fileStrategyContextBuilder->createStrategyContext('zip', [
            'fileName' => 'studentsWithAverage.zip',
            'attributes' => [
                'zipFiles' => ["students.$format" => $this->serializer->serialize($dataSet, 'csv')],
            ],
        ]);

        return $strategyContext->createFile();
    }

    protected function supportsKey($key)
    {
        return 'studentsWithAverage' === $key;
    }
}
