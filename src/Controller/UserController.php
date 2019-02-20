<?php

namespace ConferenceTools\Authentication\Controller;

use ConferenceTools\Authentication\Auth\Identity;
use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPassword;
use ConferenceTools\Authentication\Domain\User\Command\CreateNewUser;
use ConferenceTools\Authentication\Domain\User\HashedPassword;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use ConferenceTools\Authentication\Form\ChangePasswordForm;
use ConferenceTools\Authentication\Form\NewUserForm;
use Doctrine\Common\Collections\Criteria;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\PluginManagerInterface;
use Zend\View\Model\ViewModel;
use Phactor\ReadModel\Repository;
use Phactor\Zend\ControllerPlugin\MessageBus;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;

/**
 * @method MessageBus messageBus()
 * @method Repository repository(string $className)
 * @method FlashMessenger flashMessenger()
 * @method Identity identity()
 */
class UserController extends AbstractActionController
{
    /** @var AbstractPluginManager  */
    private $formElementManager;

    public function __construct(PluginManagerInterface $formElementManager)
    {
        $this->formElementManager = $formElementManager;
    }

    public function indexAction()
    {
        $users = $this->repository(User::class)->matching(Criteria::create());
        return new ViewModel(['users' => $users]);
    }

    public function addUserAction()
    {
        $form = $this->formElementManager->get(NewUserForm::class);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $command = new CreateNewUser(
                    $data['username'],
                    new HashedPassword($data['password'])
                );

                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('User created');
                $this->redirect()->toRoute('authentication/users');
            }
        }

        return new ViewModel(['form' => $form]);
    }

    public function changePasswordAction()
    {
        $form = $this->formElementManager->get(ChangePasswordForm::class);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $command = new ChangeUserPassword(
                    $this->identity()->getIdentityData()->getUsername(),
                    new HashedPassword($data['password'])
                );

                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Password changed');
                $this->redirect()->toRoute('attendance-admin');
            }
        }

        return new ViewModel(['form' => $form]);
    }
}