<?php

namespace Nurmanhabib\QuotaTool;

class Uid extends UserGroup
{
	public function __construct($id)
	{
		parent::__construct($id, 'uid');
	}
}