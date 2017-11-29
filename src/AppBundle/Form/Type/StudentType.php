<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\StudentInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StudentType.
 */
class StudentType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * StudentType constructor.
     *
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder->add('name', null, [
            'label' => 'app.name',
        ])
                ->add('surname', null, [
                    'label' => 'app.surname',
                ])
                ->add('email', EmailType::class, [
                    'label' => 'app.email',
                ])
                ->add('marks', CollectionType::class, [
                    'label' => false,
                    'entry_type' => MarkType::class,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'allow_add' => true,
                ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use (
            $options
        ) {
            $data = $event->getData();

            if (isset($data['marks'])) {
                foreach ($data['marks'] as $key => $mark) {
                    if (0 === strlen(trim(implode('', $mark)))) {
                        unset($data['marks'][$key]);
                    }
                }

                if (empty($data['marks'])) {
                    unset($data['marks']);

                    /** @var StudentInterface $student */
                    $student = $event->getForm()
                                     ->getData();

                    // Clears the marks collection if exists only ob and empty mark.
                    if (1 === count($student->getMarks()) && empty($student->getMarks()
                                                                           ->get(0)
                                                                           ->getId())
                    ) {
                        $student->removeAllMarks();
                    }

                    $event->getForm()
                          ->setData($student);
                }
            }

            $event->setData($data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => $this->class,
                                   'csrf_token_id' => 'student',
                                   'attr' => [
                                       'novalidate' => 'novalidate',
                                   ],
                                   'mode' => 'edit',
                               ]);
    }
}
