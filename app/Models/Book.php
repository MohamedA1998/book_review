<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

// To Show Sql Statment toSql()
class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getUpperAuthorAttribute()
    {
        return strtoupper($this->author);
    }

    public function scopeWhereTitleLike(Builder $query, string $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function scopeWithCountReviews(Builder $query, $from = null, $to = null): Builder | QueryBuilder
    {
        return $query->withCount('reviews')
            ->dateRangeFilter($from, $to);
    }

    public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder | QueryBuilder
    {
        return $query->withAvg("reviews", "rating")
            ->dateRangeFilter($from, $to);
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder | QueryBuilder
    {
        return $query->withCount('reviews')
            ->withCountReviews($from, $to)
            ->orderBy('reviews_count', 'desc');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder | QueryBuilder
    {
        return $query->withAvg("reviews", "rating")
            ->withAvgRating($from, $to)
            ->orderBy("reviews_avg_rating", "desc");
    }

    public function scopePopularLastMonth(Builder $query): Builder | QueryBuilder
    {
        return $query->Popular(now()->subMonth(), now())
            ->HighestRated(now()->subMonth(), now())
            ->MinReviews(2);
    }

    public function scopePopularLast6Month(Builder $query): Builder | QueryBuilder
    {
        return $query->Popular(now()->subMonth(6), now())
            ->HighestRated(now()->subMonth(6), now())
            ->MinReviews(8);
    }

    public function scopeHighestRatedLastMonth(Builder $query): Builder | QueryBuilder
    {
        return $query->HighestRated(now()->subMonth(), now())
            ->Popular(now()->subMonth(), now())
            ->MinReviews(2);
    }

    public function scopeHighestRatedLast6Month(Builder $query): Builder | QueryBuilder
    {
        return $query->HighestRated(now()->subMonth(6), now())
            ->Popular(now()->subMonth(6), now())
            ->MinReviews(8);
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder | QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    protected function scopeDateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    protected static function booted(): void
    {
        static::updated(fn(Book $book) => cache()->forget("book:{$book->id}"));
        static::deleted(fn(Book $book) => cache()->forget("book:{$book->id}"));
    }

}
