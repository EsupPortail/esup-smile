<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\TypeDiplomeFieldset;
use Application\Application\Form\Formation\TypeDiplomeHydrator;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Formation\TypeDiplomeService;
use  Application\Entity\TypeDiplome;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class TypeDiplomeFieldsetFactory
 */
class TypeDiplomeFieldsetFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeDiplomeFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeDiplomeFieldset $fieldset */
        $fieldset = new TypeDiplomeFieldset("typeDiplome");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $fieldset->setEntityManager($entityManager);

        /** @var TypeDiplomeHydrator $hydrator */
        $hydrator = $container->get("HydratorManager")->get(TypeDiplomeHydrator::class);
        $fieldset->setHydrator($hydrator);
        $fieldset->setObject(new TypeDiplome());


        /** @var TypeDiplomeService $entityService */
        $entityService = $container->get("ServiceManager")->get(TypeDiplomeService::class);
        /** @var CodeValidator $codeValidator */
        $codeValidator = $container->get(ValidatorPluginManager::class)->get(CodeValidator::class);
        $codeValidator->setEntityService($entityService);
        $fieldset->setCodeValidator($codeValidator);

        return $fieldset;
    }
}