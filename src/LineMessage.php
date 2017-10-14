<?php

namespace Chitanok\LineApiLaravel;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

/**
 * summary
 */
class LineMessage
{
	private $bot;
	private $client;
    private $messageBuilder;
    /**
     * summary
     */
    public function __construct()
    {
    	$this->client = new CurlHTTPClient(env('LINE_BOT_ACCESS_TOKEN'));
    	$this->bot = new LINEBot($this->client, ['channelSecret' => env('LINE_BOT_SECRET')]);
    }

    public function replyMessage($replayToken, $replyText){
    	$this->bot->replyText($replayToken, $replyText);
    }

    public function pushMessage($to, $text){
        $textMessageBuilder = new TextMessageBuilder($text);
        $response = $this->bot->pushMessage($to, $textMessageBuilder);
        return $response;
    }

    public function getProfile($id){
        $response = $this->bot->getProfile($id);
        return $response;
    }

    public function getDisplayName($id){
        $response = $this->bot->getProfile($id);
        if($response->isSucceeded()){
            $profile = $response->getJSONDecodedBody();
            return $profile['displayName'];
        }
    }

    public function getProfilePicture($id){
        $response = $this->bot->getProfile($id);
        if($response->isSucceeded()){
            $profile = $response->getJSONDecodedBody();
            return $profile['pictureUrl'];
        }
    }


    public function getStatusMessage($id){
        $response = $this->bot->getProfile($id);
        if($response->isSucceeded()){
            $profile = $response->getJSONDecodedBody();
            return $profile['statusMessage'];
        }
    }

    public function webhook(){

        $httpRequestBody = file_get_contents('php://input'); 
        $hash = hash_hmac('sha256', $httpRequestBody, env('LINE_BOT_SECRET'), true);
        $signature = base64_encode($hash); 
    
        $events = $bot->parseEventRequest($httpRequestBody, $signature);

        foreach ($events as $event) {
            if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
                $user_id = $event->getUserId();
                $reply_token = $event->getReplyToken();
                $text = $event->getText();
                $bot->replyText($reply_token, $text);
            }
        }
        
        return response()->json([
            'status' => 'ok'
          ], 200);

    }
}
