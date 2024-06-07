<?php
// acceptancetest.php

use PHPUnit\Framework\TestCase;
use BasProject\classes\Klant;
use BasProject\classes\Artikel;
use BasProject\classes\Verkooporder;

#[\PHPUnit\Framework\Attributes\CoversClass(Klant::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(Artikel::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(Verkooporder::class)]
class acceptanceTest extends TestCase
{
    private $klant;
    private $artikel;
    private $verkooporder;

    protected function setUp(): void
    {
        $this->klant = new Klant();
        $this->artikel = new Artikel();
        $this->verkooporder = new Verkooporder();
    }

    public function testInsertKlant()
    {
        $this->klant->klantNaam = 'test';
        $this->klant->klantEmail = 'test@example.com';
        $this->klant->klantAdres = '123 test';
        $this->klant->klantPostcode = 12345;
        $this->klant->klantWoonplaats = 'tests';

        $result = $this->klant->insertKlant();

        $this->assertTrue($result);
    }

    public function testSelectArtikel()
    {
        $artikelen = $this->artikel->selectArtikel();

        $this->assertNotEmpty($artikelen);
    }

    public function testGetAllArtikelen()
    {
        $artikelen = $this->verkooporder->getAllArtikelen();

        $this->assertNotEmpty($artikelen);
    }

    public function testInsertVerkooporder()
    {
        $this->verkooporder->klantId = 1;
        $this->verkooporder->artId = 2;
        $this->verkooporder->verkOrdDatum = '2024-06-08';
        $this->verkooporder->verkOrdBestAantal = 5;
        $this->verkooporder->verkOrdStatus = '1';

        $result = $this->verkooporder->insertVerkooporder();

        $this->assertTrue($result);
    }
}