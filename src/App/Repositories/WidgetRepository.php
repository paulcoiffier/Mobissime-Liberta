<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class WidgetRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Widget a ORDER BY a.id ASC'
)
->getResult();
}
}
