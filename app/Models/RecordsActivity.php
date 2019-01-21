<?php

namespace App\Models;

use Illuminate\Support\Str;

trait RecordsActivity
{
    /**
     *
     */
    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach (static::getRecordsEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    /**
     * @return array
     */
    protected static function getRecordsEvents()
    {
        return ['created'];
    }

    /**
     * @param $event
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * @param $event
     * @return string
     */
    protected function getActivityType($event)
    {
        $type = Str::lower(class_basename($this));

        return "{$event}_{$type}";
    }
}