<?php

namespace Nurmanhabib\QuotaTool;

class Gid extends UserGroup
{
	public function __construct($id)
	{
		parent::__construct($id, 'gid');
	}
}