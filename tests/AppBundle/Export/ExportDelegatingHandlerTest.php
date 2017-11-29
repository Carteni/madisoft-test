<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Export;

use AppBundle\Export\CSVExportStudentsWithAverageDelegate;
use AppBundle\Export\ExportDelegatingHandler;
use AppBundle\Export\ExportDelegatingHandlerInterface;
use AppBundle\Export\FileStrategyContext;
use AppBundle\Export\FileStrategyContextBuilderInterface;
use AppBundle\Model\StudentManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Tests\AppBundle\TestStudent;

/**
 * Class ExportDelegatingHandlerTest.
 */
class ExportDelegatingHandlerTest extends TestCase
{
    /** @var ExportDelegatingHandlerInterface */
    private $exporter;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $studentManager;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $serializer;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $strategyBuilder;

    protected function setUp()
    {
        $this->studentManager = $this->getMockBuilder(StudentManagerInterface::class)
                                     ->getMock();

        $this->serializer = $this->getMockBuilder(SerializerInterface::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();

        $this->strategyBuilder = $this->getMockBuilder(FileStrategyContextBuilderInterface::class)
                                      ->getMock();

        $this->exporter = new ExportDelegatingHandler();
        $this->exporter->addDelegate(new CSVExportStudentsWithAverageDelegate(
            $this->studentManager,
            $this->serializer,
                                                                              $this->strategyBuilder
        ));

        parent::setUp();
    }

    /*public function testIfFormatAndKeyAreSupported ()
    {
        $this->assertTrue($this->exporter->supports('csv', 'studentsWithAverage'),
                          sprintf('Format expected: %s. Key expected %s', 'csv', 'studentsWithAverage'));

    }*/

    protected function tearDown()
    {
        $this->exporter = null;
        $this->studentManager = null;
        $this->serializer = null;
        $this->strategyBuilder = null;

        parent::tearDown();
    }

    public function testExport()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject */
        $strategyContext = $this->getMockBuilder(FileStrategyContext::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->studentManager->expects($this->once())
                             ->method('findStudentsWithMarksAverage')
                             ->will($this->returnValue([TestStudent::createDummy()]));

        $this->strategyBuilder->expects($this->once())
                              ->method('createStrategyContext')
                              ->will($this->returnValue($strategyContext));

        $strategyContext->expects($this->once())
                        ->method('createFile');

        $this->exporter->export('csv', 'studentsWithAverage');
    }
}
