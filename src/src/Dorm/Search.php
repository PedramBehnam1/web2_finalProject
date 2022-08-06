<?php

namespace App\Dorm;

use App\Entity\Dorm;
use Doctrine\ORM\EntityManagerInterface;

class Search
{

 private EntityManagerInterface $entityManager;

 public function __construct(EntityManagerInterface $entityManager)
 {
  $this->entityManager = $entityManager;
 }
 public function search($input)
 {
  $input = str_replace("%", "[%]", $input);

  $dormRepository = $this->entityManager->getRepository(Dorm::class);

  return $dormRepository->createQueryBuilder('b')
  ->where('b.name like :q')
  ->setParameter('q', '%' . $input . '%')
  ->getQuery()
  ->getResult();
 }
}