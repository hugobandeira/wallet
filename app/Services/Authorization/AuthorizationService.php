<?php

declare(strict_types=1);


namespace App\Services\Authorization;


use Illuminate\Support\Facades\Http;

/**
 * Class AuthorizationService
 *
 * @package App\Services\Authorization
 */
class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var string
     */
    private $baseUri;

    /**
     * AuthorizationService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('authorization.base_uri');
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isAuthorized(): bool
    {
        $response = Http::get($this->baseUri);
        if ($response->status() !== 200) {
            return false;
        }

        return $response->json()['message'] === "Autorizado" ?? false;
    }
}