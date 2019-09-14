<?php


namespace App\Repository;


use App\Model\Address;
use Doctrine\DBAL\Connection;

class AddressRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function findAddresses() {
        $sql = "SELECT address.id, user_id, street, postnumber, city, country, user_id, name, surname, mail, pnumber 
                FROM address INNER JOIN users u on address.user_id = u.ID";
        $stmt = $this->connection->query($sql);
        $records = [];

        foreach ($stmt->fetchAll() as $addressData) {
            $user = new \App\Model\User($addressData['user_id'], $addressData['name'], $addressData['surname'],
                $addressData['mail'], $addressData['pnumber']);
            $records[] = new \App\Model\Address($addressData['id'], $addressData['user_id'], $addressData['street'],
                $addressData['postnumber'], $addressData['city'], $addressData['country'], $user);

        }


        return $records;
    }

    public function create(Address $address) {
        $sql = "INSERT INTO address(user_id, street, postnumber, city, country) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$address->getUserId(), $address->getStreet(), $address->getPostnumber(), $address->getCity(), $address->getCountry()]);
    }

    public function delete($id) {
        $sql = "DELETE from address WHERE id = ?";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function find($id) {
        $sql = "SELECT * from address WHERE id = ?";
        $stmt = $this->connection->prepare($sql);

        if(!$stmt->execute([$id])) {
            return NULL;
        }

        $addressData = $stmt->fetch();

        if (empty($addressData)) {
            return NULL;
        }

        $user = new Address($addressData['id'], $addressData['user_id'], $addressData['street'],
            $addressData['postnumber'], $addressData['city'], $addressData['country'], NULL);

        return $user;
    }

    public function update(Address $address) {
        $sql = "UPDATE address SET user_id = ?, street = ?, postnumber = ?, city = ?, country = ? WHERE ID = ?";

        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$address->getUserId(), $address->getStreet(), $address->getPostnumber(),
            $address->getCity(), $address->getCountry(), $address->getId()]);
    }


}