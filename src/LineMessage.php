<?php

namespace Chitanok\LineApiLaravel;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
// For Template message
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;



/**
 * summary
 */
class LineMessage
{
    private $bot;
    private $client;
    private $messageBuilder;
    private $actionBuilders;
    private $templateBuilder;
    private $template;
    /**
     * summary
     */
    public function __construct()
    {
        $this->client = new CurlHTTPClient(env('LINE_BOT_ACCESS_TOKEN'));
        $this->bot = new LINEBot($this->client, ['channelSecret' => env('LINE_BOT_SECRET')]);
        $this->actionBuilders = [];

    }

    public function replyMessage($replayToken, $replyText){
        $this->bot->replyText($replayToken, $replyText);
    }

    public function pushMessage($to, $text){
        $textMessageBuilder = new TextMessageBuilder($text);
        $response = $this->bot->pushMessage($to, $textMessageBuilder);
        return $response;
    }

    public function GroupMessage($title, $text, $imageUrl, $url){
        $to = "C7da644e0923d47d5bfc0ef53bf98cce7";
        $buttonTemplateBuilder = new ButtonTemplateBuilder(
                    "$title",
                    "$text",
                    "$imageUrl",
                    [
                        new UriTemplateActionBuilder("Show Details", "$url"),
                    ]
                );
        $buttonMessageTemp = new TemplateMessageBuilder("Property Notification", $buttonTemplateBuilder);
        $response = $this->bot->pushMessage($to, $buttonMessageTemp);
        return $response;
    }

    public function GroupMessageCarousel($title = array(), $text = array(), $imageUrl = array(), $url){
        $to = "C7da644e0923d47d5bfc0ef53bf98cce7";
            $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder("$title[0]", "$text[0]", $imageUrl[0], [
                        new UriTemplateActionBuilder("View Details", "$url"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[1]", "$text[1]", $imageUrl[1], [
                        new PostbackTemplateActionBuilder("New Action", "action=add&itemid=123"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[2]", "$text[2]", $imageUrl[2], [
                        new PostbackTemplateActionBuilder("Add to cart", "action=add&itemid=123"),
                    ]),
                ]);
                $templateMessage = new TemplateMessageBuilder('Alt Text', $carouselTemplateBuilder);
                $this->bot->pushMessage($to, $templateMessage);
    }

    public function GroupCarouselMessage($title = array(), $text = array(), $imageUrl = array(), $url = array(), $to = ""){
            // $to = "C7da644e0923d47d5bfc0ef53bf98cce7";
                $carouselTemplateBuilder = "";
                if(count($imageUrl) < 2){
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder("$title[0]", "$text[0]", $imageUrl[0], [
                        new UriTemplateActionBuilder("View Details", "$url[0]"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[1]", "$text[1]", $imageUrl[0], [
                        new UriTemplateActionBuilder("LINE ME", "$url[1]"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[2]", "$text[2]", $imageUrl[0], [
                        new UriTemplateActionBuilder("LINE JERBIT", "$url[2]"),
                    ]),
                ]);
            }elseif(count($imageUrl) < 3 ){
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder("$title[0]", "$text[0]", $imageUrl[0], [
                        new UriTemplateActionBuilder("View Details", "$url[0]"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[1]", "$text[1]", $imageUrl[1], [
                        new UriTemplateActionBuilder("LINE ME", "$url[1]"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[2]", "$text[2]", $imageUrl[0], [
                        new UriTemplateActionBuilder("LINE JERBIT", "$url[2]"),
                    ]),
                ]);
            }else{
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder("$title[0]", "$text[0]", $imageUrl[0], [
                        new UriTemplateActionBuilder("View Details", "$url[0]"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[1]", "$text[1]", $imageUrl[1], [
                        new UriTemplateActionBuilder("LINE ME", "$url[1]"),
                    ]),
                    new CarouselColumnTemplateBuilder("$title[2]", "$text[2]", $imageUrl[2], [
                        new UriTemplateActionBuilder("LINE JERBIT", "$url[2]"),
                    ]),
                ]);
            }

            $templateMessage = new TemplateMessageBuilder('Alt Text', $carouselTemplateBuilder);
            $this->bot->pushMessage($to, $templateMessage);
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
