<?php


namespace App\Models;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
	public function getAllProjects($page = 1, $limit = 10, $skill = null, $select = 'p') {
		$first = $page * $limit - $limit;
		$qb = $this->_em->createQueryBuilder();
		$qb
			->select($select)
			->from('\App\Models\Project', 'p')
			->orderBy('p.published_at', 'DESC')
		;
		if(!empty($skill)) {
			$qb
				->where('p.skills LIKE :like')
				->setParameter('like','%'. $skill . '%')
			;
		}
		if($page > 0) {
			$qb
				->setFirstResult($first)
			;
		}
		if($limit > 0) {
			$qb
				->setMaxResults($limit)
			;
		}
		$query = $qb->getQuery();
		return $query->getArrayResult();
	}

	public function getAllSkills($get = null) {
		$qb = $this->_em->createQueryBuilder();
		$qb
			->select('p.skills')
			->from('\App\Models\Project', 'p')
		;
		$query = $qb->getQuery();
		$result = $query->getArrayResult();

		$skills = [];
		foreach($result as $row) {
			$s = explode(', ', $row['skills']);
			foreach ($s as $skill) {
				$skills[] = $skill;
			}
		}
		$skills = array_unique($skills);
		if($get !== null) {
			$get_skills = explode(',', $get);
			$skills = array_values(array_intersect($skills, $get_skills));
		}

		return $skills;
	}
}