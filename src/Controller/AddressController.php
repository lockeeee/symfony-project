<?php

namespace App\Controller;

use App\Model\Address;
use App\Service\AddressService;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
     * @param AddressService $addressService
     * @param Request        $request
     *
     * @return Response
     * @Route("/address-list", name="address_list")
     */

    public function indexAction(AddressService $addressService, Request $request): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect("/");
        }

        $sort = $request->get('sort');
        $sortOrder = $request->get('order', 'asc');

        return $this->render(
            'user/addresses.html.twig',
            [
                'address' => $addressService->showAddresses($sort, $sortOrder)
            ]
        );
    }

    /**
     * @param AddressService $addressService
     * @param Request        $request
     * @param UserService    $userService
     *
     * @return RedirectResponse|Response
     * @Route("/add-address", name="add_address")
     */

    public function addAction(AddressService $addressService, Request $request, UserService $userService)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $address = new Address(
                    NULL,
                    $request->get('user_id'),
                    $request->get('street'),
                    $request->get('postnumber'),
                    $request->get('city'),
                    $request->get('country'),
                    $request->get('user')
                );
                $addressService->createAddress($address);
                $this->addFlash('success', 'Adres został dodany!');

                return $this->redirectToRoute('address_list');
            } catch(Exception $exception) {
                $this->addFlash('success', $exception->getMessage());
            }
        }

        return $this->render(
            'user/addaddress.html.twig',
            [
                'records' => $userService->showUsersForAssign()
            ]
        );
    }

    /**
     * @param AddressService $addressService
     * @param int            $id
     *
     * @return RedirectResponse
     * @Route("/delete-address/{id}", name="delete_address")
     */

    public function deleteAction(AddressService $addressService, int $id): RedirectResponse
    {
        $addressService->deleteAddress($id);
        $this->addFlash('success', 'Adres pomyślnie usunięty!');

        return $this->redirectToRoute('address_list');
    }

    /**
     * @param AddressService $addressService
     * @param int            $id
     * @param UserService    $userService
     *
     * @return Response
     * @Route("/edit-address/{id}", name="edit_address")
     */

    public function editAction(AddressService $addressService, int $id, UserService $userService): Response
    {
        return $this->render(
            'user/editaddress.html.twig',
            [
                'user' => $addressService->addressData($id),
                'man' => $userService->showUsers()
            ]
        );
    }

    /**
     * @param AddressService $addressService
     * @param Request        $request
     * @param UserService    $userService
     *
     * @return RedirectResponse|Response
     * @Route("/update-address", name="update_address")
     */

    public function updateAction(
        AddressService $addressService,
        Request $request,
        UserService $userService
    ): RedirectResponse
    {
        if ($request->getMethod() == 'POST') {
            try {
                $address = new Address(
                    $request->get('id'),
                    $request->get('user_id'),
                    $request->get('street'),
                    $request->get('postnumber'),
                    $request->get('city'),
                    $request->get('country'),
                    NULL
                );
                $addressService->updateAddress($address);
                $this->addFlash('success', 'Adres pomyślnie zaktualizowany!');

                return $this->redirectToRoute('address_list');
            } catch(Exception $exception) {
                $this->addFlash('success', $exception->getMessage());
            }
        }

        return $this->render(
            'user/editaddress.html.twig',
            [
                'user' => $address,
                'man' => $userService->showUsers()
            ]
        );
    }

    /**
     * @param UserService $userService
     * @param int         $id
     *
     * @return Response
     * @Route("/assign-user/{id}", name="assign_user")
     */

    public function showAction(UserService $userService, int $id): Response
    {
        return $this->render(
            'user/assign.html.twig',
            [
                'records' => $userService->showUsersForAssign(),
                'address_id' => $id
            ]
        );
    }

    /**
     * @param AddressService $addressService
     * @param UserService    $userService
     * @param Request        $request
     *
     * @return RedirectResponse|Response
     * @Route("/assign", name="assign")
     */

    public function assignAction(
        AddressService $addressService,
        UserService $userService,
        Request $request
    ): RedirectResponse
    {
        if ($request->getMethod() == 'POST') {
            $address = $addressService->addressData($request->get('address_id'));
            $user = $userService->userData($request->get('user_id'));
            $address->setUserId($user->getId());
            $addressService->updateAddress($address);
            $this->addFlash('success', 'Udało się przypisać mieszkańca!');

            return $this->redirectToRoute('address_list');
        }

        return $this->render('user/addresses.html.twig');
    }
}