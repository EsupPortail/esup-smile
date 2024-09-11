<?php


namespace Application\Application\Misc;

use Laminas\View\Model\ViewModel;
use UnicaenApp\Service\EntityManagerAwareTrait;
use UnicaenApp\View\Helper\Messenger;

/**
 * @method \Laminas\Mvc\Controller\Plugin\Params|mixed params(string $param = null, mixed $default = null)
 */
trait RouterToolsTrait
{
    /************
     * Accés aux entités depuis la route
     ************/

    /** Récupération des entités depuis la route */
    use EntityManagerAwareTrait;

    /**
     * @param string $name nom du paramètre
     * @param mixed $default valeur par défaut
     * @return mixed
     */
    protected function getParamFromRoute($name, $default=null)
    {
        return $this->params()->fromRoute($name, $default);
    }

    /**
     * @param $title
     * @param $text
     * @return ViewModel
     */
    protected function renderError($title=null, $text=null){
        $vm = new ViewModel();
        $vm->setTemplate('application/default/probleme');
        $vm->setVariables([
            'title' => ($title) ?? "Une erreur est survenue",
            'text' => ($text) ?? "Une erreur est survenue lors de l'execution de l'action.",
        ]);
        return $vm;
    }

    /**
     * @param $title
     * @param $text
     * @return ViewModel
     */
    protected function renderActionSuccess($title=null, $text=null, $priority=Messenger::SUCCESS){
        $vm = new ViewModel();
        $vm->setTemplate('application/default/action-success');
        $vm->setVariables([
            'title' => ($title) ?? "Action terminée",
            'text' => ($text) ?? "L'action a été effecutée avec succés.",
            'priority' => $priority,
        ]);
        return $vm;
    }

    /**
     * @param $title
     * @param $text
     * @return ViewModel
     */
    protected function renderConfirmation($title=null, $text=null){
        var_dump("TODO");
//        $vm = new ViewModel();
//        $vm->setTemplate('application/default/probleme');
//        $vm->setVariables([
//            'title' => ($title) ?? "Une erreur est survenue",
//            'text' => ($text) ?? "Une erreur est survenue lors de l'execution de l'action.",
//        ]);
//        return $vm;
    }
}