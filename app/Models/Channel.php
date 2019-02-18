<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Attributes to cast.
     */
    protected $casts = [
        'archived' => 'boolean'
    ];

    /**
     * Boot the channels model
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function ($builder) {
            $builder->where('archived', false);
        });

        static::addGlobalScope('sorted', function ($builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    /**
     * Get a new query builder that includes archives.
     */
    public static function withArchived()
    {
        return (new static)->newQueryWithoutScope('active');
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = str_slug($name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Archive the channel.
     */
    public function archive()
    {
        $this->update(['archived' => true]);
    }
}
