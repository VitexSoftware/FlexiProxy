<?php
namespace FlexiProxy\ui;

/**
 * Description of WebPage
 *
 * @author vitex
 */
class WebPage extends \Ease\TWB\WebPage
{
    /**
     * FlexiProxy Engine
     * @var \FlexiProxy\FlexiProxy
     */
    public $flexi     = null;

    /**
     * Main block of page.
     *
     * @var \Ease\Html\DivTag
     */
    public $container = null;

    /**
     * First column.
     *
     * @var \Ease\Html\DivTag
     */
    public $columnI = null;

    /**
     * Druhý sloupec.
     *
     * @var \Ease\Html\DivTag
     */
    public $columnII = null;

    /**
     * Třetí sloupec.
     *
     * @var \Ease\Html\DivTag
     */
    public $columnIII = null;

    /**
     * Základní objekt stránky.
     *
     * @param VSUser $userObject
     */
    public function __construct($pageTitle = null, &$userObject = null)
    {
        if (is_null($userObject)) {
            $userObject = \Ease\Shared::user();
        }
        parent::__construct($pageTitle, $userObject);
        $this->includeCss('/css/flexiproxy.css');
        $this->head->addItem('<meta name="viewport" content="width=device-width, initial-scale=1.0">');
        $this->head->addItem('<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico">');
        $this->head->addItem('<link rel="apple-touch-icon-precomposed"  type="image/png" href="images/flexplorer-logo.png">');
        $this->head->addItem('<link rel="stylesheet" href="/javascript/font-awesome/css/font-awesome.min.css">');
        $this->container = $this->addItem(new \Ease\TWB\Container());
        $this->includeJavaScript('/js/jquery.keepAlive.js');
        $this->addJavaScript('$.fn.keepAlive({timer: 300000});');
    }

    /**
     * Only for admin.
     *
     * @param string $loginPage
     */
    public function onlyForAdmin($loginPage = 'login.php')
    {
        if (!$this->user->getSettingValue('admin')) {
            \Ease\Shared::user()->addStatusMessage(_('Please sign in as admin first'),
                'warning');
            $this->redirect($loginPage);
        }
    }

    /**
     * Nepřihlášeného uživatele přesměruje na přihlašovací stránku.
     *
     * @param string $loginPage adresa přihlašovací stránky
     */
    public function onlyForLogged($loginPage = 'login.php')
    {
        if (\Ease\Shared::instanced()->getConfigValue('access_policy') == 'login') {
            parent::onlyForLogged($loginPage.'?backurl='.urlencode($_SERVER['REQUEST_URI']));
        }
    }
}
    