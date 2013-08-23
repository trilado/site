<?php
class HomeController extends Controller
{
	public function index()
	{	
		return $this->_view();
	}
	
	public function about($name)
	{
		return $this->_view($name);
	}
}
