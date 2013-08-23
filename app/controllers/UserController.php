<?php

class UserController extends MasterController
{
	public function login()
	{
		if(Auth::isLogged())
			$this->_redirect('~/');
		
		$user = new User();
		if(is_post)
		{
			try
			{
				$user = User::login($_POST['Email'], $_POST['Password']);
				if($user)
				{
					$levels = array('admin','manager','user');
					Session::set('user', $user);
					Auth::set($levels[$user->Level]);
					
					$this->_flash('success', 'Bem-vindo '. $user->Name);
					$this->_redirect('~/forum');
				}
				else
				{
					$user = $this->_data(new User());
					$this->_flash('error', 'E-mail e senha não conferem');
				}
			}
			catch (Exception $e)
			{
				$this->_flash('error', 'Ocorreu um erro e não foi possível fazer seu login');
			}
		}
		return $this->_view($user);
	}
	
	/** @Auth("admin","manager","user") */
	public function logoff()
	{
		Session::clear();
		Auth::clear();
		$this->_redirect('~/');
	}
	
	public function register()
	{
		if(Auth::isLogged())
			$this->_redirect('~/');
		
		$user = new User();
		if(is_post)
		{
			if(!defined('session_started'))
				session_start();
			
			if (md5($_POST['Captcha']) == $_SESSION['captcha'])
			{
				try
				{
					$user = $this->_data($user);

					if(!User::getByEmail($user->Email))
					{
						if($_POST['Password'] == $_POST['ConfirmPassword'])
						{
							$user->Level = 2;
							$user->Password = md5($user->Password);
							$user->CreatedDate = time();
							$user->save();

							Session::set('user', $user);
							Auth::set('user');

							$this->_flash('success', 'Bem-vindo '. $user->Name);
							$this->_redirect('~/forum');
						}
						else
						{
							$this->_flash('error', 'Os campos Senha e Confirmar Senha estão diferentes');
						}
					}
					else
					{
						$this->_flash('error', 'Este e-mail já está sendo utilizado');
					}
				}
				catch (ValidationException $e)
				{
					$this->_flash('error', $e->getMessage());
				}
				catch (Exception $e)
				{
					$this->_flash('error', 'Ocorreu um erro e não foi possível criar sua conta');
				}
			}
			else
			{
				$this->_flash('error', 'Código de segurança inválido');
			}
		}
		
		
		return $this->_view($user);
	}
}