<?php
use micro\controllers\BaseController;
use micro\utils\RequestUtils;
use micro\orm\DAO;
class Git extends BaseController{
	private $siteUrl;
	private $authorizeURL;
	private $tokenURL;
	private $apiURLBase;
	const OAUTH2_CLIENT_ID='57648373b213ee9';
	const OAUTH2_CLIENT_SECRET='eb461c89c61e6772261b97372905';

	/* (non-PHPdoc)
	 * @see \micro\controllers\BaseController::__construct()
	 */
	public function __construct() {
		global $config;
		parent::__construct();
		$this->siteUrl=$config["siteUrl"];
		$this->authorizeURL = 'https://github.com/login/oauth/authorize';
		$this->tokenURL = 'https://github.com/login/oauth/access_token';
		$this->apiURLBase = 'https://api.github.com/';
	}

	public function login(){
		// Start the login process by sending the user to Github's authorization page
			// Generate a random hash and store in the session for security
			$_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
			unset($_SESSION['access_token']);
			$params = array(
					'client_id' => self::OAUTH2_CLIENT_ID,
					'redirect_uri' => $this->siteUrl."git/callback",
					'scope' => 'user',
					'state' => $_SESSION['state']
			);
			// Redirect the user to Github's authorization page
			header('Location: ' . $this->authorizeURL . '?' . http_build_query($params));
			die();
	}
	/* (non-PHPdoc)
	 * @see \micro\controllers\BaseController::index()
	 */
	public function index(){

	}
	public function callback() {
		// When Github redirects the user back here, there will be a "code" and "state" parameter in the query string
		if($this->get('code')) {
			// Verify the state matches our stored state
			if(!$this->get('state') || $_SESSION['state'] != $this->get('state')) {
				$this->_showMessage("States doesn't match !","warning");
				die();
			}
			// Exchange the auth code for a token
			$token = $this->apiRequest($this->tokenURL, array(
					'client_id' => self::OAUTH2_CLIENT_ID,
					'client_secret' => self::OAUTH2_CLIENT_SECRET,
					'redirect_uri' => $this->siteUrl."git/callback",
					'state' => $_SESSION['state'],
					'code' => $this->get('code')
			));
			$_SESSION['access_token'] = $token->access_token;
			header('Location: '.$this->siteUrl.'git/callback');
		}
		if($this->session('access_token')) {
			try{
				$user = $this->apiRequest($this->apiURLBase . 'user');
				$dbUser=DAO::getOne("User", array("login"=>$user->login,"gitId"=>$user->id));
				if($dbUser==NULL){
					$dbUser=new User();
					$dbUser->setLogin($user->login);
					$dbUser->setGitId($user->id);
					$dbUser->setMail($user->email);
					DAO::insert($dbUser);
				}
				$_SESSION["user"]=$dbUser;
				echo '<h3>Connecté à gitHub</h3>';
				echo '<h4>' . $user->login . '</h4>';
				echo '<div class="row"><div class="col-xs-6 col-md-3"><a href="#" class="thumbnail"><img style="width: 230px;height:230px;" src="'.$user->avatar_url.'&s=460" alt="avatar" width="230" height="230"></a></div></div>';
			}catch (Exception $e){
				$this->_showMessage($user->message,"warning");
			}
		} else {
			echo '<h3>Non connecté à gitHub</h3>';
			echo '<p><a class="btn btn-primary" href="git/login">Connexion à gitHub</a></p>';
		}
	}

	/* (non-PHPdoc)
	 * @see BaseController::initialize()
	 */
	public function initialize() {
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vHeader",array("infoUser"=>Auth::getInfoUser()));
			echo "<div class='container'>";
			echo "<h1>Connexion</h1>";
		}
	}

	/* (non-PHPdoc)
	 * @see BaseController::finalize()
	 */
	public function finalize() {
		if(!RequestUtils::isAjax()){
			echo "</div>";
			$this->loadView("main/vFooter");
		}
	}

	private function apiRequest($url, $post=FALSE, $headers=array()) {
		try{
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			if($post)
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			$headers[] = 'Accept: application/json';
			$headers[] = 'User-Agent: jcheron';
			if($this->session('access_token'))
				$headers[] = 'Authorization: Bearer ' . $this->session('access_token');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			if (FALSE === $response)
				throw new Exception(curl_error($ch), curl_errno($ch));

		} catch(Exception $e) {

			trigger_error(sprintf(
			'Curl failed with error #%d: %s',
			$e->getCode(), $e->getMessage()),
			E_USER_ERROR);

		}
		return json_decode($response);
	}
	private function get($key, $default=NULL) {
		return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
	}
	private function session($key, $default=NULL) {
		return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	}
	public function _showMessage($message,$type="success",$timerInterval=0,$dismissable=true,$visible=true){
		$this->loadView("main/vInfo",array("message"=>$message,"type"=>$type,"dismissable"=>$dismissable,"timerInterval"=>$timerInterval,"visible"=>$visible));
	}
}
