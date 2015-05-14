<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class ModuleRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Module a ORDER BY a.id ASC'
)
->getResult();
}
}
