<?php

namespace luya\matomo\apis;

use luya\admin\base\RestController;
use Curl\Curl;
use yii\base\InvalidCallException;
use luya\helpers\Json;
use luya\matomo\Module;
use luya\traits\CacheableTrait;

/**
 *
 * @author nadar
 *
 */
class StatsController extends RestController
{
    use CacheableTrait;
    
    /**
     * Examp
     * @param array $args
     * @throws InvalidCallException
     * @return mixed|NULL
     */
    protected function callApi(array $args)
    {
        return $this->getOrSetHasCache($args, function () use ($args) {
            $args['module'] = 'API';
            $args['method'] = 'API.get';
            $args['format'] = 'JSON';
            $args['idSite'] = Module::getInstance()->siteId;
            $args['token_auth'] = Module::getInstance()->apiToken;
            
            $curl = (new Curl())->get(Module::ensureServerUrl(Module::getInstance()->serverUrl) . '/index.php', $args);
            
            if (!$curl->isSuccess()) {
                throw new InvalidCallException("Invalid server call exception with message: " . $curl->error_message);
            }
            
            return Json::decode($curl->response);
        }, (60*60*6));
    }
    
    public function actionVisits()
    {
        /**
         * Example response:
         * {"2018-02-03":{
         * 	"nb_uniq_visitors":37,
         * "nb_visits":45,
         * "nb_users":0,
         * "nb_actions":64,
         * "max_actions":6,
         * "bounce_count":36,
         * "sum_visit_length":10295,
         * "nb_visits_returning":23,
         * "nb_actions_returning":36,
         * "nb_uniq_visitors_returning":18,
         * "nb_users_returning":0,
         * "max_actions_returning":6,
         * "bounce_rate_returning":"78%",
         * "nb_actions_per_visit_returning":1.600000000000000088817841970012523233890533447265625,
         * "avg_time_on_site_returning":"6 min 18s",
         * "nb_conversions":0,
         * "nb_visits_converted":0,
         * "revenue":0,
         * "conversion_rate":"0%",
         * "nb_conversions_new_visit":0,
         * "nb_visits_converted_new_visit":0,
         * "revenue_new_visit":0,
         * "conversion_rate_new_visit":"0%",
         * "nb_conversions_returning_visit":0,
         * "nb_visits_converted_returning_visit":0,
         * "revenue_returning_visit":0,
         * "conversion_rate_returning_visit":"0%",
         * "nb_pageviews":62,
         * "nb_uniq_pageviews":51,
         * "nb_downloads":0,
         * "nb_uniq_downloads":0,
         * "nb_outlinks":2,
         * "nb_uniq_outlinks":2,
         * "nb_searches":0,
         * "nb_keywords":0,
         * "nb_hits_with_time_generation":62,
         * "avg_time_generation":"0.32s",
         * "bounce_rate":"80%",
         * "nb_actions_per_visit":1.399999999999999911182158029987476766109466552734375,
         * "avg_time_on_site":"3 min 49s"}
         * @var array $data
         */
        $data = $this->callApi(['period' => 'day', 'date' => 'last10', 'format_metrics' => 1, 'period' => 'day']);
        
        
        $days = [];
        $unique = [];
        $visits = [];
        
        foreach ($data as $date => $values) {
            $days[] = $date;
            $unique[] = $values['nb_uniq_visitors'];
            $visits[] = $values['nb_visits'];
        }
        
        return [
                'xAxis' => ['type' => 'category', 'boundaryGap' => false, 'data' => $days],
                'yAxis' => ['type' => 'value'],
                'series' => [
                    [
                        'data' => $unique,
                        'type' => 'line',
                        'name' => 'Unique',
                    ], [
                        'data' => $visits,
                        'type' => 'line',
                        'name' => 'Visits',
                    ]
                ]
        ];
    }
}
