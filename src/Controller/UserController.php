<?php

namespace ConferenceTools\Authentication\Controller;

use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPassword;
use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPermissions;
use ConferenceTools\Authentication\Domain\User\Command\CreateNewUser;
use ConferenceTools\Authentication\Domain\User\HashedPassword;
use ConferenceTools\Authentication\Domain\User\ReadModel\User;
use ConferenceTools\Authentication\Form\ChangePasswordForm;
use ConferenceTools\Authentication\Form\NewUserForm;
use ConferenceTools\Authentication\Form\UserPrivilegesForm;
use Doctrine\Common\Collections\Criteria;
use Zend\View\Model\ViewModel;

class UserController extends AppController
{
    /** @var array */
    private $permissions;

    public function __construct(array $permissions)
    {
        $this->permissions = $permissions;
    }

    public function indexAction()
    {
        $users = $this->repository(User::class)->matching(Criteria::create());
        return new ViewModel(['users' => $users]);
    }

    public function addUserAction()
    {
        $form = $this->form(NewUserForm::class);

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

        return new ViewModel(['form' => $form, 'blockHeader' => 'Add user']);
    }

    public function updatePermissionsAction()
    {
        $form = $this->form(UserPrivilegesForm::class, ['permissions' => $this->permissions]);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $user = $this->params()->fromRoute('user');
                $command = new ChangeUserPermissions(
                    $user,
                    (array) $data['permissions']
                );

                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('User permissions updated');
                $this->redirect()->toRoute('authentication/users');
            }
        }

        return new ViewModel(['form' => $form, 'blockHeader' => 'Change user permissions']);
    }

    public function changePasswordAction()
    {
        $form = $this->form(ChangePasswordForm::class);

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
                return $this->userRedirect($this->identity()->getIdentityData());
            }
        }

        return new ViewModel(['form' => $form]);
    }
}