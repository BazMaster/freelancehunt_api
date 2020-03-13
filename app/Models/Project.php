<?php
namespace App\Models;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity(repositoryClass="ProjectRepository")
 * @Table(name="projects", uniqueConstraints={@UniqueConstraint(name="projects_project_id_uindex",columns={"project_id"})})
 * @UniqueEntity("project_id")
 */
class Project
{
	/** @id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	protected $id;

	/** @Column(type="integer", unique=true, nullable=true, options={"unsigned":true}) **/
	protected $project_id;

	/** @Column(type="string", nullable=true) **/
	protected $title;

	/** @Column(type="string", nullable=true) **/
	protected $link;

	/** @Column(type="integer", nullable=true, options={ "default":"0" }) **/
	protected $budget_amount;

	/** @Column(type="string", nullable=true) **/
	protected $budget_currency;

	/** @Column(type="integer", nullable=true, options={ "default":"0" }) **/
	protected $budget;

	/** @Column(type="string", nullable=true) **/
	protected $employer_login;

	/** @Column(type="string", nullable=true) **/
	protected $employer_fullname;

	/** @Column(type="string", nullable=true) **/
	protected $employer_avatar;

	/** @Column(type="text", nullable=true) **/
	protected $skills;

	/** @Column(type="string", nullable=true) **/
	protected $published_at;




	/**
	 * @return mixed
	 */
	public function getProjectId()
	{
		return $this->project_id;
	}

	/**
	 * @param mixed $project_id
	 */
	public function setProjectId($project_id): void
	{
		$this->project_id = $project_id;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title): void
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * @param mixed $link
	 */
	public function setLink($link): void
	{
		$this->link = $link;
	}

	/**
	 * @return mixed
	 */
	public function getBudgetAmount()
	{
		return $this->budget_amount;
	}

	/**
	 * @param mixed $budget_amount
	 */
	public function setBudgetAmount($budget_amount): void
	{
		if($budget_amount === null) $budget_amount = 0;
		$this->budget_amount = $budget_amount;
	}

	/**
	 * @return mixed
	 */
	public function getBudgetCurrency()
	{
		return $this->budget_currency;
	}

	/**
	 * @param mixed $budget_currency
	 */
	public function setBudgetCurrency($budget_currency): void
	{
		if($budget_currency === null) $budget_currency = '';
		$this->budget_currency = $budget_currency;
	}

	/**
	 * @return mixed
	 */
	public function getBudget()
	{
		return $this->budget;
	}

	/**
	 * @param mixed $budget
	 */
	public function setBudget($budget): void
	{
		if($budget === null) $budget = 0;
		$this->budget = $budget;
	}

	/**
	 * @return mixed
	 */
	public function getEmployerLogin()
	{
		return $this->employer_login;
	}

	/**
	 * @param mixed $employer_login
	 */
	public function setEmployerLogin($employer_login): void
	{
		if($employer_login === null) $employer_login = '';
		$this->employer_login = $employer_login;
	}

	/**
	 * @return mixed
	 */
	public function getEmployerFullname()
	{
		return $this->employer_fullname;
	}

	/**
	 * @param mixed $employer_fullname
	 */
	public function setEmployerFullname($employer_fullname): void
	{
		if($employer_fullname === null) $employer_fullname = '';
		$this->employer_fullname = $employer_fullname;
	}

	/**
	 * @return mixed
	 */
	public function getEmployerAvatar()
	{
		return $this->employer_avatar;
	}

	/**
	 * @param mixed $employer_avatar
	 */
	public function setEmployerAvatar($employer_avatar): void
	{
		if($employer_avatar === null) $employer_avatar = '';
		$this->employer_avatar = $employer_avatar;
	}

	/**
	 * @return mixed
	 */
	public function getSkills()
	{
		return $this->skills;
	}

	/**
	 * @param mixed $skills
	 */
	public function setSkills($skills): void
	{
		if($skills === null) $skills = '';
		$this->skills = $skills;
	}

	/**
	 * @return mixed
	 */
	public function getPublishedAt()
	{
		return $this->published_at;
	}

	/**
	 * @param mixed $published_at
	 */
	public function setPublishedAt($published_at): void
	{
		$this->published_at = $published_at;
	}

}