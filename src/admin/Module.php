<?php

namespace luya\matomo\admin;

use yii\base\InvalidConfigException;

/**
 * Matomo Admin Module.
 *
 * File has been created with `module/create` command. 
 */
class Module extends \luya\admin\base\Module
{
	public $siteId;
	
	public $serverUrl;
	
	public $apiToken;
	
	public function init()
	{
		parent::init();
		
		if ($this->siteId === null) {
			throw new InvalidConfigException("The siteId property of the matomo module must be configured.");
		}
		
		if ($this->serverUrl === null) {
			throw new InvalidConfigException("The serverUrl property of the matomo module must be configured.");
		}
	}
}