<?php

namespace App\Controller;

use App\Model\RegisteredUser;
use App\Service\RegisteredUserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisteredUserController extends AbstractController
{
    /**
     * @param Request               $request
     * @param RegisteredUserService $registeredUserService
     *
     * @return RedirectResponse|Response
     * @Route("/register-done", name="register")
     */
    public function registerAction(Request $request, RegisteredUserService $registeredUserService)
    {
        if ($request->getMethod() == 'POST') {
            try{
                $registeredUser = new RegisteredUser(
                    NULL,
                    $request->get('name'),
                    $request->get('surname'),
                    $request->get('mail'),
                    $request->get('login'),
                    $request->get('password')
                );
                $registeredUserService->userRegistration($registeredUser);
                $this->addFlash('success', 'Rejestracja przebiegła pomyślnie! Możesz się zalogować!');

                return $this->redirectToRoute('homepage');
            } catch (Exception $exception) {
                echo $exception->getMessage();
            }
        }

        return $this->render('user/home.html.twig');
    }
}