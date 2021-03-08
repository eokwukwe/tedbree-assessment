<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

trait Search
{
    /**
     * Credit: https://gist.github.com/mul14/726c4d2514c5d9f28b43
     * 
     * Search record by keyword.
     */
    public static function scopeSearch(
        Builder $query,
        string $keyword = null
    ): Builder {
        return static::where(function ($query) use ($keyword) {
            if (!$keyword) {
                $query;
            }

            foreach (static::getSearchFields() as $field) {
                $query->orWhere($field, 'LIKE', "%$keyword%");
            }
        });
    }

    /**
     * Get all searchable fields
     */
    public static function getSearchFields(): array
    {
        $model = new static;

        $fields = $model->search;

        if (empty($fields)) {
            $fields = Schema::getColumnListing($model->getTable());

            $others[] = $model->primaryKey;

            $others[] = $model->getUpdatedAtColumn() ?: 'created_at';
            $others[] = $model->getCreatedAtColumn() ?: 'updated_at';

            $others[] = method_exists($model, 'getDeletedAtColumn')
                ? $model->getDeletedAtColumn()
                : 'deleted_at';

            $fields = array_diff($fields, $model->getHidden(), $others);
        }

        return $fields;
    }
}
