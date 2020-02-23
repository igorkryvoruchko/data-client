<?php

namespace app\components;

class ClientXml
{
    public function getHeaders($xml)
    {
        return array(
            "Content-type: text/xml",
            "Content-length: " . strlen($xml),
            "Connection: close",
        );
    }

    public function getXmlBody($data)
    {
        return '<?xml version="1.0"?>
<userInfo version="1.6">
    <firstName>'.$data->firstName.'</firstName>
    <lastName>'.$data->lastName.'</lastName>
    <salary>'.$data->Salary.'</salary>
    <age>'.Provider::getPersonAge($data->dateOfBirth).'</age>
    <creditScore>'.Provider::getCreditScore($data->creditScore).'</creditScore>
</userInfo>
';
    }

    public function sendQuery($data)
    {
        $url = \Yii::$app->params['apiUrl'].'xml/';
        $xml = $this->getXmlBody($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders($xml));

        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            return curl_error($ch);
        } else {
            curl_close($ch);
        }
        if(!$result){
            return false;
        }
        return $this->getResult($result);
    }

    public function getResult($resultXml)
    {
        $result = "";

        $resultObj = simplexml_load_string($resultXml);
        switch ($resultObj->returnCode){
            case 1:
                $result = $resultObj->returnCodeDescription . ": Transaction id = ".$resultObj->transactionId;
                break;
            case 0:
                if($resultObj->returnCodeDescription == "REJECT"){
                    $result = "Your query was ".$resultObj->returnCodeDescription."ed!";
                } elseif ($resultObj->returnCodeDescription == "ERROR") {
                    $result = $resultObj->returnCodeDescription .": ".$resultObj->returnError;
                }
                break;
            default:
                $result = var_dump($resultObj);
                break;
        }

        return $result;
    }
}