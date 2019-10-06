<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserHelper
{
    public function authenticate(string $url, array $data): array
    {
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => \json_encode([
                    'username' => $data['username'],
                    'password' => $data['password'],
                ]),
            ],
        ];
        $context = stream_context_create($opts);
        try {
            $response = file_get_contents($url, false, $context);
        } catch (\Exception $e) {
            throw new BadRequestHttpException();
        }
        $data = \json_decode($response, true);

        return $data;
    }
}