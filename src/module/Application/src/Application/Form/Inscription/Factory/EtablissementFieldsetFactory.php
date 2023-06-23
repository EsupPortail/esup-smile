<?php


namespace Application\Application\Form\Inscription\Factory;

use Application\Application\Form\Inscription\EtablissementFieldset;
use Application\Application\Form\Inscription\InscriptionFieldset;
use Application\Application\Form\Misc\CodeValidator\CodeValidator;
use Application\Application\Service\Etablissement\EtablissementServiceAwareTrait;
use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Application\Entity\Etablissement;
use Application\Entity\Inscription;
use Application\Form\Inscription\InscriptionHydrator;
use Application\Service\Etablissement\EtablissementService;
use Application\Service\Inscription\InscriptionService;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\ValidatorPluginManager;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\User\UserService;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

/**
 * Class InscriptionFieldsetFactory
 */
class EtablissementFieldsetFactory implements FactoryInterface
{
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use EtablissementServiceAwareTrait;
    /**
     * Create fieldset
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return EtablissementFieldset|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        /** @var EtablissementFieldset $fieldset */
        $fieldset = new EtablissementFieldset("etablissement");

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        /** @var InscriptionService $entityService */
        $etablissementService = $container->get("ServiceManager")->get(EtablissementService::class);
        $inscriptionService = $container->get("ServiceManager")->get(InscriptionService::class);
        /** @var CodeValidator $codeValidator */
        $codeValidator = $container->get(ValidatorPluginManager::class)->get(CodeValidator::class);
        $codeValidator->setEntityService($etablissementService);

        /** @var InscriptionHydrator $hydrator */
        $userService = $container->get("ServiceManager")->get(UserService::class);
        $user = $userService->getConnectedUser();

        /**
         * @var Inscription $inscription
         */
        if(isset($user)) {
            $inscription = $inscriptionService->findByUser($user);
            $etablissement = $inscription->getEtablissement();
        }else {
            $etablissement = new Etablissement();
        }
        $fieldset->setObject($etablissement);

        return $fieldset;
    }
}