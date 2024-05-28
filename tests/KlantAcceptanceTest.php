<?php
// klantacceptancetest.php

use PHPUnit\Framework\TestCase;
use BasProject\classes\Klant;

#[\PHPUnit\Framework\Attributes\CoversClass(Klant::class)]
class KlantAcceptanceTest extends TestCase
{
    private $klant;

    protected function setUp(): void
    {
        $this->klant = new Klant();
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
}
