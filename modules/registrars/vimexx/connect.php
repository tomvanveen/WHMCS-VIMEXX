<?php

/**
 * Class Vimexx_API
 */
class Vimexx_API
{
    /**
     * Set API login credentials
     *
     * @param $clientId
     * @param $clientKey
     * @param $username
     * @param $password
     * @param $apiUrl
     * @param $endpoint
     */
    function setApi_Login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint)
    {
        $this->loginclientid = $clientId;
        $this->loginclientkey = $clientKey;
        $this->loginusername = $username;
        $this->loginpassword = $password;
        $this->loginapiurl = rtrim($apiUrl, '/');
        $this->endpointcountry = $endpoint;
    }

    /**
     * Set API to debug mode
     */
    function setApi_debug()
    {
        $this->debug = true;
    }

    /**
     * Set API endpoint to live or test
     *
     * @param $testmodus
     */
    function setApi_testmodus($testmodus)
    {
        if ($testmodus == 'true') {
            $this->endpoint = $this->loginapiurl . '/apitest/v1';
        }else{
            $this->endpoint = $this->loginapiurl . '/api/v1';
        }
    }

    /**
     * Set the API output result
     *
     * @param $outputresult
     */
    function setApi_output($outputresult)
    {
        $this->output = $outputresult;
    }

    /**
     * Request an API token
     *
     * @return mixed
     */
    function requestAccessToken()
    {
        if (!isset($this->loginAuthToken) || empty($this->loginAuthToken)) {
            $data = array(
                'grant_type' => 'password',
                'client_id' => $this->loginclientid,
                'client_secret' => $this->loginclientkey,
                'username' => $this->loginusername,
                'password' => $this->loginpassword,
                'scope' => 'whmcs-access',
            );

            $url        = $this->loginapiurl . '/auth/token';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8'
            ]);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, "Vimexx-WHMCS api agent at ".gethostname());

            $response     = curl_exec($ch);

            curl_close($ch);

            $responseData = json_decode((string)$response, true);

            if (!empty($responseData)) {
                $this->loginAuthToken = $responseData['access_token'];
            }
        }

        return $this->loginAuthToken;
    }

    /**
     * Do API request
     *
     * @param $requesttype
     * @param $request
     * @param array $data
     * @param string $version
     * @return array|mixed|string
     */
    function request($requesttype, $request, $data = array(), $version = '')
    {
        $data = [
            'body'          => $data,
            'version'       => $version
        ];

        $accessToken = $this->requestAccessToken();

        if (empty($accessToken)) {
            $error = array();
            $error['error']['message']  = 'Request failed';

            return json_encode($error);
        }

        $url        = $this->endpoint . $request;

        $ch         = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requesttype);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Vimexx-WHMCS api agent at ".gethostname());

        $result     = curl_exec($ch);
        $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $debugdata      = array(
            'requesttype'   => $requesttype,
            'url'           => $url,
            'postdata'      => $data,
            'result'        => $result,
            'httpcode'      => $httpcode
        );

        logModuleCall('vimexx', 'API CALL: ' . $request, 'Request', $debugdata);

        if ($this->debug) {
            var_dump($debugdata);
        }

        $codes = array('200', '201', '202', '400', '401', '404');

        if ($this->output == 'json') {
            $result = json_decode($result, 1);
            var_dump($result);
            $result['httpcode'] = $httpcode;

            if (in_array($httpcode, $codes)) {
                return json_encode($result);
            } else {
                $error = array();
                $error['error']['message']  = 'Request failed';
                return json_encode($error);
            }
        } else {
            $result = json_decode($result, 1);
            $result['httpcode'] = $httpcode;

            if (in_array($httpcode, $codes)) {
                return $result;
            } else {
                $error = array();
                $error['error']['message']  = 'Request failed';
                return $error;
            }
        }
    }
}