<?php

namespace App\Service;

use App\Model\Address;
use App\Repository\AddressRepository;
use App\Validator\AddressValidator;
use Doctrine\DBAL\DBALException;

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

    /**
     * @param AddressValidator  $addressValidator
     * @param AddressRepository $addressRepository
     */
    public function __construct(AddressValidator $addressValidator, AddressRepository $addressRepository)
    {
        $this->addressValidator = $addressValidator;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param Address $address
     *
     * @throws DBALException
     */
    public function createAddress(Address $address)
    {
        $this->addressValidator->validate($address);
        $this->addressRepository->create($address);
    }

    /**
     * @param $sort
     * @param $sortOrder
     *
     * @return array
     * @throws DBALException
     */
    public function showAddresses($sort, $sortOrder): array
    {
        return $this->addressRepository->findSortedAddresses($sort, $sortOrder);
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws DBALException
     */
    public function deleteAddress(int $id): bool
    {
        return $this->addressRepository->delete($id);
    }

    /**
     * @param int $id
     *
     * @return Address|null
     * @throws DBALException
     */
    public function addressData(int $id)
    {
        return $this->addressRepository->find($id);
    }

    /**
     * @param Address $address
     *
     * @throws DBALException
     */
    public function updateAddress(Address $address)
    {
        $this->addressValidator->validate($address);
        $this->addressRepository->update($address);
    }



}