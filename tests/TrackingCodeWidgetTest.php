<?php

namespace luya\matomo\tests;

use luya\testsuite\cases\WebApplicationTestCase;
use luya\matomo\TrackingCodeWidget;

class TrackingCodeWidgetTest extends WebApplicationTestCase
{
    public function getConfigArray()
    {
        return [
               'id' => 'matomotest',
               'basePath' => dirname(__DIR__),
            ];
    }
    
    public function testWidgetOutput()
    {
        $this->assertSameTrimmed(
            '<noscript><img src="https://luya.io/piwik.php?idsite=1&rec=1" style="border:0" alt="" /></noscript>',
            TrackingCodeWidget::widget(['serverUrl' => 'https://luya.io', 'siteId' => 1, 'forceRender' => true])
        );
    }
    
    public function testJavascriptCode()
    {
        $widget = new TrackingCodeWidget(['serverUrl' => 'https://luya.io', 'siteId' => 1, 'forceRender' => true]);
        
        $this->assertSameNoSpace('var _paq = _paq || [];
_paq.push([\'trackPageView\']);
_paq.push([\'enableLinkTracking\']);
(function() {
var u="https://luya.io/";
_paq.push([\'setTrackerUrl\', u+\'piwik.php\']);
_paq.push([\'setSiteId\', \'1\']);
var d=document, g=d.createElement(\'script\'), s=d.getElementsByTagName(\'script\')[0];
g.type=\'text/javascript\'; g.async=true; g.defer=true; g.src=u+\'piwik.js\'; s.parentNode.insertBefore(g,s);
})();', $widget->getJsCode());
    }
    
    public function testJavascriptNoCookies()
    {
        $widget = new TrackingCodeWidget(['serverUrl' => 'https://luya.io', 'siteId' => 1, 'forceRender' => true, 'enableCookies' => false]);
        
        $this->assertSameNoSpace('var _paq = _paq || [];
_paq.push([\'trackPageView\']);
_paq.push([\'enableLinkTracking\']);
_paq.push([\'disableCookies\']);
(function() {
var u="https://luya.io/";
_paq.push([\'setTrackerUrl\', u+\'piwik.php\']);
_paq.push([\'setSiteId\', \'1\']);
var d=document, g=d.createElement(\'script\'), s=d.getElementsByTagName(\'script\')[0];
g.type=\'text/javascript\'; g.async=true; g.defer=true; g.src=u+\'piwik.js\'; s.parentNode.insertBefore(g,s);
})();', $widget->getJsCode());
    }
}