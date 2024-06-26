<?php

use PHPUnit\Framework\TestCase;
use BasProject\classes\Klant;
use BasProject\classes\Artikel;
use BasProject\classes\Verkooporder;
use BasProject\classes\Connection;

#[\PHPUnit\Framework\Attributes\CoversClass(Klant::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(Artikel::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(Verkooporder::class)]
#[\PHPUnit\Framework\Attributes\CoversClass(Connection::class)]

class AcceptanceTest extends TestCase
{
    private $klant;
    private $artikel;
    private $verkooporder;
    private $connection;

    protected function setUp(): void
    {
        $this->connection = new Connection();
        $this->klant = new Klant($this->connection);
        $this->artikel = new Artikel($this->connection);
        $this->verkooporder = new Verkooporder($this->connection);
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

    public function testGetAllKlanten()
    {
        $klanten = $this->verkooporder->getAllKlanten();

        $this->assertNotEmpty($klanten);
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