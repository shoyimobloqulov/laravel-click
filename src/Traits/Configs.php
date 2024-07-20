<?php

namespace Shoyim\Click\Helpers;

/**
 * Configs class to get configuration values.
 */
class Configs
{
    /**
     * Get provider configs from environment or configuration file.
     *
     * @return array
     */
    public function getProviderConfigs(): array
    {
        return [
            'endpoint' => env('CLICK_ENDPOINT', 'https://api.click.uz/v2/merchant/')
        ];
    }
}
