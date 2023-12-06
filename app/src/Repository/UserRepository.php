<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $entityManager;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $this->getEntityManager();
    }

    /**
     * @param $data
     */
    public function save($data) {
        $user = new User();
        foreach ($data as $key => $value) {
            $str = '$user->set'. ucfirst($key) . '("' . $value . '");';
            eval($str);
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove($userId) {
        $user = $this->find($userId);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
