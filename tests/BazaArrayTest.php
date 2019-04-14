<?php

use PHPUnit\Framework\TestCase;

use CubesDoo\SrbijaNaselja\BazaArray;

final class BazaArrayTest extends TestCase
{
    protected $testData = [
        'sr_Cyrl_RS' => [
            'testNaselje' => "Шимановци",
            'testPostanskiBroj' => 22310,
            'testOkrug' => "Сремски округ",
            'testOpstina' => "Пећинци",
            'testOpstinaPostanskiBroj' => 22410, //Postanski broj opstine Pecnaca je dugaciji u odnosu na naselje Simanovci
            
        ],
        'sr_RS' => [
            'testNaselje' => "Šimanovci",
            'testPostanskiBroj' => 22310,
            'testOkrug' => "Sremski okrug",
            'testOpstina' => "Pećinci",
            'testOpstinaPostanskiBroj' => 22410, //Postanski broj opstine Pecnaca je dugaciji u odnosu na naselje Simanovci
            
        ]
    ];
    
    /**
     * @var BazaArray
     */
    protected $baza;

    /**
     * @before
     */
    public function setBaza()
    {
        $this->baza = new BazaArray();
    }

    /**
     * @covers BazaArray::__construct
     */
    public function testMozeDaSeKreira(): void
    {
        $this->assertInstanceOf(
            BazaArray::class,
            new BazaArray()
        );
    }

    /**
     * @covers BazaArray::__construct
     */
    public function testMozeDaSeKreiraSaLatinicom(): void
    {
        $this->assertInstanceOf(
            BazaArray::class,
            new BazaArray('sr_RS')
        );
    }

    /**
     * @covers BazaArray::__construct
     */
    public function testMozeDaSeKreiraSaCirilicom(): void
    {
        $this->assertInstanceOf(
            BazaArray::class,
            new BazaArray('sr_Cyrl_RS')
        );
    }

    /**
     * @covers BazaArray::__construct
     */
    public function testNeMozeDaSeKreiraSaJezikomKojiNijePodrzan(): void
    {
        $this->expectException(\RuntimeException::class);

        new BazaArray('invalid');
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::naselja
     */
    public function testNaselja() : void
    {
        $naselja = $this->baza->naselja();
        
        $this->assertIsArray($naselja);
        $this->assertNotEmpty($naselja);

        foreach ($naselja as $naselje) {
            $this->assertArrayHasKey('naselje', $naselje);
            $this->assertIsString($naselje['naselje']);
            $this->assertNotEmpty($naselje['naselje']);
            $this->assertArrayHasKey('postanski_broj', $naselje);
            $this->assertIsInt($naselje['postanski_broj']);
            $this->assertNotEmpty($naselje['postanski_broj']);
            $this->assertArrayHasKey('okrug', $naselje);
            $this->assertIsString($naselje['okrug']);
            $this->assertNotEmpty($naselje['okrug']);
            $this->assertArrayHasKey('opstina', $naselje);
            $this->assertIsString($naselje['opstina']);
            $this->assertNotEmpty($naselje['opstina']);
        }
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::naselje
     */
    public function testNaselje()
    {
        $testData = $this->testData[$this->baza->getLang()];
        $naselje = $this->baza->naselje($testData['testPostanskiBroj']);

        $this->assertArrayHasKey('naselje', $naselje);
        $this->assertEquals($testData['testNaselje'], $naselje['naselje']);
        $this->assertArrayHasKey('postanski_broj', $naselje);
        $this->assertEquals($testData['testPostanskiBroj'], $naselje['postanski_broj']);
        $this->assertArrayHasKey('okrug', $naselje);
        $this->assertEquals($testData['testOkrug'], $naselje['okrug']);
        $this->assertArrayHasKey('opstina', $naselje);
        $this->assertEquals($testData['testOpstina'], $naselje['opstina']);
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::opstine
     */
    public function testOpstine() : void
    {
        $opstine = $this->baza->opstine();
        
        $this->assertIsArray($opstine);
        $this->assertNotEmpty($opstine);
        
        foreach ($opstine as $opstina) {
            $this->assertArrayHasKey('postanski_broj', $opstina);
            $this->assertNotEmpty($opstina['postanski_broj']);
            $this->assertIsInt($opstina['postanski_broj']);
            $this->assertArrayHasKey('okrug', $opstina);
            $this->assertIsString($opstina['okrug']);
            $this->assertNotEmpty($opstina['okrug']);
            $this->assertArrayHasKey('opstina', $opstina);
            $this->assertIsString($opstina['opstina']);
            $this->assertNotEmpty($opstina['opstina']);
        }
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::opstina
     */
    public function testOpstina()
    {

        $testData = $this->testData[$this->baza->getLang()];
        $opstina = $this->baza->opstina($testData['testPostanskiBroj']);

        $this->assertArrayHasKey('postanski_broj', $opstina);
        $this->assertEquals($testData['testOpstinaPostanskiBroj'], $opstina['postanski_broj']);
        $this->assertArrayHasKey('okrug', $opstina);
        $this->assertEquals($testData['testOkrug'], $opstina['okrug']);
        $this->assertArrayHasKey('opstina', $opstina);
        $this->assertEquals($testData['testOpstina'], $opstina['opstina']);
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::okruzi
     */
    public function testOkruzi() : void
    {
        $okruzi = $this->baza->okruzi();

        $this->assertIsArray($okruzi);
        $this->assertNotEmpty($okruzi);
        foreach ($okruzi as $okrug) {
            $this->assertNotEmpty($okrug);
            $this->assertIsString($okrug);
        }
        
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::okrug
     */
    public function testOkrug()
    {
        $testData = $this->testData[$this->baza->getLang()];
        $okrug = $this->baza->okrug($testData['testPostanskiBroj']);

        $this->assertEquals($testData['testOkrug'], $okrug);
    }

    /**
     * @depends testMozeDaSeKreira
     * @covers BazaArray::okruzi
     */
    public function testLang() : void
    {
        $this->baza->lang('sr_RS');

        $this->assertEquals('sr_RS', $this->baza->getLang());

        $this->testNaselja();
        $this->testNaselje();
        $this->testOpstine();
        $this->testOpstina();
        $this->testOkruzi();
        $this->testOkrug();
    }
}