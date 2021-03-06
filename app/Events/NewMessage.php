<?php namespace App\Events;

use App\Events\Event;

use App\Models\Participant;
use Illuminate\Queue\SerializesModels;

class NewMessage extends Event {

	use SerializesModels;

    /**
     * @var Participant
     */
    public $participant;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Participant $participant)
    {
        $this->participant = $participant;
	}

}
