<?php

namespace ConferenceTools\Authentication\Controller;

use ConferenceTools\Authentication\Auth\Exception\AuthenticationFailed;
use ConferenceTools\Authentication\Form\LoginForm;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;

class AuthController extends AppController
{
    public function authAction()
    {
        $form = $this->form(LoginForm::class);

        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                try {
                    return $this->userRedirect($this->identity()->getIdentityData());
                } catch (AuthenticationFailed $e) {
                    $this->flashMessenger()->addErrorMessage('The login details you provided were incorrect');
                }
            }
        }

        return new ViewModel(['form' => $form]);
    }
}