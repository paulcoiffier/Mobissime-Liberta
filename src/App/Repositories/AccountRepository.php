<?php
namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class AccountRepository extends EntityRepository
{
    public function findAllOrderedById()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a FROM \App\Entities\Account a ORDER BY a.id ASC'
            )
            ->getResult();
    }
}
