<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class ContactRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Contact a ORDER BY a.id ASC'
)
->getResult();
}
}
