<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait CanLoadRelationships
{
    public function loadRelationships(
        Model|QueryBuilder|EloquentBuilder|HasMany $for,
        array $relations = null
    ) {
        $relations = $relations ?? $this->relations ?? [];

        // Check if $for is a collection
        if ($for instanceof \Illuminate\Database\Eloquent\Collection) {
            // Iterate through the collection and apply loadRelationships to each model
            $for->each(function ($model) use ($relations) {
                $this->loadRelationships($model, $relations);
            });
        } else {
            // $for is a single model instance
            foreach ($relations as $relation) {
                $for->when(
                    $this->shouldIncludeRelation($relation),
                    function ($query) use ($for, $relation) {
                        return $for instanceof \Illuminate\Database\Eloquent\Model
                            ? $for->load($relation)
                            : $query->with($relation);
                    }
                );
            }
        }

        return $for;
    }

    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include');

        if (!$include) {
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}
