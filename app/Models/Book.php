<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    public function reviews(){
        return $this->hasMany(Review::class);
    }
    
    public function scopeTitle($query, string $title)
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc')->limit(10);
    }   

    
    public function scopeMinReviews($query , int $minReviews) {
        return $query->having('reviews_count', '>=', $minReviews);
    }
    
    public function scopePopular($query, $from = null, $to = null)
    {
        return $query->withCount(['reviews' => function($q) use ($from, $to) {
            if ($from && $to) {
                $q->whereBetween('created_at', [$from, $to]);
            } elseif ($from) {
                $q->where('created_at', '>=', $from);
            } elseif ($to) {
                $q->where('created_at', '<=', $to);
            }
        }])->orderBy('reviews_count', 'desc');
    }
 
    
    public function scopeHighestRated($query) {
        return $query->withAvg('reviews', 'rating')
        ->orderBy('reviews_avg_rating','desc');
    }

    private function dateRangeFilter(Builder $query, $from=null, $to=null){
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
    
    public function scopePopularLastMonth($query) {
         return $query->popular(now()->subMonth(), now())
         ->HighestRated(now()->submonth(), now())
         ->minReviews(2);
    }
    
    public function scopePopularLast6Months($query) {
         return $query->popular(now()->subMonths(6), now())
         ->HighestRated(now()->submonths(), now())
         ->minReviews(5);
    }

    public function scopeHighestRatedLastMonth($query) {
         return $query->HighestRated(now()->submonth(), now())
         ->popular(now()->subMonth(), now())
         ->minReviews(2);
    }

    public function scopeHighestRatedLast6Months($query) {
         return $query->HighestRated(now()->submonths(), now())
         ->popular(now()->subMonths(6), now())
         ->minReviews(5);
    }
    
}
