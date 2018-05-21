<?php

namespace luya\matomo;

use Yii;
use luya\base\Widget;
use luya\helpers\Html;

/**
 * User Opt Out Widget.
 * 
 * Generates an iframe where the user can opt out from the tracking system.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.1
 */
class OptOutWidget extends Widget
{
    use ServerAndSiteConfigurationTrait;
    
    /**
     * @var string A hexadecimal color string for example ffffff or ddd
     */
    public $backgroundColor;
    
    /**
     * @var string A hexadecimal color string for example ffffff or ddd
     */
    public $fontColor;
    
    /**
     * @var string A valid CSS font size for example 1.2em, 15pt, 15px or 50%
     */
    public $fontSize;
    
    /**
     * @var string A string containing only letters, space, or hyphen eg. Lucida, Courier new
     */
    public $fontFamily;

    /**
     * @var string The language of the opt-out text, a two letter code eg. en or de. If nothing provided the composition language will be used.
     */
    public $language;
    
    public function run()
    {
        $params = [
            'module' => 'CoreAdminHome',
            'action' => 'optOut',
            'language' => Yii::$app->composition->langShortCode,
            'backgroundColor' => $this->backgroundColor,
            'fontColor' => $this->fontColor,
            'fontSize' => $this->fontSize,
            'fontFamily' => $this->fontFamily,
        ];
        
        $src = $this->getEnsuredServerUrl() . '/index.php?' . http_build_query($params);
        
        return Html::tag('iframe', null, ['src' => $src, 'style' => 'border: 0; height: 200px; width: 600px;']);
    }
}