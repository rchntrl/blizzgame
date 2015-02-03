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
        'urlAuth' => 'https://eu.battle.net/oauth/authorize',
        'urlToken' => 'https://eu.battle.net/oauth/token',
        'redirect_uri' => 'http://www.blizzgame.ru/profile',
    );
    private $redirect_uri = 'http://www.blizzgame.ru/profile'; // Redirect URIs
    private $urlAuth = 'https://eu.battle.net/oauth/authorize';
    private $urlToken = 'https://eu.battle.net/oauth/token';
    /**
     * @var array
     */
    protected $config;

    public function init() {
        parent::init();
        $this->config = array_merge(self::$default_config, $this->config);
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
        $params = array(
            'client_id'     => $this->config['client_id'],
            'redirect_uri'  => $this->config['redirect_uri'],
            'response_type' => 'code',
            'grant_type' => 'authorization_code',
            'scope'         => 'sc2.profile,wow.profile'
        );
        $userInfo = null;
        $ssv = new SSViewer('Test');
        return $this->customise(array(
            'UserInfo' => json_encode($userInfo),
            'buttonLink' => $this->getConfig('urlAuth') . '?' . urldecode(http_build_query($params))
        ))->renderWith($ssv);
    }

    public function profile() {
        $userInfo = null;
        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $this->config['client_id'],
                'redirect_uri'  => $this->config['redirect_uri'],
                'client_secret' => $this->config['client_secret'],
                'code'          => $_GET['code']
            );
            $tokenInfo = null;
            parse_str(file_get_contents($this->getConfig('urlToken') . '?' . http_build_query($params)), $tokenInfo);

            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);
            }
            $userInfo = json_decode(file_get_contents('https://eu.api.battle.net/sc2/profile/user' . '?' . urldecode(http_build_query($params))), true);
        }
        $ssv = new SSViewer('Test');
        return $this->customise(array(
            'UserInfo' => json_encode($userInfo),
            'buttonLink' => 'ololosh'
        ))->renderWith($ssv);
    }
 }
