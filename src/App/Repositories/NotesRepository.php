<?php
namespace App\Repositories;
use Doctrine\ORM\EntityRepository;
class NotesRepository extends EntityRepository
{
public function findAllOrderedById()
{
return $this->getEntityManager()
->createQuery(
'SELECT a FROM \App\Entities\Notes a ORDER BY a.id ASC'
)
->getResult();
}
}
