<?php

namespace luya\matomo;

use yii\base\InvalidConfigException;
use luya\helpers\Url;

/**
 * Matomo Admin Module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Module extends \luya\admin\base\Module
{
    public $siteId;
    
    public $serverUrl;
    
    public $apiToken;
    
    public $apis = [
        'api-matomo-stats' => 'luya\matomo\apis\StatsController',
    ];
    
    public $dashboardObjects = [
        [
            'class' => 'luya\admin\dashboard\ChartDashboardObject',
            'dataApiUrl' => 'admin/api-matomo-stats/visits',
            'title' => 'Website Visitors',
        ],
    ];
    
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

    public static function ensureServerUrl($url)
    {
        return Url::ensureHttp(rtrim($url, '/'), true);
    }
}
