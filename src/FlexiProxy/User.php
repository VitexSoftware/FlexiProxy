<?php
/**
 * FlexiProxy - User Object.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2017 Vitex Software
 */

namespace FlexiProxy;

/**
 * Description of User
 *
 * @author vitex
 */
class User extends \Ease\User
{
    /**
     * AbraFlexi Helper
     * @var \AbraFlexi\RO 
     */
    public $flexiBee = null;

    /**
     * Sloupeček s loginem.
     *
     * @var string
     */
    public $nameColumn = 'login';

    /**
     * Uživatel autentizovaný vůči flexibee
     * @param int $userID
     */
    public function __construct($userID = null)
    {
        parent::__construct();
        $this->flexiBee = new \AbraFlexi\RO();
//        $this->flexiBee->setEvidence('uzivatel');
    }

    /**
     * Perform logIn action
     * 
     * @param array $creds
     * @return boolean
     */
    public function tryToLogin($creds)
    {
        $loginStatus          = false;
        $this->flexiBee->disconnect();
        $this->flexiBee->user = trim($creds['login']);

        $this->flexiBee->password = $creds['password'];
        $this->flexiBee->company  = null;
        $this->flexiBee->prefix   = null;
        $this->flexiBee->curlInit();
        
        $companies                = $this->flexiBee->performRequest('/c.json');
        if (isset($companies['companies'])) {
            if (isset($companies['companies']['company'][0]['dbNazev'])) {
                $this->flexiBee->company = $companies['companies']['company'][0]['dbNazev'];
            } else {
                $this->flexiBee->company = $companies['companies']['company']['dbNazev'];
            }
            $this->setMyKey(true);
            $loginStatus = $this->loginSuccess();
        } else {
            $this->addStatusMessage(_('Login Failed'), 'warning');
        }
        return $loginStatus;
    }

    /**
     * Provede přihlášení uživatele
     * 
     * @return type
     */
    public function loginSuccess()
    {
        $_SESSION['user']     = $this->flexiBee->user;
        $_SESSION['password'] = $this->flexiBee->password;
        $_SESSION['company']  = $this->flexiBee->company;
        $_SESSION['url']      = $this->flexiBee->url;

        $this->flexiBee->setEvidence('');
        $this->flexiBee->setCompany('');
        $licenseInfo         = $this->flexiBee->performRequest('default-license.json');
        $_SESSION['license'] = $licenseInfo['license'];

        $lister    = new \AbraFlexi\EvidenceList(null, $_SESSION);
        $flexidata = $lister->getFlexiData();

        if (count($flexidata) && isset($flexidata['evidences']['evidence'])) {
            foreach ($flexidata['evidences']['evidence'] as $evidence) {
                $evidenciesToMenu['evidence.php?evidence='.$evidence['evidencePath']]
                    = $evidence['evidenceName'];
            }
            asort($evidenciesToMenu);
            $_SESSION['evidence-menu'] = $evidenciesToMenu;
        } else {
            $lister->addStatusMessage(_('Loading evidence list failed'), 'error');
        }

        return parent::loginSuccess();
    }
}