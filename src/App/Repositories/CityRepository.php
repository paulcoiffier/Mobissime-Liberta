<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class CityRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\City a ORDER BY a.id ASC'
)
->getResult();
}
}
