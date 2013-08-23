<?php
/**
 * @Entity("user") 
 */
class User extends Model
{
	/**
	 * @AutoGenerated()
	 * @Column(Type="Int",Key="Primary")
	 */
	public $Id;
	
	/**
	 * @Column(Type="String")
	 * @Label("Nome")
	 * @Required()
	 */
	public $Name;
	
	/**
	 * @Column(Type="String")
	 * @Label("E-mail")
	 * @Required()
	 */
	public $Email;
	
	/**
	 * @Column(Type="String")
	 * @Label("Senha")
	 * @Required()
	 */
	public $Password;
	
	/**
	 * @Column(Type="Int")
	 */
	public $CreatedDate;
	
	/**
	 * @Column(Type="Int")
	 */
	public $LastLoginDate;
	
	/**
	 * @Column(Type="Int")
	 */
	public $Level;
	
	public static function login($email, $pass)
	{
		$db = Database::getInstance();
		return $db->User->single('Email = ? AND Password = ?', $email, md5($pass));
	}
	
	public static function getByEmail($email)
	{
		$db = Database::getInstance();
		return $db->User->single('Email = ?', $email);
	}
}