<?php
namespace Synergy\lander\lead\sources;
use Synergy\lander\Lander;

class LeadFromRequest extends AbstractSource
{
    public function get($key, $default = null)
    {
        return Lander::app()->request->post($key, Lander::app()->request->get($key, $default));
    }

    public function afterFill($lead)
    {
        $this->_detectLeadGeo($lead);
        $this->_detectLeadBrowser($lead);
    }

    protected function _detectLeadGeo($lead)
    {
        /*
         * if(filter_var($this->ip, FILTER_VALIDATE_IP)) {
            @include_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SxGeo' . DIRECTORY_SEPARATOR . 'SxGeo.php');
            if(class_exists('SxGeo', false)) {
                $sxgeo = new SxGeo(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SxGeo' . DIRECTORY_SEPARATOR . 'SxGeoMax.dat');
            }
            if ($this->countryname == '') {
                if($sxgeo instanceof SxGeo) {
                    $xml = $sxgeo->getCityFull($this->ip);
                    $this->country  = $xml['country']['name_ru'] != '' ? $xml['country']['name_ru'] : htmlspecialchars($this->country);
                    $this->city = $xml['city']['name_ru'] != '' ? $xml['city']['name_ru'] : htmlspecialchars($this->city);
                    $this->region  = $xml['region']['name_ru'] != '' ? $xml['region']['name_ru'] : htmlspecialchars($this->region);
                }
                else{
                    $this->country = ($this->country != '') ? htmlspecialchars($this->country) : null;
                    $this->city = ($this->city != '') ? htmlspecialchars($this->city) : null;
                    $this->region = ($this->region != '') ? htmlspecialchars($this->region) : null;
                }
            } else {
                $this->country = $this->countryname;
            }
        }
         */
    }

    protected function _detectLeadBrowser($lead)
    {
        /*
         * $bc = new Browscap(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Browscap' . DIRECTORY_SEPARATOR . 'cache');
		$browser = $bc->getBrowser();
		$JavaScript = ($browser->JavaScript == '1') ? 'Да' : 'Нет' ;
        $this->browscap = "Браузер: {$browser->Parent}\nОперационная система: {$browser->Platform_Description}\nJavaScript: {$JavaScript}\nТип устройства: {$browser->Device_Type}\nПроизводитель: {$browser->Device_Maker}\nИмя устройства: {$browser->Device_Name}\nМодель: {$browser->Device_Code_Name}";
        $this->browser = $browser->Parent;

         */
    }
}