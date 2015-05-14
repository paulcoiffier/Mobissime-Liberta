<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class PersonRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Person a ORDER BY a.id ASC'
)
->getResult();
}
}
