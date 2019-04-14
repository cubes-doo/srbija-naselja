<?php

namespace CubesDoo\SrbijaNaselja;

/**
 * @method mixed lang(string $lang)
 * @method array naselja()
 * @method string naselje($postanskiBroj)
 * @method array opstine()
 * @method array opstina($postanskiBroj)
 * @method string[] okruzi()
 * @method string okrug($postanskiBroj)
 */
class SrbijaNaseljaService
{
    /**
     * @var SrbijaNaseljaService
     */
    protected static $instance;

    /**
     * @var BazaInterface
     */
    protected $baza;

    /**
     * @var string
     */
    protected $defaultLang = 'sr_Cyrl_RS';

    /**
     * Not singleton but for static call api
     * 
     * @return SrbijaNaseljaService
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return BazaInterface
     */
    protected function getBaza()
    {
        if (!$this->baza) {
            $this->baza = new BazaArray($this->getDefaultLang());
        }

        return $this->baza;
    }

    /**
     * @param BazaInterface $baza - Baza sa podacima o naseljima
     * @return SrbijaNaseljaService
     */
    public function setBaza(BazaInterface $baza)
    {
        $this->baza = $baza;

        return $this;
    }

    /**
     * @return string $defaultLang 
     */ 
    public function getDefaultLang()
    {
        return $this->defaultLang;
    }

    /**
     * @param string $defaultLang;
     * @return  SrbijaNaseljaService
     */ 
    public function setDefaultLang($defaultLang)
    {
        $this->defaultLang = $defaultLang;
        
        return $this;
    }

    /**
     * Setuje se jezik na cirilicu
     * @return SrbijaNaseljaService
     */
    public function cirilica()
    {
        $this->getBaza()->lang('sr_Cyrl_RS');

        return $this;
    }

    /**
     * Setuje se jezik na latinicu
     * @return SrbijaNaseljaService
     */
    public function latinica()
    {
        $this->getBaza()->lang('sr_RS');

        return $this;
    }

    /**
     * Omoguciti poziv regularnigh funkcija kroz staticku instancu
     * Na primer: SrbijaNaseljaService::setDefaultLang()
     */
    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();

        return call_user_func_array([$instance, $name], $arguments);
    }

    /**
     * Ako funkcija nije dostupna pokusaj da zoves nad samom bazom,
     * u kombinaciji sa __callStatic dobija se API bez instanciranja kao na primer:
     * 
     * SrbijaNaseljaService::naselja()
     * SrbijaNaseljaService::opstine()
     * SrbijaNaseljaService::okruzi()
     */
    public function __call($name, $arguments)
    {
        $baza = $this->getBaza();

        return call_user_func_array([$baza, $name], $arguments);
    }
}