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
}
