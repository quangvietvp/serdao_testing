<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\DBAL\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Alias;

class UserController extends AbstractController
{
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Listing page
     * @param None
     * @return mixed
     */
    #[Route('/user', name: 'user_index', methods: ['GET'])]
    public function index() {
        $users = $this->userRepository->findAll();
        return $this->render('user.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Creating user page
     * @param None
     * @return mixed
     */
    #[Route('/user/create', methods: ['GET'])]
    public function create() {
        return $this->render('create.html.twig', [
            'pageTitle' => 'Create user'
        ]);
    }

    /**
     * Storing data to database. Accept POST method
     * @param Request $request
     * @return mixed
     */
    #[Route('/user/create', name: 'create_user_post', methods: ['POST'])]
    public function store(Request $request) {
        $userData = [
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'address' => $request->get('address')
        ];
        $this->userRepository->save($userData);
        return $this->redirectToRoute('user_index');
    }

    /**
     * Remove user by id
     * @param Request $request
     * @return mixed
     */
    #[Route('/user/remove', name: 'user_remove', methods: ['GET'])]
    public function delete(Request $request) {
        $this->userRepository->remove($request->get('id'));
        return $this->redirectToRoute('user_index');
    }
}