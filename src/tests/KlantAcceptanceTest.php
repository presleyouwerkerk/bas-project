<?php

use PHPUnit\Framework\TestCase;
use BasProject\classes\Klant;
use BasProject\classes\Connection;

class KlantAcceptanceTest extends TestCase
{
    protected $klant;

    protected function setUp(): void
    {
        $connection = $this->createMock(Connection::class);

        $this->klant = new Klant($connection);
    }

    public function testInsertKlant()
    {
        $data = [
            'klantnaam' => 'John Doe',
            'klantemail' => 'john@example.com'
        ];
    
        $this->klant->insertKlant($data);
    
        $customers = $this->klant->getKlanten();
    
        $this->assertContains($data, $customers, 'Inserted customer data not found in the list of customers.');
    }
}