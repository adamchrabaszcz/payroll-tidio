<?php

namespace App\Repository;

use App\Doctrine\Transformer\EmployeeTransformer;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Repository\EmployeeRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    private EmployeeTransformer $employeeTransformer;

    public function __construct(
        ManagerRegistry $registry,
        EmployeeTransformer $employeeTransformer
    ){
        parent::__construct($registry, Employee::class);
        $this->employeeTransformer = $employeeTransformer;
    }

    public function getAllBy(array $filterBy = [], array $sortBy = []): ?array
    {
        $qb = $this->createQueryBuilder('e');
        $qb->join('e.department', 'department');

        if (isset($filterBy['field']) && isset($filterBy['value'])) {
            if ('departmentName' == $filterBy['field']) {
                $qb->andWhere('department.name LIKE :val');
            } elseif ('bonusType' == $filterBy['field']) {
                $qb->andWhere('department.bonusType = :val');
            } else {
                $qb->andWhere(sprintf('LOWER(e.%s) LIKE LOWER(:val)', $filterBy['field']));
            }
            $qb->setParameter('val', '%' . addcslashes($filterBy['value'], '%_') . '%');
        }

        if (isset($sortBy['field']) && isset($sortBy['direction'])) {
            if ('departmentName' == $sortBy['field']) {
                $qb->orderBy('department.name', $sortBy['direction']);
            } elseif ('bonusType' == $sortBy['field']) {
                $qb->orderBy('department.departmentBonus.bonusType', $sortBy['direction']);
            } else {
                $qb->orderBy(sprintf('LOWER(e.%s)', $sortBy['field']), $sortBy['direction']);
            }
        }

        $entityResults = $qb->getQuery()->getResult();

        $domainResults = [];
        foreach ($entityResults as $entity) {
            $domainResults[] = $this->employeeTransformer->entityToDomain($entity);
        }

        return $domainResults;
    }
}
