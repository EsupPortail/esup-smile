<?php


namespace Application\Application\Form\Inscription\Factory;

use Application\Application\Form\Inscription\InscriptionFieldset;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Entity\Inscription;
use Application\Form\Inscription\InscriptionHydrator;
use Application\Service\Inscription\InscriptionService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;
use UnicaenUtilisateur\Service\User\UserService;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

/**
 * Class InscriptionFieldsetFactory
 */
class InscriptionFieldsetFactory implements FactoryInterface
{
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return InscriptionFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        /** @var InscriptionFieldset $fieldset */
        $fieldset = new InscriptionFieldset("inscription");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
//        $fieldset->setEntityManager($entityManager);

        /** @var InscriptionService $entityService */
        $inscriptionService = $container->get("ServiceManager")->get(InscriptionService::class);
        /** @var CodeValidator $codeValidator */
        $codeValidator = $container->get(ValidatorPluginManager::class)->get(CodeValidator::class);
        $codeValidator->setEntityService($inscriptionService);
//        $fieldset->setCodeValidator($codeValidator);

        /** @var InscriptionHydrator $hydrator */
//        $hydrator = $container->get("HydratorManager")->get(InscriptionHydrator::class);
//        $fieldset->setHydrator($hydrator);
        $userService = $container->get("ServiceManager")->get(UserService::class);
        $user = $userService->getConnectedUser();

        if(isset($user)) {
            $inscription = $inscriptionService->findByUser($user);
        }else {
            $inscription = new Inscription();
        }
        $fieldset->setObject($inscription);

        return $fieldset;
    }
}