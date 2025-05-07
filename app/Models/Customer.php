<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Customer extends Model implements Searchable
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    public function getSearchResult(): SearchResult
    {
       $url = route('customers.show', $this->customer_id);
    
        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->lname. " ". $this->fname,
           $url
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
