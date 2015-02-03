<?php


/**
 * AuthController
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
        'authorize_uri ' => 'https://eu.battle.net/oauth/authorize',
        'token_uri' => 'https://eu.battle.net/oauth/token',
        'redirect_uri' => 'http://www.blizzgame.ru/auth/profile/',
    );

    /**
     * @var array
     */
    protected $config = array();

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
        $params = array(
            'client_id'     => $this->config['client_id'],
            'redirect_uri'  => urldecode($this->config['redirect_uri']),
            'response_type' => 'code',
            'auth_flow'     => 'auth_code',
            'scope'         => 'wow.profile+sc2.profile'
        );
        /*
         * https://eu.battle.net/oauth/authorize?
         * client_id=y23hvpnwpegfkgdxm54ab7m42uwd9sar
         * redirect_uri=https%3A%2F%2Fdev.battle.net%2Fio-docs%2Foauth2callback
         * response_type=code
         * scope=wow.profile+sc2.profile"
        */
        $userInfo = null;
        $ssv = new SSViewer('Test');
        return $this->customise(array(
            'UserInfo' => json_encode($userInfo),
            'buttonLink' => $this->getConfig('authorize_uri') . '?' . urldecode(http_build_query($params))
        ))->renderWith($ssv);
    }

    public function profile() {
        $userInfo = null;
        $tokenInfo = null;
        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $this->config['client_id'],
                'redirect_uri'  => $this->config['redirect_uri'],
                'client_secret' => $this->config['client_secret'],
                'code'          => $_GET['code'],
            );
            parse_str(file_get_contents($this->getConfig('token_uri') . '?' . http_build_query($params)), $tokenInfo);

            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);
            }
            $userInfo = json_decode(file_get_contents('https://eu.api.battle.net/sc2/profile/user' . '?' . urldecode(http_build_query($params))), true);
        }
        $ssv = new SSViewer('Test');
        return $this->customise(array(
            'UserInfo' => json_encode($tokenInfo),
            'buttonLink' => 'ololosh'
        ))->renderWith($ssv);
    }
 }
