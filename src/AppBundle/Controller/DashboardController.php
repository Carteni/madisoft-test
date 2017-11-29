<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\MarkInterface;
use AppBundle\Entity\Student;
use AppBundle\Entity\StudentInterface;
use AppBundle\Event\MailEvent;
use AppBundle\Event\MailEvents;
use AppBundle\Export\ExportDelegatingHandler;
use AppBundle\Form\Factory\FormFactory;
use AppBundle\Mailer\MailSubjectInterface;
use AppBundle\Mailer\SwiftMailerSubjectFactory;
use AppBundle\Model\MarkManagerInterface;
use AppBundle\Model\StudentManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class DashboardController extends Controller
{
    /**
     * @param \AppBundle\Model\StudentManagerInterface $sm
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(StudentManagerInterface $sm)
    {
        return $this->render(':dashboard:home.html.twig', [
            'students' => $sm->findStudents(['surname' => 'ASC']),
        ]);
    }

    /**
     * @param \AppBundle\Model\StudentManagerInterface $sm
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function summaryAction(StudentManagerInterface $sm)
    {
        return $this->render(':dashboard:summary.html.twig', [
            'students' => $sm->findStudentsWithMarksAverage(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request          $request
     * @param \AppBundle\Entity\Student                          $student
     * @param \AppBundle\Model\StudentManagerInterface           $studentManager
     * @param \AppBundle\Model\MarkManagerInterface              $markManager
     * @param \Symfony\Component\Translation\TranslatorInterface $trans
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function studentEditAction(
        Request $request,
        Student $student,
        StudentManagerInterface $studentManager,
        MarkManagerInterface $markManager,
        TranslatorInterface $trans
    ) {
        if (0 === count($student->getMarks())) {
            $student->addMark($markManager->createMark());
        }

        /** @var FormInterface $form */
        $form = $this->createStudentForm($student);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var StudentInterface $student */
            $student = $form->getData();

            /** @var MarkInterface $mark */
            foreach ($student->getMarks() as $mark) {
                if (empty($mark->getId())) {
                    $mark->setStudent($student);
                }
            }

            try {
                $studentManager->updateStudent($student);
                $this->addFlash('success', $trans->trans('app.flash.save_success'));
            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash('danger', $e->getMessage());
            }

            return $this->redirectToRoute('app_dashboard_student_edit', ['id' => $student->getId()]);
        }

        return $this->render(':dashboard:edit.html.twig', [
            'form' => $form->createView(),
            'student' => $student,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request          $request
     * @param \AppBundle\Model\StudentManagerInterface           $studentManager
     * @param \AppBundle\Model\MarkManagerInterface              $markManager
     * @param \Symfony\Component\Translation\TranslatorInterface $trans
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function studentNewAction(
        Request $request,
        StudentManagerInterface $studentManager,
        MarkManagerInterface $markManager,
        TranslatorInterface $trans
    ) {
        /** @var StudentInterface $student */
        $student = $studentManager->createStudent();
        $student->addMark($markManager->createMark());

        /** @var FormInterface $form */
        $form = $this->createStudentForm($student, ['mode' => 'new']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var StudentInterface $student */
            $student = $form->getData();

            try {
                $studentManager->updateStudent($student);
                $this->addFlash('success', $trans->trans('app.flash.save_success'));

                return $this->redirectToRoute('app_dashboard_student_edit', ['id' => $student->getId()]);
            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash('danger', $e->getMessage());
            }

            return $this->redirectToRoute('app_dashboard_student_new');
        }

        return $this->render(':dashboard:new.html.twig', [
            'form' => $form->createView(),
            'student' => $student,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Student                 $student
     * @param \AppBundle\Model\StudentManagerInterface  $studentManager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function studentSendMailRequestAction(
        Request $request,
        Student $student,
        StudentManagerInterface $studentManager
    ) {
        $studentManager->setStudentAverage($student);

        return $this->render(':dashboard:sendmail_request.html.twig', [
            'student' => $student,
            'ref' => $request->query->get('ref', 'app_dashboard_home'),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                   $request
     * @param \AppBundle\Entity\Student                                   $student
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param \AppBundle\Model\StudentManagerInterface                    $studentManager
     * @param \Symfony\Component\Translation\TranslatorInterface          $trans
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function studentSendMailAction(
        Request $request,
        Student $student,
        EventDispatcherInterface $dispatcher,
        StudentManagerInterface $studentManager,
        TranslatorInterface $trans
    ) {
        $studentManager->setStudentAverage($student);

        /** @var MailSubjectInterface $mailSubject */
        $mailSubject = SwiftMailerSubjectFactory::createFactory()
                                                ->makeMailSubject(
                                                    $student->getEmail(),
                                                    'myschool@school.com',
                                                                  '::email/alert.html.twig',
                                                    ['student' => $student]
                                                );

        $dispatcher->dispatch(MailEvents::SEND_EMAIL, new MailEvent($mailSubject));

        $this->addFlash('success', $trans->trans('app.flash.email_sent', ['%student%' => $student->getFullname()]));

        if ($request->query->get('ref', null)) {
            return $this->redirect($request->query->get('ref'));
        }

        return $this->redirectToRoute('app_home');
    }

    /**
     * @param \AppBundle\Controller\string              $format
     * @param \AppBundle\Export\ExportDelegatingHandler $exportHandler
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function studentReportAction(
        string $format,
        ExportDelegatingHandler $exportHandler
    ) {
        return $exportHandler->export($format, 'studentsWithAverage');
    }

    /**
     * @param \AppBundle\Entity\StudentInterface $student
     * @param array                              $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createStudentForm(
        StudentInterface $student,
        array $options = []
    ) {
        /** @var $formFactory FormFactory */
        $formFactory = $this->get('app.student.form.factory');

        /** @var FormInterface $form */
        $form = $formFactory->createForm($options);
        $form->setData($student);

        return $form;
    }
}
