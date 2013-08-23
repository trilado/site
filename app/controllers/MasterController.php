<?php
class MasterController extends Controller
{
	public function __construct()
	{
		$this->Template->addHook(new Hook());
	}
}