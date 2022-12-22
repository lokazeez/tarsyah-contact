<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;
use SebastianBergmann\Diff\ConfigurationException;
use Twilio\Exceptions\ConfigurationException as TwilioConfigurationException;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
use Twilio\Rest\Client;

trait TwilioTrait
{

    function sendSms($recipients, $message)
    {
        $account_sid = config('twilio.whatsapp_config.TWILIO_ACCOUNT_SID');
        $auth_token = config("twilio.whatsapp_config.TWILIO_AUTH_TOKEN");
        $twilio_number = config("twilio.whatsapp_config.TWILIO_WHATSAPP_NUMBER");

        try {
            $client = new Client($account_sid, $auth_token);
           $message = $client->messages->create($recipients,
                ['from' => $twilio_number, 'body' => $message]);
            return false;

        } catch (ConfigurationException|RestException|TwilioConfigurationException|TwilioException $e) {
            Log::info($e->getMessage());
            return $e->getMessage();
        }
    }

    function sendWhatsappNotification($message, string $recipient): string
    {
        try {
            $twilio_whatsapp_number = config("twilio.whatsapp_config.TWILIO_WHATSAPP_NUMBER");
            $account_sid =config('twilio.whatsapp_config.TWILIO_ACCOUNT_SID');
            $auth_token = config("twilio.whatsapp_config.TWILIO_AUTH_TOKEN");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create("whatsapp:$recipient", ['from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message]);
            return false;
        } catch (ConfigurationException|RestException|TwilioConfigurationException|TwilioException $e) {
            return $e->getMessage();
        }
    }
}
