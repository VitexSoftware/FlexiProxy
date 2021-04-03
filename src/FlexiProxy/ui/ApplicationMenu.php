<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FlexiProxy\ui;

/**
 * Description of ApplicationMenu
 *
 * @author vitex
 */
class ApplicationMenu extends \Ease\Html\DivTag
{
    //put your code here
    public function __construct($company)
    {
        $this->company = $company;
        parent::__construct(null,
            ['id' => 'sidebar', 'class' => 'flexibee-aplication-menu column sidebar-offcanvas hidden-xs']);
        $this->addItem($this->largeMenu());
        $this->addItem($this->tinyNav());
    }

    public function largeMenu()
    {

        return '
    <div class="" id="lg-menu">
	    <ul class="nav">
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-obchPartneri">
                        <span class="icon icon-obch-partneri"></span>
                            Obchodní partneři
                    </a>
                    <ul id="collapse-obchPartneri" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/adresar?filter%5BtypVztahuK%5D=typVztahu.odberDodav">Adresy firem</a></li>
                                    <li><a href="/c/'.$this->company.'/kontakt">Kontakty</a></li>
                                    <li><a href="/c/'.$this->company.'/udalost">Události, aktivity</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=obchPartneri_dalsi">Další</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-zbozi">
                        <span class="icon icon-zbozi"></span>
                            Zboží
                    </a>
                    <ul id="collapse-zbozi" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/cenik">Ceník</a></li>
                                    <li><a href="/c/'.$this->company.'/skladovy-pohyb">Příjemky/výdejky</a></li>
                                    <li><a href="/c/'.$this->company.'/skladova-karta">Skladové karty</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=zbozi_dalsi">Další</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-prodej">
                        <span class="icon icon-prodej"></span>
                            Prodej
                    </a>
                    <ul id="collapse-prodej" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/faktura-vydana">Vydané faktury</a></li>
                                    <li><a href="/c/'.$this->company.'/objednavka-prijata">Přijaté objednávky</a></li>
                                    <li><a href="/c/'.$this->company.'/nabidka-vydana">Vydané nabídky</a></li>
                                    <li><a href="/c/'.$this->company.'/poptavka-prijata">Přijaté poptávky</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=prodej_dalsi">Další</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=prodej_typ">Typy dokladů</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=prodej_rada">Dokladové řady</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-nakup">
                        <span class="icon icon-nakup"></span>
                            Nákup
                    </a>
                    <ul id="collapse-nakup" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/faktura-prijata">Přijaté faktury</a></li>
                                    <li><a href="/c/'.$this->company.'/objednavka-vydana">Vydané objednávky</a></li>
                                    <li><a href="/c/'.$this->company.'/nabidka-prijata">Přijaté nabídky</a></li>
                                    <li><a href="/c/'.$this->company.'/poptavka-vydana">Vydané poptávky</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=nakup_typ">Typy dokladů</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=nakup_rada">Dokladové řady</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-penize">
                        <span class="icon icon-penize"></span>
                            Peníze
                    </a>
                    <ul id="collapse-penize" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/pokladni-pohyb">Pokladna</a></li>
                                    <li><a href="/c/'.$this->company.'/banka">Banka</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=penize_dalsi">Další</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=penize_typ">Typy dokladů</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=penize_rada">Dokladové řady</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-majetek">
                        <span class="icon icon-majetek"></span>
                            Majetek
                    </a>
                    <ul id="collapse-majetek" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/majetek">Majetek</a></li>
                                    <li><a href="/c/'.$this->company.'/leasing">Leasing</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=majetek_dalsi">Další</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-ucetnictvi">
                        <span class="icon icon-ucetnictvi"></span>
                            Účetnictví
                    </a>
                    <ul id="collapse-ucetnictvi" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/interni-doklad">Interní doklady</a></li>
                                    <li><a href="/c/'.$this->company.'/pohledavka">Ostatní pohledávky</a></li>
                                    <li><a href="/c/'.$this->company.'/zavazek">Ostatní závazky</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=ucetnictvi_uctovani">Nastavení účtování</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=ucetnictvi_vystupy">Účetní výstupy</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=ucetnictvi_rada">Dokladové řady</a></li>
                                    <li><a href="/c/'.$this->company.'?menu=ucetnictvi_typ">Typy dokladů</a></li>
                    </ul>
            </li>
		        <li>
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-dashboard">
                        <span class="icon icon-dashboard"></span>
                            Přehledy
                    </a>
                    <ul id="collapse-dashboard" class="nav panel-collapse collapse">
                                    <li><a href="/c/'.$this->company.'/dashboard-panel/1">Základní přehled</a></li>
                                    <li><a href="/c/'.$this->company.'/dashboard-panel/2">Analytický přehled</a></li>
                    </ul>
            </li>
            <li class="flexibee-application-menu-noseparate"><a href="/c/'.$this->company.'?menu=nastroje"><span class="icon icon-nastaveni-large"></span> Nástroje</a></li>
        </ul>
        </div>
        ';
    }

    public function tinyNav()
    {

            return '
        <!-- tiny only nav-->
      <ul class="nav hide" id="xs-menu">
		        <li><a href="/c/'.$this->company.'?menu=obchPartneri">
                      <span class="icon icon-obch-partneri"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=zbozi">
                      <span class="icon icon-zbozi"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=prodej">
                      <span class="icon icon-prodej"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=nakup">
                      <span class="icon icon-nakup"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=penize">
                      <span class="icon icon-penize"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=majetek">
                      <span class="icon icon-majetek"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=ucetnictvi">
                      <span class="icon icon-ucetnictvi"></span></a></li>
		        <li><a href="/c/'.$this->company.'?menu=dashboard">
                      <span class="icon icon-dashboard"></span></a></li>
            <li class="flexibee-application-menu-noseparate"><a href="/c/'.$this->company.'?menu=nastroje"><i class="glyphicon glyphicon-cog"></i></a></li>
        </ul>';
        }
    }
