<?php

namespace luya\matomo\tests;

use luya\testsuite\cases\WebApplicationTestCase;
use luya\matomo\OptOutWidget;

class OptOutWidgetTest extends WebApplicationTestCase
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
        $this->assertSame(
            '<iframe src="https://luya.io/index.php?module=CoreAdminHome&amp;action=optOut&amp;language=en" style="border: 0; height: 200px; width: 600px;"></iframe>',
            OptOutWidget::widget(['serverUrl' => 'https://luya.io'])
        );
    }
}