<?php declare(strict_types=1);

namespace Application;

/**
 * ApiBaseClass contains all the common classes for interfacing with the Supermetrics test api
 * including getting a short-lived token, running CURL requests, and outputting data as valid 
 * JSON with headers.
 * Also contains all of our default values.
 */
class ApiBaseClass
{
    protected string $sl_token = '';
    protected string $apiUrl   = 'https://api.supermetrics.com/assignment/';
    protected string $userName = 'James Filby';
    protected string $email    = 'jim.deadcowdesign@gmail.com';
    protected string $clientId = 'ju16a6m81mhid5ue1z3v2g0uh';

    protected ?object $responseData = null;

    protected int $responseCode = 200;

    /**
     * getApiToken - retrieve a short-lived API token from the auth server.
     * Note that these tokens last for an hour. In this tech test we're just
     * going to ensure that we aren't getting a token error from the server,
     * and that our token is set to something.
     * TODO - look at whether we could cache this somewhere so we only need to
     * request it once it expires.
     *
     * @return string The API token from the auth server
     */
    protected function getSlToken() :string
    {
        $data = $this->runCurl(array('name' => $this->userName, 'email' => $this->email, 'client_id' => $this->clientId), true, 'register');
        $this->sl_token = $data->data->sl_token;

        return $this->sl_token;
    }

    /**
     * runCurl - run a curl request from the given parameters.
     * In production environments, this would be done in a separate class,
     * or an inherited parent, but for our purposes, we're just setting up 
     * a method to do this within the current class.
     *
     * @param array $params An array of params to be serialized and sent to the endpoint
     * @param boolean $isPost Use this to flag with the method we're sending a POST request
     * @param string $endpoint the url endpoint to send the request to. For security this should only be a fragment
     * @return object The resulting return from the curl. If this cannot be parsed as JSON, we return an empty object for our purposes here.
     */
    protected function runCurl(array $params = [], bool $isPost = true, string $endpoint) :object
    {
        $curlHandle = curl_init();
        $result     = new \StdClass();

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        // If we're sending POST data, set the appropriate CURL options.
        // If not build a query string from the parameters and attach it to
        // the endpoint string.
        if ($isPost === true) {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $params;

        } else {

            $endpoint = $endpoint . '?' . http_build_query($params);
        }

        $options[CURLOPT_URL] = $this->apiUrl . $endpoint;

        curl_setopt_array($curlHandle, $options);
        $data = curl_exec($curlHandle);

        curl_close($curlHandle);

        $decodedData = json_decode($data);

        // If we get back anything other than an object, something
        // isn't right.
        if (!gettype($decodedData) == 'object') {

            return new StdClass();

        } else {

            return $decodedData;
        }
    }

    /**
     * doResponse - given a data object, json encode it and return appropriate
     * format and headers.
     *
     * @param object $data
     * @return string
     */
    public function doResponse() :void
    {
        header('Content-type: application/json');
        http_response_code($this->responseCode);
        echo json_encode($this->responseData);
        exit();
    }
}