<?php
namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

Class Mail{

    private $api_key = '440bbe6e5df51e710df269125df3f936';
    private $api_key_secret = 'f8d0684ed770ee4aa64f023c42fd6e00';

    public function send($to_email, $to_name, $subject, $content)
    {
  
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "aloui.tlse@gmail.com",
                        'Name' => "Boutiquefrancaise"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 2100691,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;


    }
}