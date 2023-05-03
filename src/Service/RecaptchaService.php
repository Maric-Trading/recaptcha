<?php

namespace MaricTrading\Recaptcha\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RecaptchaService {
    public function __construct(
        private LoggerInterface $logger,
        #[AutoWire('%maric_trading.recaptcha.google_recpatcha_secret_key%')]
        private string $recaptchaSecretKey,
        #[AutoWire('%maric_trading.recaptcha.google_recpatcha_site_key%')]
        private string $recaptchaSiteKey,
        private HttpClientInterface $httpClient)
    {
    }

    public function verify(string $recaptchaToken): bool
    {
        $response = $this->httpClient->request(
            'POST',
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'body' => [
                    'secret' => $this->recaptchaSecretKey,
                    'response' => $recaptchaToken,
                ],
            ]
        );

        $content = $response->toArray();
        $this->logger->info('Recaptcha response', $content);

        return $content['success'] ?? false;
    }

    public function getSiteKey(): string
    {
        return $this->recaptchaSiteKey;
    }


}
