<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class DepartmentRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Department a ORDER BY a.id ASC'
)
->getResult();
}
}
