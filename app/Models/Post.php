<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;

    protected $guarded = [];

    protected $with = [ 'author', 'category' ];

    public function scopeFilter( $query, $filters ) {
        $query->when( $filters['search'] ?? false,
            fn( $query, $search ) => $query->where(
                fn( $query ) => $query->where( 'title', 'like', '%' . $search . '%' )
                                      ->orWhere( 'body', 'like', '%' . $search . '%' ) )
        );


        $query->when( $filters['category'] ?? false,
            fn( $query, $category ) => $query
                ->whereHas( 'category', fn( $query ) => $query->where( 'slug', $category ) ) );

        $query->when( $filters['author'] ?? false,
            fn( $query, $author ) => $query
                ->whereHas( 'author', fn( $query ) => $query->where( 'username', $author ) ) );
    }

    public function category() {
        return $this->belongsTo( Category::class );
    }

    /**
     * @help When establishing a relationship between 2 models,
     * Laravel reads this name and assumes that the foreign key will
     * be called user_id (since the function is called user).
     * So use the 2nd parameter of, for example, belongsTo, to
     * specify the foreign ID.
     */
    public function author() { // user_id
        return $this->belongsTo( User::class, 'user_id' );
    }
}
