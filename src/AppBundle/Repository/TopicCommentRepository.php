<?php
namespace AppBundle\Repository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\Expr\Join;
/**
 * TopicCommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TopicCommentRepository extends \Doctrine\ORM\EntityRepository
{
	public function getComments($topicId, $offset = 0, $limit = null)
	{
		$query = $this->createQueryBuilder('c')
			->where('c.topicId = :topicId')
			->setParameter('topicId', $topicId)
			->orderBy('c.createdAt', 'ASC')
			->getQuery();
		$query->setFirstResult($offset);
		if ($limit)
			$query->setMaxResults($limit);
		$paginator = new Paginator($query);
		return $paginator;
	}
	public function getLatestCommentByCategory($categoryId)
	{
		$query = $this->createQueryBuilder('c')
			->leftJoin('c.topic', 'topic')
			->where('topic.categoryId = :categoryId')
			->orderBy('c.createdAt', 'DESC')
			->setParameter('categoryId', $categoryId)
			->setMaxResults(1)
			->getQuery();
		return $query->getOneOrNullResult();
	}
	public function getCommentsByUser($userId)
	{
		$query = $this->createQueryBuilder('c')
			->where('c.userId = :userId')
			->orderBy('c.createdAt', 'DESC')
			->setParameter('userId', $userId)
			->getQuery();
		return $query->getResult();
	}
}