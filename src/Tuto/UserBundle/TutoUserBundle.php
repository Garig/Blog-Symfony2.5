<?php

namespace Tuto\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TutoUserBundle extends Bundle
{
	public function getParent(){
		return 'FOSUserBundle';
	}
}
