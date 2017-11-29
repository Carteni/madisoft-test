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

use AppBundle\Entity\Mark;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MarkFormType.
 */
class MarkType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ) {
        $builder->add('subject', EntityType::class, [
            'class' => 'AppBundle\Entity\Subject',
            'choice_label' => 'name',
            'label' => 'app.subject',
            'placeholder' => 'app.select_subject',
        ])
                ->add('score', null, [
                    'label' => 'app.mark',
                ])
                ->add('notes', TextareaType::class, [
                    'label' => 'app.notes',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'data_class' => Mark::class,
                               ]);
    }
}
