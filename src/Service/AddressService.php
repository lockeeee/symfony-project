<?php


namespace App\Service;


use App\Model\Address;
use App\Repository\AddressRepository;
use App\Validator\AddressValidator;

class AddressService
{

    /**
     * @var AddressValidator
     */
    private $addressValidator;
    /**
     * @var AddressRepository
     */
    private $addressRepository;

    public function __construct(AddressValidator $addressValidator, AddressRepository $addressRepository)
    {

        $this->addressValidator = $addressValidator;
        $this->addressRepository = $addressRepository;
    }

    public function createAddress(Address $address) {

        $this->addressValidator->validate($address);
        $this->addressRepository->create($address);
    }

    public function showAddresses($sort, $sortOrder) {

        return $this->addressRepository->findSortedAddresses($sort, $sortOrder);
    }

    public function deleteAddress($id) {

        return $this->addressRepository->delete($id);
    }

    public function addressData($id) {

        return $this->addressRepository->find($id);
    }

    public function updateAddress(Address $address) {

        $this->addressValidator->validate($address);
        $this->addressRepository->update($address);
    }



}