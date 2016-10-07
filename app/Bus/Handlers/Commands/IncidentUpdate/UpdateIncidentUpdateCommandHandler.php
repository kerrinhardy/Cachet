<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Handlers\Commands\IncidentUpdate;

use CachetHQ\Cachet\Bus\Commands\IncidentUpdate\UpdateIncidentUpdateCommand;
use CachetHQ\Cachet\Bus\Events\IncidentUpdate\IncidentUpdateWasUpdatedEvent;

/**
 * This is the update incident update command handler.
 *
 * @author James Brooks <james@alt-three.com>
 */
class UpdateIncidentUpdateCommandHandler
{
    /**
     * Handle the update incident update command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\IncidentUpdate\UpdateIncidentUpdateCommand $command
     *
     * @return \CachetHQ\Cachet\Models\IncidentUpdate
     */
    public function handle(UpdateIncidentUpdateCommand $command)
    {
        $command->update->update($this->filter($command));

        event(new IncidentUpdateWasUpdatedEvent($command->update));

        return $command->update;
    }

    /**
     * Filter the command data.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\IncidentUpdate\UpdateIncidentUpdateCommand $command
     *
     * @return array
     */
    protected function filter(UpdateIncidentUpdateCommand $command)
    {
        $params = [
            'status'  => $command->status,
            'message' => $command->message,
            'user_id' => $command->user->id,
        ];

        return array_filter($params, function ($val) {
            return $val !== null;
        });
    }
}
