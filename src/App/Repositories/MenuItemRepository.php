<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class MenuItemRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\MenuItem a ORDER BY a.id ASC'
)
->getResult();
}
}
