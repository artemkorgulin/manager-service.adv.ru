<?php
namespace Units;
use Synergy\lander\lead\AbstractLead;

class BaseLead extends AbstractLead
{
    public function toJson()
    {
        $data = array_merge($this->_attributes, $this->_params);
        return  json_encode($data/*, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES*/);
    }
}