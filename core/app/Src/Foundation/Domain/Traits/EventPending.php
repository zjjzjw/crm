<?php namespace Huifang\Src\Foundation\Domain\Traits;

use Huifang\Src\Foundation\Domain\Event;

Trait EventPending
{
    /**
     * List of pending events.
     *
     * @var \Huifang\Src\Foundation\Domain\Event[]
     */
    protected $events = [];

    /**
     * Pend an event.
     *
     * @param \Huifang\Src\Foundation\Domain\Event $event
     */
    public function pendEvent(Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * Publish all pending events.
     */
    public function publishEvents()
    {
        foreach ($this->events as $event) {
            $event->publish();
        }
        $this->events = [];
    }

}
