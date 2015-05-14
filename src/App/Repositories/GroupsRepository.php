<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class GroupsRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Groups a ORDER BY a.id ASC'
)
->getResult();
}
}
