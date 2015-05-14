<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class UserGroupRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\UserGroup a ORDER BY a.id ASC'
)
->getResult();
}
}
