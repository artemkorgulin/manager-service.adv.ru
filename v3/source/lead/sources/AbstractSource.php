<?php
namespace Synergy\lander\lead\sources;
use Synergy\lander\Lander;
use Synergy\lander\lead\AbstractLead;

/**
 * Class AbstractSource
 * Заполнение лида из определенного источника
 * @package Synergy\lander\lead\sources
 */
abstract class AbstractSource
{
    public function fill(AbstractLead $lead)
    {
        $asIs = ['phone', 'email', 'unit', 'data', 'partner', 'campaign', 'land', 'visitType', 'form', 'refer', 'cost', 'speaker', 'program',
            'positie', 'company', 'dater', 'channel', 'link', 'question', 'graccount', 'grcampaign', 'grdate',
            'grtag', 'proftest_key', 'proftest_link', 'g-recaptcha-response', 'PAPVisitorId', 'piwik_id',
            'analytics_id', 'mergelead', 'roistat_visit', 'manager_name', 'manager_phone', 'manager_email', 'bitrix',
             'radio', 'gender', 'onlinepay', 'product_id', 'education', 'birthdate', 'comments',
            'ext_info', 'calltime', 'region' , 'lang', 'action'
        ];

        $lead->name = $this->get('name', 'NoName');

        foreach ($asIs as $key) {
            $lead->$key = $this->get($key);
        }

        $lead->countryname = $this->get('countryname', '');
        if (empty($lead->comments)) {
            if ($c = $this->get('comments')) {
                $comments_str = '';
                foreach ($c as $key => $val) {
                    $comments_str .= strip_tags($key) . ': ' . strip_tags($val) . '; ';
                }
                $lead->comments = $comments_str;
            }
        }

        $lead->setCalltimePeriod($this->get('calltime_from'), $this->get('calltime_to'));

        $lead->cycle_day = $this->get('cycle_day', 0);
        $lead->owa_visitorIs = $this->get('piwik_id');

        if (!$lead->ip) $lead->setIp();
        $lead->url = $this->get('url', Lander::app()->request->server('HTTP_REFERER'));
        $lead->agent = Lander::app()->request->server('HTTP_USER_AGENT');
        $lead->path = $this->get('path', Lander::app()->request->server('REQUEST_URI'));
        $lead->version = $this->get('version', 'default');
        $lead->phpsessid = isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : null;
        $lead->bitrix_host = $this->get('bitrix');

        $lead->lead_uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff )
        );

        $this->afterFill($lead);
        $lead->afterFill();
    }

    abstract public function get($key, $default = null);

    public function afterFill($lead)
    {
    }
}