<?php
namespace App\Controllers;

use App\Models\Project;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ProjectController
{
	/**
	 * @return bool|mixed
	 */
	public static function showAction()
	{
		$output = render('template',array(
			'title'		=> 'Freelancehunt-выборка',
			'tpl'  => '_main'
		));
		return $output;
	}

	/**
	 * For /list
	 * @return false|string
	 */
	public static function listJsonAction()
	{
		require __DIR__ . '/../../config/config.php';
		require __DIR__ . '/../../config/connect.php';

		$projects = $_GET;

		$projects['total'] = $entityManager->getRepository('\App\Models\Project')
			->getAllProjects(1, 0, $_GET['skill'], 'count(p.id)')[0][1];

		if(!isset($_GET['count'])) {
			$projects['projects'] = $entityManager->getRepository('\App\Models\Project')
				->getAllProjects($_GET['page'], $_GET['limit'], $_GET['skill']);
		}

		$output = json_encode($projects, true);

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		return $output;
	}

	/**
	 * For /skills
	 * @return false|string
	 */
	public static function skillsJsonAction()
	{
		require __DIR__ . '/../../config/config.php';
		require __DIR__ . '/../../config/connect.php';

		$array = [];

		$skills = $entityManager->getRepository('\App\Models\Project')
			->getAllSkills($_GET['get']);

		$array['all'] = $entityManager->getRepository('\App\Models\Project')
            ->getAllProjects(1, 0, null, 'count(p.id)')[0][1];

		foreach($skills as $index => $skill) {
			$array['skills'][$index]['title'] = $skill;
			$array['skills'][$index]['count'] = $entityManager->getRepository('\App\Models\Project')
				->getAllProjects(1, 0, $skill, 'count(p.id)')[0][1];
		}

		$output = json_encode($array, true);

		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		return $output;
	}

	/**
	 * For /stat
	 * @return false|string
	 */
	public static function statJsonAction()
	{
		require __DIR__ . '/../../config/config.php';
		require __DIR__ . '/../../config/connect.php';

		$array = [
			'до 500 грн' => 'p.budget < 500',
			'500-1000 грн' => 'p.budget >= 500 AND p.budget < 1000',
			'1000-5000 грн' => 'p.budget >= 1000 AND p.budget < 5000',
			'5000-10000 грн' => 'p.budget >= 5000 AND p.budget < 10000',
			'более 10000 грн' => 'p.budget > 10000',
		];

		$index = 0;
		$result = $arr = [];
		foreach($array as $key => $where) {
			$result[$index][] = $key;
			$result[$index][] = (int) $entityManager->getRepository('\App\Models\Project')
				->getAllProjects(1, 0, null, 'count(p.id)', $where)[0][1];
			$index++;
		}

//		print '<code><pre>';
//		print_r($result);
//		print '</pre></code>';
//		return 'Вывод массива';

		$output = json_encode($result, true);
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		return $output;
	}


	/**
	 * Import open projects from freelancehunt.com into DB
	 * @return string
	 */
	public static function importProjects(): string
	{
		if (!in_array('curl', get_loaded_extensions(), true)) {
			return 'CURL extension is not installed!';
		}

		if (php_sapi_name() == 'cli') {
			require_once __DIR__ . '/../../config/config.php';
			require_once __DIR__ . '/../../config/connect.php';
		}
		$output = '';

		for ($i = 1; ; $i++) {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.freelancehunt.com/v2/projects?filter[skill_id]=' . $flhunt_skills . '&page[number]=' . $i,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $flhunt_token
				),
			));

			$response = curl_exec($curl);
			$data = json_decode($response, true);
			curl_close($curl);

			if(isset($data) && !empty($data['data'])) {
				foreach($data['data'] as $row) {
					$project_id = $row['id'];
					$title = $row['attributes']['name'];
					$link = $row['links']['self']['web'];
					$budget = $row['attributes']['budget'];
					$employer_login = $row['attributes']['employer']['login'];
					$employer_fullname = $row['attributes']['employer']['first_name'] . ' ' . $row['attributes']['employer']['last_name'];
					$employer_avatar = $row['attributes']['employer']['avatar']['small']['url'];
					$skills = array();
					foreach($row['attributes']['skills'] as $skill) {
						$skills[] = $skill['name'];
					}
					$published_at = $row['attributes']['published_at'];

					// if exist
					$sql = "SELECT `project_id` FROM projects WHERE project_id = {$project_id}";
					$rsm = new ResultSetMappingBuilder($entityManager);
					$rsm->addRootEntityFromClassMetadata('\App\Models\Project', 'p');
					$query = $entityManager->createNativeQuery($sql, $rsm);
					$products = $query->getResult();
					if(empty($products)) {
						$project = new Project();
						$project->setProjectId($project_id);
						$project->setTitle($title);
						$project->setLink($link);
						if(!empty($budget)) {
							$project->setBudgetAmount($budget['amount']);
							$project->setBudgetCurrency($budget['currency']);
							if($budget['currency'] !== 'UAH') {
								$url_c = "https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11";
								$ch_c = curl_init();
								curl_setopt($ch_c, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch_c, CURLOPT_URL, $url_c);
								$response_c = curl_exec($ch_c);
								$data_c = json_decode($response_c, true);
								curl_close($ch_c);
								foreach($data_c as $curr) {
									if($curr['ccy'] == 'RUR') {
										$curr['ccy'] = 'RUB';
									}
									if($curr['ccy'] == $budget['currency'] && $curr['base_ccy'] == 'UAH') {
										$b = $budget['amount'] * $curr['buy'];
										$project->setBudget($b);
									}
								}
							}
							else {
								$project->setBudget($budget['amount']);
							}
						}
						$project->setEmployerLogin($employer_login);
						$project->setEmployerFullname($employer_fullname);
						$project->setEmployerAvatar($employer_avatar);
						if(!empty($skills)) {
							$project->setSkills(implode(', ', $skills));
						}
						$project->setPublishedAt($published_at);

						$entityManager->persist($project);
						$entityManager->flush();

//						$output .= $title;
//						$output .= "\n\r";
					}
				}
			}
			else {
				break;
			}
		}

		return $output;
	}

}
