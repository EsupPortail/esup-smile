<?php


namespace Application\Application\Form\Composante\Factory;

use Application\Application\Form\Composante\ComposanteFieldset;
use Application\Application\Form\Composante\ComposanteHydrator;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\Composante\ComposanteService;
use  Application\Entity\Composante;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;

/**
 * Class ComposanteFieldsetFactory
 */
class ComposanteFieldsetFactory implements FactoryInterface
{
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ComposanteFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ComposanteFieldset $fieldset */
        $fieldset = new ComposanteFieldset("composante");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $fieldset->setEntityManager($entityManager);

//        /** @var DoctrineObject $hydrator */
//        $hydrator = $container->get("HydratorManager")->get(DoctrineObject::class);
//        $fieldset->setHydrator($hydrator);

        /** @var ComposanteHydrator $hydrator */
        $hydrator = $container->get("HydratorManager")->get(ComposanteHydrator::class);
        $fieldset->setHydrator($hydrator);
        $fieldset->setObject(new Composante());


        /** @var ComposanteService $composanteService */
        $composanteService = $container->get("ServiceManager")->get(ComposanteService::class);
        /** @var CodeValidator $codeValidator */
        $codeValidator = $container->get(ValidatorPluginManager::class)->get(CodeValidator::class);
        $codeValidator->setEntityService($composanteService);
        $fieldset->setCodeValidator($codeValidator);

        return $fieldset;
    }
}