<?php

namespace App\Server\Commands;

use App\Server\Entities\Command;
use App\Server\Entities\Prize;

class AddPrize extends Command
{
    /**
     * Save the command arguments for later when the command is run.
     *
     * @param array $arguments
     */
    public function __construct(array $arguments = [])
    {
        $this->name = array_get($arguments, 'name');
        $this->sponsor = array_get($arguments, 'sponsor');
    }

    /**
     * Run the command.
     */
    public function run()
    {
        $prizes = $this->dispatcher()->prizes();
        $prizes->push(new Prize($this->name, $this->sponsor));
        $everyone = $this->dispatcher()->connections();

        return $this->dispatcher()
            ->broadcast(new UpdatePrizes($prizes), $everyone);
    }
}
