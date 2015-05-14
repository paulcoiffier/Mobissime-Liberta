<?php
namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class EmailAddressRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM \App\Entities\EmailAddress a ORDER BY a.id ASC'
            )
            ->getResult();
    }
}
