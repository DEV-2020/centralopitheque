<?php

namespace App\Form;

use App\Entity\Spectacle;
use App\Repository\SpectacleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopSpectaclesType extends AbstractType
{
    private $spectacleRepository;

    public function __construct(SpectacleRepository $spectacleRepository)
    {
        $this->spectacleRepository = $spectacleRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('spectacles', CollectionType::class, [
                'entry_type' => IntegerType::class,
                'allow_add' => true,
            ])
        ;

        $builder->get('spectacles')
            ->addModelTransformer(new CallbackTransformer(
                function (?Spectacle $spectacle) {
                    if (null === $spectacle) {
                        return null;
                    }
                    return $spectacle->getId();
                },
                function (array $ids) {
                    return $this->spectacleRepository->findBy(['id' => $ids]);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
