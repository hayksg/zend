<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Application\Service\FormServiceInterface;
use Zend\I18n\Translator\TranslatorInterface;

class AdminController extends AbstractActionController
{
    private $entityManager;
    private $userRepository;
    private $formService;
    private $translator;

    public function __construct(
        EntityManagerInterface $entityManager,
        FormServiceInterface $formService,
        TranslatorInterface $translator
    ) {
        $this->entityManager  = $entityManager;
        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->formService    = $formService;
        $this->translator     = $translator;
    }

    public function indexAction()
    {
        $users = $this->userRepository->findAll();

        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'cnt'   => 0,
            'users' => $users,
        ]);
        return $viewModel;
    }

    public function editAction()
    {
        $id = intval($this->params()->fromRoute('id', 0));
        $user = $this->userRepository->find($id);

        if (! $user) {
            return $this->notFoundAction();
        }

        $form = $this->formService->getAnnotationForm($user);
        $form->setValidationGroup(['csrf', 'role']);

        $encryptedRole = $this->decryptAdmin($form->get('role')->getValue());

        $poz = strpos($encryptedRole, '_') + 1;
        $role = substr($encryptedRole, $poz);
        $form->get('role')->setValue($role);
        $form->get('submit')->setValue('Update');

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $user = $form->getData();
                $role = $user->getRole();
                $name = $user->getName();

                $this->editTheFieldRole($user, $name, $role);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $this->redirect()->toRoute('admin/admin');
            }
        }

        return [
            'id'   => $id,
            'form' => $form,
            'user' => $user,
        ];
    }

    public function deleteAction()
    {

        return [];
    }
}
