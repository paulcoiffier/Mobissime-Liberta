<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class GroupModuleRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\GroupModule a ORDER BY a.id ASC'
)
->getResult();
}
}
