<?php

namespace luya\matomo;

use luya\base\Widget;
use luya\web\View;

/**
 * Integrate Matomo TrackingCode.
 * 
 * We recommend you register the TrackindCodeWidget in the footer of the LAYOUT as 
 * there is an tracking pixel fallback which will be rendered.
 * 
 * ```php
 * <?= \luya\matomo\TrackingCodeWidget::widget(); ?>
 * <?php $this->endBody() ?>
 * ```
 * 
 * If you are using the tracking code widget without the module, you have to provide the
 * $siteId and $serverUrl like this
 * 
 * ```php
 * TrackingCodeWidget::widget([
 *     'siteId' => 1,
 *     'serverUrl' => 'https://luya.io'
 * ]);
 * ```
 *
 * @property \luya\matomo\admin\Module $module
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TrackingCodeWidget extends Widget
{
    use ServerAndSiteConfigurationTrait;
    
    /**
     * @var string Disable cookies for the visitor: https://matomo.org/faq/general/faq_157/
     * @since 1.0.1
     */
    public $enableCookies = true;
    
    /**
     * @var string Overrides whether the script should be rendered and assigned, as its default disabled when not in production.
     * @since 1.0.1
     */
    public $forceRender = false;
    
    public function getJsCode()
    {
        $push = [
            "_paq.push(['trackPageView']);",
            "_paq.push(['enableLinkTracking']);"
        ];
        
        if ($this->enableCookies === false) {
            $push[] = "_paq.push(['disableCookies']);";
        }
        
        return "var _paq = _paq || [];
".implode(PHP_EOL, $push)."
(function() {
    var u=\"".$this->getEnsuredServerUrl()."/\";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '".$this->getSiteId()."']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
})();";
        
    }

    public function isTrackingRender()
    {
        return $this->forceRender || YII_ENV_PROD;
    }
    
    public function run()
    {
        // if not in production, the widget does not render and register anything.
        if ($this->isTrackingRender()) {
            $this->view->registerJs($this->getJsCode(), View::POS_HEAD);
        
            return $this->render('trackingcode', [
                'hostName' => $this->getEnsuredServerUrl(),
                'siteId' => $this->siteId,
            ]);
        }
    }
}
