<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class ModuleActionRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\ModuleAction a ORDER BY a.id ASC'
)
->getResult();
}
}
