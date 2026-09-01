<?php

class Telegram_Bot
{

    protected $_botid = NULL;
    protected $_chatid = '';
    protected $_operation = NULL;
    protected $_parse_mode = 'html';
    protected $_message = NULL;


    public function botid($botid)
    {
        $this->_botid = $botid;
        return $this;
    }


    public function chatid($chatid)
    {
        $this->_chatid = $chatid;
        return $this;
    }

    public function operation($operation)
    {
        $this->_operation = $operation;
        return $this;
    }

    public function parse_mode($parse_mode)
    {
        $this->_parse_mode = $parse_mode;
        return $this;
    }

    public function message($message)
    {
        $this->_message = $message;
        return $this;
    }

    public function execute()
    {
        $url = 'https://api.telegram.org/bot' . $this->_botid . '/' . $this->_operation;
        $postFields = array(
            'chat_id' => $this->_chatid,
            'text' => $this->_message,
            'parse_mode' => $this->_parse_mode
        );

        $myCurl = curl_init();
        curl_setopt_array($myCurl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postFields)
        ));

        $response = curl_exec($myCurl);
        $error = curl_error($myCurl);
        curl_close($myCurl);

        $log = [
            'time' => date('Y-m-d H:i:s'),
            'operation' => $this->_operation,
            'post_fields' => $postFields,
            'response' => $response,
            'error' => $error
        ];

        error_log("Telegram Log: " . json_encode($log, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
