<?php
/**
 * Created by PhpStorm.
 * User: Nurullah I��k
 * Date: 31.01.2019
 * Time: 09:22
 */

namespace ParamposLibrary;


/**
 * Class Config
 * @package ParamposLibrary
 */
class Config
{
    /**
     * @var
     */
    public $clientCode;
    /**
     * @var
     */
    public $clientUsername;
    /**
     * @var
     */
    public $clientPassword;
    /**
     * @var
     */
    public $guid;
    /**
     * @var
     */
    public $mode;

    /**
     *
     */
    public function set()
    {
        $config = [
            'clientCode'     => '10738',
            'clientUsername' => 'Test',
            'clientPassword' => 'Test',
            'guid'           => '0c13d406-873b-403b-9c09-a5766840d98c',
            'mode'           => 'TEST'
        ];

        $this->clientCode     = $config['clientCode'];
        $this->clientUsername = $config['clientUsername'];
        $this->clientPassword = $config['clientPassword'];
        $this->guid           = $config['guid'];
        $this->mode           = $config['mode'];
    }
}