<?php
namespace Huifang\Domain\Auth;

use Huifang\Supports\CryptUtil;

class AuthService
{
    public function getAccountApiData($config)
    {
        $method = $config['method'];
        $uri = getenv('ACCOUNT_API_SYSTEM_URL') . $config['uri'];
        $query = $config['query'] ?? [];
        $form_params = $config['form_params'] ??  [];
        $debug = $config['debug'] ?? 0;

        $client = new \GuzzleHttp\Client();
        $return_data = [];

        $res = $client->get(
            $uri,
            [
                'headers' => ['App-Key' => getenv('ACCOUNT_APP_KEY')],
                'debug'   => $debug,
                'query'   => $query,
            ]
        );

        $return_data['http_code'] = $res->getStatusCode();
        $return_string_body = $res->getBody()->getContents();

        if (isset($config['is_json_decode']) && $config['is_json_decode'] == true) {
            $return_data['data'] = json_decode($return_string_body, 1);
        } else {
            $return_data['data'] = $return_string_body;
        }
        return $return_data;
    }

    public function decodeToken($token)
    {
        return CryptUtil::cryptDecode($token);
    }

    public function encodeToken($data = [])
    {
        return CryptUtil::cryptEncode($data);
    }
}
