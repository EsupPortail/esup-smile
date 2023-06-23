<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\TypeFormationFieldset;
use Application\Application\Form\Formation\TypeFormationHydrator;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\Composante\ComposanteService;
use Application\Application\Service\Formation\TypeFormationService;
use  Application\Entity\TypeFormation;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class TypeFormationFieldsetFactory
 */
class TypeFormationFieldsetFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return TypeFormationFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var TypeFormationFieldset $fieldset */
        $fieldset = new TypeFormationFieldset("typeFormation");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $fieldset->setEntityManager($entityManager);

        /** @var TypeFormationHydrator $hydrator */
        $hydrator = $container->get("HydratorManager")->get(TypeFormationHydrator::class);
        $fieldset->setHydrator($hydrator);
        $fieldset->setObject(new TypeFormation());


        /** @var TypeFormationService $entityService */
        $entityService = $container->get("ServiceManager")->get(TypeFormationService::class);
        /** @var CodeValidator $codeValidator */
        $codeValidator = $container->get(ValidatorPluginManager::class)->get(CodeValidator::class);
        $codeValidator->setEntityService($entityService);
        $fieldset->setCodeValidator($codeValidator);

        return $fieldset;
    }
}