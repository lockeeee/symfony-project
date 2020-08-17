<?php

namespace App\Controller;

use App\Model\User;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @param UserService $userService
     * @param Request     $request
     *
     * @return RedirectResponse|Response
     * @Route("/user-list", name="list")
     */
    public function indexAction(UserService $userService, Request $request)
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect("/");
        }

        $sort = $request->get('sort');
        $sortOrder = $request->get('order', 'asc');

        return $this->render(
            'user/listing.html.twig',
            [
                'users' => $userService->showUsers($sort, $sortOrder)
            ]
        );
    }

    /**
     * @param Request     $request
     * @param UserService $userService
     *
     * @return RedirectResponse|Response
     * @Route("/add-user", name="add_user")
     */
    public function addAction(Request $request, UserService $userService)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $user = new User(
                    NULL,
                    $request->get('name'),
                    $request->get('surname'),
                    $request->get('mail'),
                    $request->get('pnumber')
                );
                $userService->createUser($user);
                $this->addFlash('success', 'Użytkownik został dodany!');

                return $this->redirectToRoute('list');
            } catch (Exception $exception) {
                echo $exception->getMessage();
            }
        }

        return $this->render('user/add.html.twig');
    }

    /**
     * @param UserService $userService
     * @param int         $id
     *
     * @return Response
     * @Route("/show-user/{id}", name="show_user")
     */
    public function showAction(UserService $userService, int $id): Response
    {
        return $this->render(
            'user/user.html.twig',
            [
                'user' => $userService->userData($id)
            ]
        );
    }

    /**
     * @param UserService $userService
     * @param int         $id
     *
     * @return RedirectResponse
     * @Route("/delete-user/{id}", name="delete_user")
     */
    public function deleteAction(UserService $userService, int $id): RedirectResponse
    {
        $userService->deleteUser($id);
        $this->addFlash('success', 'Użytkownik pomyślnie usunięty!');

        return $this->redirectToRoute('list');
    }

    /**
     * @param UserService $userService
     * @param int         $id
     *
     * @return Response
     * @Route("/edit-user/{id}", name="edit_user")
     */
    public function editAction(UserService $userService, int $id): Response
    {
        return $this->render(
            'user/edit.html.twig',
            [
                'user' => $userService->userData($id)
            ]
        );
    }

    /**
     * @param UserService $userService
     * @param Request     $request
     *
     * @return RedirectResponse|Response
     * @Route("/update-user", name="update_user")
     */
    public function updateAction(Request $request, UserService $userService)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $user = new User(
                    $request->get('id'),
                    $request->get('name'),
                    $request->get('surname'),
                    $request->get('mail'),
                    $request->get('pnumber')
                );
                $userService->updateUser($user);
                $this->addFlash('success', 'Użytkownik pomyślnie zaktualizowany!');

                return $this->redirectToRoute('list');
            } catch(Exception $exception) {
                echo $exception->getMessage();
            }
        }

        return $this->render(
            'user/edit.html.twig',
            [
                'user' => $user
            ]
        );
    }

    /**
     * @return Response
     * @Route("/", name="homepage")
     */
    public function homePage(): Response
    {
        return $this->render('user/home.html.twig');
    }
}