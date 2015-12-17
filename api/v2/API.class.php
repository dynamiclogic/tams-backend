<?php
require_once 'API.abstract.class.php';
require_once 'GetAsset.class.php';
require_once 'DeleteAsset.class.php';
require_once 'CreateAsset.class.php';
require_once 'UpdateAsset.class.php';

class API extends AbstractAPI
{
    protected $User;

    public function __construct($request, $origin) {
        parent::__construct($request);

        // Abstracted out for example
        /*$APIKey = new Models\APIKey();
        $User = new Models\User();

        if (!array_key_exists('apiKey', $this->request)) {
            throw new Exception('No API Key provided');
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            throw new Exception('Invalid API Key');
        } else if (array_key_exists('token', $this->request) &&
             !$User->get('token', $this->request['token'])) {

            throw new Exception('Invalid User Token');
        }

        $this->User = $User;*/
    }

    /**
     * Get Assets Endpoint
     */
     protected function asset() {
        if ($this->method == 'GET') {
            $asset = new GetAsset();

            if ($this->verb == 'get') {
                if ($this->args[0] == null)
                    return "Asset ID is required";
                else
                    return $asset->processGetAsset($this->args[0]);
            } 
            elseif ($this->verb == 'list') {
                return $asset->processGetAsset();
            } 
            else {
                return "Unknown Operation";
            }

        } elseif ($this->method == 'POST') {
            if ($this->verb == 'create') {
                $create = new CreateAsset();
                parse_str($this->file, $post);
                //error_log($post['assets']);
                return $create->processCreate(json_decode($post['assets']));
            } elseif ($this->verb == 'update') {
                $update = new UpdateAsset();
                parse_str($this->file, $post);
                return $update->processUpdate(json_decode($post['assets']));
            } else {
                return "Unknown Operation";
            }

        } elseif ($this->method == 'PUT') {
            $delete = new DeleteAsset();
            if ($this->verb == 'delete') {
                parse_str($this->file, $post);
                return $delete->processDeleteAsset(json_decode($post['assets']));
            } else {
                return "Unknown Operation";
            }

        } else {
            return "Only accepts GET/POST/PUT requests";
        }
     }
 }
