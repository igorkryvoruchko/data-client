<?php


namespace app\components;


use yii\helpers\VarDumper;

class ClientJson
{
    public function sendQuery($data)
    {
        $data = Provider::prepareArray($data);
        $url = \Yii::$app->params['apiUrl'].'json/';
        $ch = curl_init($url);
        $payload = json_encode(array("userInfo" => $data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            print curl_error($ch);
        } else {
            curl_close($ch);
        }
        if(!$result){
            return false;
        }
        return $this->getResult($result);
    }

    public function getResult($resultJson)
    {
        $resultArray = json_decode($resultJson);
        switch ($resultArray->SubmitDataResult){
            case "success":
                $result = $resultArray->SubmitDataResult;
                break;
            case "reject":
                $result = "Your query was ". $resultArray->SubmitDataResult ."ed!";
                break;
            case "error":
                $result = $resultArray->SubmitDataResult . ": " .$resultArray->SubmitDataErrorMessage;
                break;
            default:
                $result = $resultJson;
                break;
        }

        return $result;
    }
}