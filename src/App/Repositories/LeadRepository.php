<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class LeadRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Lead a ORDER BY a.id ASC'
)
->getResult();
}
}
