<?php
/**
 * Created by PhpStorm.
 * User: merlinoff
 * Date: 11.03.15
 * Time: 11:14
 */

namespace merlinoff;


use Curl\Curl;

class SimilarWeb
{

    const  XML = "XML";
    const JSON = "JSON";
    const  API_URL = "http://api.similarweb.com/Site";
    const API_VERSION = "v1";
    const API_VERSION2 = "v2";

    private $userKey;
    private $format;
    private $curl;
    private $domain;
    private $error;

    public function  __construct($userKey, $format = self::JSON)
    {
        $this->userKey = $userKey;
        $this->$format = $format;
        $this->curl = new Curl();
    }

    public function  setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function  getDomain()
    {
        return $this->domain;
    }

    public function  setFormat($format)
    {
        $this->format = $format;
    }

    public function  getFormat()
    {
        return $this->format;
    }

    public function  setUserKey($userKey)
    {
        $this->userKey = $userKey;
    }

    public function  getUserKey()
    {
        return $this->userKey;
    }
    private function parseResponse($curl){
        if ($curl->error) {
            $this->error =  'Error: ' . $curl->error_code . ': ' . $curl->error_message;
            return false;
        }
        return $curl->response;
    }

    //http://api.similarweb.com/Site/cnn.com/v1/visits?gr=daily&start=9-2013&end=5-2014&md=false&Format=JSON&UserKey=#
    /**
     * This command echoes what you have entered as the message.
     * @param string $gr string Daily, Weekly, Monthly *Default: Monthly.
     * @param string $start string Start Month (M-YYYY) *Required
     * @param string $end string End Month (M-YYYY) *Required
     * @param boolean $md False/True. Get metrics on the Main Domain only (i.e. not including subdomains). *Default: False.
     * @return array
     */
    public function getTraffic($start, $end, $gr = 'monthly', $md = "false")
    {
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/visits", array(
            'gr' => $gr,
            'start' => $start,
            'end' => $end,
            'md' => $md,
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey()
        ));
        return $this->parseResponse($this->curl);
    }

    public function getRankAndReach()
    {
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/traffic", array(
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey()
        ));

        $response = $this->parseResponse($this->curl);
        if($response) {
            $result = [];
            $result['GlobalRank'] = $response->GlobalRank;
            $result["TrafficShares"] = $response->TrafficShares;
            return $result;
        } else
            return $response;
    }

    public function getPageViews($start, $end, $gr = 'monthly', $md = false){
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/pageviews", array(
            'gr' => $gr,
            'start' => $start,
            'end' => $end,
            'md' => $md,
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey()
        ));
        return $this->parseResponse($this->curl);
    }
    public function getVisitDuration($start, $end, $gr = 'monthly', $md = false)
    {
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/visitduration", array(
            'gr' => $gr,
            'start' => $start,
            'end' => $end,
            'md' => $md,
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey()
        ));
        return $this->parseResponse($this->curl);
    }

    public function getBounceRate($start, $end, $gr = 'monthly', $md = false)
    {
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/bouncerate", array(
            'gr' => $gr,
            'start' => $start,
            'end' => $end,
            'md' => $md,
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey()
        ));
        return $this->parseResponse($this->curl);
    }

    public function getCategoryRank()
    {
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION2 . "/CategoryRank", array(
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey()
        ));
        return $this->parseResponse($this->curl);
    }
    public function getTopSites($category="All Categories",$country="Worldwide"){
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/traffic", array(
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey(),
            'category'=>$category,
            'country'=>$country

        ));
        return $this->parseResponse($this->curl);
    }

    public function getSocialReferringSites(){
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/socialreferringsites", array(
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey(),
        ));
        return $this->parseResponse($this->curl);
    }

    public function getSocialOrgSearch($start,$end,$md="False"){
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/orgsearch", array(
            'start'=>$start,
            'end' => $end,
            'md' =>$md,
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey(),
        ));
        return $this->parseResponse($this->curl);
    }

    public function getSocialPaidSearch($start,$end,$page=1,$md="False"){
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/paidsearch", array(
            'start'=>$start,
            'end' => $end,
            'md' =>$md,
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey(),
            'page'=>$page,


        ));
        return $this->parseResponse($this->curl);
    }

    public function getLeadingDestinationSites(){
        $this->curl->get(self::API_URL . "/" . $this->domain . "/" . self::API_VERSION . "/orgsearch", array(
            'Format' => $this->getFormat(),
            'UserKey' => $this->getUserKey(),
        ));
        return $this->parseResponse($this->curl);
    }
}
