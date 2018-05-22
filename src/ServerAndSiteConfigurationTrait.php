<?php

namespace luya\matomo;

use luya\matomo\Module;
use yii\base\InvalidConfigException;

/**
 * Configuration trait for Widgets.
 * 
 * As widgets can take the configuration from properties or
 * the application module configuration this trait helps to
 * integrate this functionality to the widgets.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.1
 */
trait ServerAndSiteConfigurationTrait
{
    private $_siteId;
    
    /**
     * 
     * @param integer $id The given siteId from the piwik interface.
     */
    public function setSiteId($id)
    {
        $this->_siteId = $id;
    }
    
    /**
     * 
     * @return integer Return the site id from setter or module configuration.
     */
    public function getSiteId()
    {
        return $this->_siteId === null ? $this->getModule()->siteId : $this->_siteId;
    }

    private $_serverUrl;
    
    /**
     * 
     * @param string $url The path to the piwik server with schema like `https://piwik.mydomain.com`
     */
    public function setServerUrl($url)
    {
        $this->_serverUrl = $url;   
    }
    
    /**
     * 
     * @return string Return the server url from setter method for module configuration.
     */
    public function getServerUrl()
    {
        return $this->_serverUrl === null ? $this->getModule()->serverUrl : $this->_serverUrl;
    }
    
    /**
     * 
     * @return string Ensure the server url validatated with correct schema and WITHOUT trailing slash
     */
    public function getEnsuredServerUrl()
    {
        return Module::ensureServerUrl($this->getServerUrl());
    }
    
    private $_module;
    
    /**
     * Get the matomo module.
     *
     * Returns the admin module object instance.
     *
     * @return \luya\matomo\Module
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Module::getInstance();
            
            if ($this->_module === null) {
                throw new InvalidConfigException("You have either provide the sideId and serverUrl as widget config or configure the luya\matomo\Module in your config.");
            }
        }
        
        return $this->_module;
    }
}