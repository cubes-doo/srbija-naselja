<?php

use PHPUnit\Framework\TestCase;

use CubesDoo\SrbijaNaselja\SrbijaNaseljaService;
use CubesDoo\SrbijaNaselja\BazaInterface;

final class SrbijaNaseljaServiceTest extends TestCase
{

    protected $testData = [
        'testPostanskiBroj' => 22310, //Simanovci
    ];

    /**
     * @covers SrbijaNaseljaService::__construct
     * @covers SrbijaNaseljaService::getInstance
     */
    public function testInstance()
    {
        $this->assertInstanceOf(SrbijaNaseljaService::class, SrbijaNaseljaService::getInstance());
    }

    /**
     * @covers SrbijaNaseljaService::getDefaultLanguage
     * @covers SrbijaNaseljaService::setDefaultLanguage
     */
    public function testDefaultLanguage()
    {
        $this->assertInstanceOf(SrbijaNaseljaService::class, SrbijaNaseljaService::getInstance()->setDefaultLang('sr_RS'));
        $this->assertEquals('sr_RS', SrbijaNaseljaService::getInstance()->getDefaultLang());
    }

    /**
     * @covers SrbijaNaseljaService::__call
     * @covers SrbijaNaseljaService::__callStatic
     */
    public function testProxyToBaza()
    {
        $testData = $this->testData;

        $this->assertIsArray(SrbijaNaseljaService::naselja());
        $this->assertIsArray(SrbijaNaseljaService::getInstance()->naselja());

        $this->assertIsArray(SrbijaNaseljaService::naselje($testData['testPostanskiBroj']));
        $this->assertIsArray(SrbijaNaseljaService::getInstance()->naselje($testData['testPostanskiBroj']));

        $this->assertIsArray(SrbijaNaseljaService::opstine());
        $this->assertIsArray(SrbijaNaseljaService::getInstance()->opstine());

        $this->assertIsArray(SrbijaNaseljaService::opstina($testData['testPostanskiBroj']));
        $this->assertIsArray(SrbijaNaseljaService::getInstance()->opstina($testData['testPostanskiBroj']));

        $this->assertIsArray(SrbijaNaseljaService::okruzi());
        $this->assertIsArray(SrbijaNaseljaService::getInstance()->okruzi());

        $this->assertIsString(SrbijaNaseljaService::okrug($testData['testPostanskiBroj']));
        $this->assertIsString(SrbijaNaseljaService::getInstance()->okrug($testData['testPostanskiBroj']));

        $this->assertInstanceOf(BazaInterface::class, SrbijaNaseljaService::lang('sr_RS'));
        $this->assertInstanceOf(BazaInterface::class, SrbijaNaseljaService::getInstance()->lang('sr_RS'));
        
        $this->assertEquals('sr_RS', SrbijaNaseljaService::getLang());
        $this->assertEquals('sr_RS', SrbijaNaseljaService::getInstance()->getLang());
    }

    /**
     * @covers SrbijaNaseljaService::latinica
     * @covers SrbijaNaseljaService::cirilica
     */
    public function testLatinicaCirilica()
    {
        $this->assertInstanceOf(SrbijaNaseljaService::class, SrbijaNaseljaService::getInstance()->latinica());
        $this->assertEquals('sr_RS', SrbijaNaseljaService::getLang());
        
        $this->assertInstanceOf(SrbijaNaseljaService::class, SrbijaNaseljaService::getInstance()->cirilica());
        $this->assertEquals('sr_Cyrl_RS', SrbijaNaseljaService::getLang());
    }
}