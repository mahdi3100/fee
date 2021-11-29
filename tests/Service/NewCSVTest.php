<?php

namespace Candidat\Fee\Tsets\Service;

use PHPUnit\Framework\TestCase;
use Candidat\Fee\Service\NewCSV;

final class NewCSVTest extends TestCase
{
    /**
     * @var NewCSV
     */
    private $newCSV;

    public function setUp():void
    {

        $this->newCSV = new NewCSV("../csv/csv.csv");
       
    }
    public function tearDown():void
    {
        $this->newCSV = NULL;
    }
    public function testFeeResault():void
    {
       $this->newCSV->FeeResault();
    }
    

}

