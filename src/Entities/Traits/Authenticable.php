<?php

namespace Foundry\Core\Entities\Traits;


trait Authenticatable
{
	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;

	/**
	 * @ORM\Column(name="remember_token", type="string", nullable=true)
	 */
	protected $remember_token;

	/**
	 * Get the column name for the primary key
	 * @return string
	 */
	public function getAuthIdentifierName()
	{
		return 'id';
	}

	/**
	 * Get the unique identifier for the user.
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		$name = $this->getAuthIdentifierName();

		return $this->{$name};
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * Get the password for the user.
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->getPassword();
	}

	/**
	 * Get the token value for the "remember me" session.
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param string $value
	 *
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}