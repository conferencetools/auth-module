<?php

namespace ConferenceTools\Authentication\Controller;

use ConferenceTools\Authentication\Auth\Exception\AuthenticationFailed;
use ConferenceTools\Authentication\Form\LoginForm;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @method identity()
 */
class AuthController extends AbstractActionController
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
                    $this->identity();
                    return $this->redirect()->toRoute('attendance-admin');
                } catch (AuthenticationFailed $e) {
                    $this->flashMessenger()->addErrorMessage('The login details you provided were incorrect');
                }
            }
        }

        return new ViewModel(['form' => $form]);
    }
}