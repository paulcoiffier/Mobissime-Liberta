<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class MenuRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Menu a ORDER BY a.id ASC'
)
->getResult();
}
}
