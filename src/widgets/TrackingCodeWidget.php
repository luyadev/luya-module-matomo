<?php

namespace luya\matomo\widgets;

use luya\base\Widget;
use luya\web\View;
use luya\matomo\admin\Module;

/**
 * 
 * @property \luya\matomo\admin\Module $module
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TrackingCodeWidget extends Widget
{
	public $siteId;
	
	public $serverUrl;
	
	public function init()
	{
		parent::init();

		if ($this->siteId === null) {
			$this->siteId = $this->module->siteId;
		}
		
		if ($this->serverUrl === null) {
			$this->serverUrl = $this->module->serverUrl;
		}
	}
	
	private $_module;
	
	/**
	 * 
	 * @return \luya\matomo\admin\Module
	 */
	public function getModule()
	{
		if ($this->_module === null) {
			$this->_module = Module::getInstance();
		}
		
		return $this->_module;
	}
	
	public function getEnsuredHostName()
	{
		return rtrim(parse_url($this->serverUrl, PHP_URL_HOST), "/");
	}
	
	public function run()
	{
		$this->view->registerJs("
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=\"//{$this->getEnsuredHostName()}/\";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '{$this->siteId}']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
	", View::POS_BEGIN);
		
		return $this->render('trackingcode', [
			'hostName' => $this->getEnsuredHostName(),
			'siteId' => $this->siteId,
		]);
	}
}