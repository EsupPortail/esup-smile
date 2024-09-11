<?php


namespace Application\Application\Form\Formation\Factory;

use Application\Application\Form\Formation\FormationFieldset;
use Application\Application\Form\Formation\FormationHydrator;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\Formation\FormationService;
use  Application\Entity\Formation;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class FormationFieldsetFactory
 */
class FormationFieldsetFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return FormationFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var FormationFieldset $fieldset */
        $fieldset = new FormationFieldset("formation");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $fieldset->setEntityManager($entityManager);

        /** @var FormationHydrator $hydrator */
        $hydrator = $container->get("HydratorManager")->get(FormationHydrator::class);
        $fieldset->setHydrator($hydrator);
        $fieldset->setObject(new Formation());


        /** @var FormationService $entityService */
        $entityService = $container->get("ServiceManager")->get(FormationService::class);
        /** @var CodeValidator $codeValidator */
        $codeValidator = $container->get(ValidatorPluginManager::class)->get(CodeValidator::class);
        $codeValidator->setEntityService($entityService);
        $fieldset->setCodeValidator($codeValidator);

        return $fieldset;
    }
}