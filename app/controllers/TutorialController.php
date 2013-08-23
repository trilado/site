<?php

class TutorialController extends MasterController
{
	public function index($p = 1)
	{
		$tutorials = Tutorial::all($p, 10, 'Date', 'Desc');
		return $this->_view($tutorials);
	}
	
	public function view($id, $slug)
	{
		$tutorial = ViewTutorial::get($id);
		if ($tutorial)
			return $this->_view($tutorial);
		
		return $this->_snippet('notfound', 'O tutorial não foi encontrado');
	}

	/** @Auth("admin","manager") */
	public function add()
	{
		$tutorial = new Tutorial();
		if (is_post)
		{
			try
			{
				$tutorial = $this->_data($tutorial);
				$tutorial->Slug = Inflector::slugify($tutorial->Title);
				$tutorial->Date = time();
				$tutorial->AuthorId = (int)Session::get('user')->Id;
				$tutorial->save();
				
				$this->_flash('success', 'Tutorial salvo com sucesso');
				$this->_redirect('~/tutorial');
			}
			catch (ValidationException $e)
			{
				$this->_flash('error', $e->getMessage());
			}
			catch (Exception $e)
			{
				$this->_flash('error', 'Ocorreu um erro e não foi possível salvar o tutorial');
			}
		}
		return $this->_view($tutorial);
	}

	/** @Auth("admin","manager") */
	public function edit($id)
	{
		$tutorial = Tutorial::get($id);
		if ($tutorial)
		{
			if (is_post)
			{
				try
				{
					$tutorial = $this->_data($tutorial);
					$tutorial->Content = stripslashes($_POST['Content']);
					$tutorial->save();
					
					$this->_flash('success', 'Tutorial salvo com sucesso');
					$this->_redirect('~/tutorial');
				}
				catch (ValidationException $e)
				{
					$this->_flash('error', $e->getMessage());
				}
				catch (Exception $e)
				{
					$this->_flash('error', 'Ocorreu um erro e não foi possível salvar o tutorial');
				}
			}
			return $this->_view('add', $tutorial);
		}
		return $this->_snippet('notfound', 'O tutorial não foi encontrado');
	}

	/** @Auth("admin","manager") */
	public function delete($id)
	{
		$tutorial = Tutorial::get($id);
		if ($tutorial)
		{
			try
			{
				$tutorial->delete();
				$this->_flash('success', 'Tutorial excluído com sucesso');
			}
			catch (Exception $e)
			{
				$this->_flash('error', 'Ocorreu um erro e não foi possível excluir o tutorial');
			}
			$this->_redirect('~/tutorial');
		}
		return $this->_snippet('notfound', 'O tutorial não foi encontrado');
	}

}