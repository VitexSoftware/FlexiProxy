<?php
/**
 * FlexiProxy - menu.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2017 Vitex Software
 */

namespace FlexiProxy\ui;

class BootstrapMenu extends \Ease\TWB\Navbar
{
    /**
     * Navigace.
     *
     * @var \Ease\Html\UlTag
     */
    public $nav = null;

    /**
     * Hlavní menu aplikace.
     *
     * @param string $name
     * @param mixed  $content
     * @param array  $properties
     */
    public function __construct($name = null, $content = null,
                                $properties = null)
    {
        $cfglogo = \Ease\Shared::instanced()->getConfigValue('logo');
        $newLogo = is_null($cfglogo) ? '/images/logo-flexiproxy.png' : $cfglogo;

        parent::__construct('Menu',
            new \Ease\Html\ImgTag($newLogo, 'FlexiProxy',
            ['class' => 'img-rounded', 'height' => '20px']),
            ['class' => 'navbar-fixed-top']);

        $user = \Ease\Shared::user();
        \Ease\TWB\Part::twBootstrapize();
        if (!$user->getUserID()) {
            if (get_class($user) != 'EaseAnonym') {
                $this->addMenuItem(new \Ease\Html\ATag('about.php', _('About')),
                    'right');

                if (\Ease\Shared::instanced()->getConfigValue('access_policy') == 'login') {


                    $this->addMenuItem(
                        '
<li class="divider-vertical"></li>
<li class="dropdown">
<a class="dropdown-toggle" href="login.php" data-toggle="dropdown"><i class="icon-circle-arrow-left"></i> '._('Sign in').'<strong class="caret"></strong></a>
<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px; left: -160px;">
<form method="post" class="navbar-form navbar-left" action="login.php" accept-charset="UTF-8">
<input style="margin-bottom: 15px;" type="text" placeholder="'._('Server').'" id="server" name="server">
<input style="margin-bottom: 15px;" type="text" placeholder="'._('login').'" id="username" name="login">
<input style="margin-bottom: 15px;" type="password" placeholder="'._('Password').'" id="password" name="password">
<input style="float: left; margin-right: 10px;" type="checkbox" name="remember-me" id="remember-me" value="1">
<label class="string optional" for="remember-me"> '._('Remeber me').'</label>
<input class="btn btn-primary btn-block" type="submit" id="sign-in" value="'._('Sign in').'">
</form>
</div>', 'right'
                    );
                } else {
                    $this->addMenuItem(new \Ease\TWB\Label('success',
                        _('Public Access')
                        ), 'right');
                }
            }
        } else {
            $userMenu = '<li class="dropdown" style="width: 120px; text-align: right;"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION['user'].' <b class="caret"></b></a>
<ul class="dropdown-menu" style="text-align: left; left: -60px;">
<li><a href="settings.php">'.\Ease\TWB\Part::GlyphIcon('wrench').'<i class="icon-cog"></i> '._('Settings').'</a></li>
';

            $this->addMenuItem($userMenu.'
<li><a href="about.php">'.\Ease\TWB\Part::GlyphIcon('info-sign').' '._('About').'</a></li>
<li class="divider"></li>
<li><a href="logout.php">'.\Ease\TWB\Part::GlyphIcon('off').' '._('Sign off').'</a></li>
</ul>
</li>
', 'right');
        }
    }

    /**
     * Show status messages
     */
    public function draw()
    {
        $statusMessages = self::webPage()->getStatusMessagesAsHtml();
        if ($statusMessages) {
            $this->addItem(new \Ease\Html\DivTag($statusMessages,
                ['id' => 'StatusMessages', 'class' => 'well', 'title' => _('Click to hide messages'),
                'data-state' => 'down']));
            $this->addItem(new \Ease\Html\DivTag(null, ['id' => 'smdrag']));
            $this->webPage->cleanMessages();
        }
        parent::draw();
    }

}
