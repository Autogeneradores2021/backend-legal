<?php

namespace Tests\Feature\IPC;

use App\Models\Ipc;
use App\Models\Process;
use App\Models\ProcessValue;
use App\Repositories\IPCRepository;
use App\Repositories\ProcessRepository;
use App\Repositories\ProcessValueRepository;
use App\Services\CalculateIPCprovision;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProvisionAdjustmentTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $date = new \DateTime();

        var_dump($date);

        $iPCRepository = new IPCRepository(new Ipc());
        $processValueRepository = new ProcessValueRepository(new ProcessValue());

        $calculateIPCprovision = new CalculateIPCprovision($iPCRepository, $processValueRepository);

        $year = $date->format('Y');
        $month = $date->format('m');

        $calculateIPCprovision->calculateAllByYear($year);
    }
}
