<?php
namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships{

    public function loadRelationships(Model|QueryBuilder|EloquentBuilder|HasMany $query ,array $relationships=null):
    Model|QueryBuilder|EloquentBuilder|HasMany
    {
        $relations=$relationships ?? $this->relationships ?? [];
        foreach ($relations as $relation){
            if (! $this->shouldIncludeRelation($relation)) {
                continue;
            }

            if ($query instanceof Model) {
                $query->load($relation);
            } else {
                $query->with($relation);
            }

        }
        return $query;
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
