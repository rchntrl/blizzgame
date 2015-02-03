<?php


/**
 * AuthController
 * Wraps around Opauth for handling callbacks.
 * The SS equivalent of "index.php" and "callback.php" in the Opauth package.
 * @author Will Morgan <@willmorgan>
 * @author Dan Hensby <@dhensby>
 * @copyright Copyright (c) 2013, Better Brief LLP
 */
class AuthController extends Controller {

    private static $allowed_actions = array(
        'getoauth2authuri',
        'test',
        'profile',
        'RegisterForm',
    );

    private static $default_config = array(
        'client_id' => '',
        'client_secret' => '',

    );

    /**
     * @var array
     */
    protected $config;

    public function init() {
        parent::init();
        $this->config = $this->config()->default_config;
    }

    public function setConfig($name, $val) {
        $this->config[$name] = $val;
        return $this;
    }

    public function getConfig($name = null) {
        if($name) {
            return isset($this->config[$name]) ? $this->config[$name] : null;
        } else {
            return $this->config;
        }
    }

    public function test() {
        $redirect_uri = 'http://localhost/blizzgame/profile'; // Redirect URIs
        $urlAuth = 'https://eu.battle.net/oauth/authorize';
        $urlToken = 'https://eu.battle.net/oauth/token';
        $params = array(
            'client_id'     => $this->config['client_id'],
            'redirect_uri'  => $redirect_uri,
            'response_type' => 'code',
            'scope'         => 'sc2.profile,wow.profile'
        );
        $userInfo = null;
        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $this->client_id,
                'redirect_uri'  => $redirect_uri,
                'client_secret' => $this->config['client_secret'],
                'code'          => $_GET['code']
            );

            $tokenInfo = null;
            parse_str(file_get_contents($urlToken . '?' . http_build_query($params)), $tokenInfo);

            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);
            }
            $userInfo = json_decode(file_get_contents('https://eu.api.battle.net/sc2/profile/user' . '?' . urldecode(http_build_query($params))), true);
        }
        $ssv = new SSViewer('Test');
        return $this->customise(array(
            'UserInfo' => $userInfo,
            'buttonLink' => $urlAuth . '?' . urldecode(http_build_query($params))
        ))->renderWith($ssv);
    }

    public function getoauth2authuri() {


    }

    public function profile() {
        return "не хихикай!";
    }
 }
