<?php

namespace Message\Controller;

use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Message\Entity\Db\Message;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Message\Service\Message\MessageServiceAwareTrait;
use UnicaenMail\Service\Mail\MailServiceAwareTrait;
use UnicaenUtilisateur\Entity\Db\RoleInterface;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class MessageController extends AbstractActionController {
    use UserServiceAwareTrait;
    use InscriptionServiceAwareTrait;
    use MailServiceAwareTrait;
    use MessageServiceAwareTrait;

    const ADD_MESSAGE_ACTION = "addMessage";

    public function addMessageAction()
    {
        if($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $user = $this->getUserService()->getConnectedUser();
            $uuid = $data['inscriptionUuid'];
            $inscription = $this->getInscriptionService()->findOneBy(['uuid' => $uuid]);
            if($inscription == null) {
                return $this->redirect()->toRoute('gestion');
            }
            $inscriptionUser = $inscription->getUser();
            // if checkbox is checked, send mail
            if(isset($data['sendMail'])) {
                $mail = $this->getMailService()->sendMail(
                    $this->getMailReceiver($user, $inscriptionUser),
                    'SMILE - Nouveau message',
                    $data['content']
                );
                $this->getMailService()->update($mail);
            }

            $message = new Message();
            $message->setInscription($inscription);
            $message->setSender($user);
            $message->setReceiver($inscriptionUser);
            $message->setContent($data['content']);
            $this->getMessageService()->addMessage($message);

            $path = $this->getRequest()->getHeaders('Referer')->uri()->getPath();
            return $this->redirect()->toUrl($path);
        }
        else {
            return $this->redirect()->toRoute('gestion');
        }
    }

    /**
     * @param User $user
     * @param User $inscriptionUser
     *
     * @return string|string[]
     */
    private function getMailReceiver(User $user, User $inscriptionUser): array|string
    {
        $mails = $inscriptionUser->getEmail();
        if($user === $inscriptionUser) {
            $roleGestionnaire = $this->getUserService()->getRoleService()->findByRoleId('gestionnaire');
            $gestionnaire = $this->getUserService()->findByRole($roleGestionnaire);
            $mails = [];
            foreach($gestionnaire as $g) {
                $mails[] = $g->getEmail();
            }
        }
        return $mails;
    }
}