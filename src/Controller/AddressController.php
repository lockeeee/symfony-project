<?php


namespace App\Controller;


use App\Model\Address;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use App\Service\AddressService;
use App\Service\UserService;
use App\Validator\AddressValidator;
use App\Validator\UserValidator;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
     * @param AddressService $addressService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/address-list", name="address_list")
     */


    public function indexAction(AddressService $addressService) {

        return $this->render('user/addresses.html.twig', ['address' => $addressService->showAddresses()]);
    }

    /**
     * @param AddressService $addressService
     * @param Request $request
     * @param UserService $userService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/add-address", name="add_address")
     */

    public function addAction(AddressService $addressService, Request $request, UserService $userService) {

        if($request->getMethod() == 'POST') {

            try {
                $address = new Address(NULL, $request->get('user_id'), $request->get('street'),
                    $request->get('postnumber'), $request->get('city'), $request->get('country'), $request->get('user'));
                $addressService->createAddress($address);
                $this->addFlash('success', 'Adres został dodany!');
                return $this->redirectToRoute('address_list');
            } catch(\Exception $exception) {
                $this->addFlash('success', $exception->getMessage());
            }

        }

        return $this->render('user/addaddress.html.twig', ['records' => $userService->showUsers()]);
    }

    /**
     * @param AddressService $addressService
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/delete-address/{id}", name="delete_address")
     */

    public function deleteAction(AddressService $addressService, $id) {

        $addressService->deleteAddress($id);

        $this->addFlash('success', 'Adres pomyślnie usunięty!');
        return $this->redirectToRoute('address_list');

    }

    /**
     * @param AddressService $addressService
     * @param $id
     * @param UserService $userService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/edit-address/{id}", name="edit_address")
     */

    public function editAction(AddressService $addressService, $id, UserService $userService) {

        return $this->render('user/editaddress.html.twig', ['user' => $addressService->addressData($id), 'man' => $userService->showUsers()]);
    }

    /**
     * @param AddressService $addressService
     * @param Request $request
     * @param UserService $userService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/update-address", name="update_address")
     */


    public function updateAction(AddressService $addressService, Request $request, UserService $userService) {

        if($request->getMethod() == 'POST') {

            try {
                $address = new Address($request->get('id'), $request->get('user_id'), $request->get('street'),
                    $request->get('postnumber'), $request->get('city'), $request->get('country'), NULL);
                $addressService->updateAddress($address);
                $this->addFlash('success', 'Adres pomyślnie zaktualizowany!');
                return $this->redirectToRoute('address_list');

            } catch(\Exception $exception) {
                $this->addFlash('success', $exception->getMessage());
            }

        }

        return $this->render('user/editaddress.html.twig', ['user' => $address, 'man' => $userService->showUsers()]);

    }

    /**
     * @param UserRepository $repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/assign-user/{id}", name="assign_user")
     */

    public function showAction(UserService $userService, $id) {

        return $this->render('user/assign.html.twig', ['records' => $userService->showUsers(), 'address_id' => $id]);

    }

    /**
     * @param AddressService $addressService
     * @param UserService $userService
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/assign", name="assign")
     */

    public function assignAction(AddressService $addressService, UserService $userService, Request $request) {

        if($request->getMethod() == 'POST') {

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