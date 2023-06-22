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
            fn( $query, $search ) => $query
                ->where( 'title', 'like', '%' . $search . '%' )
                ->orWhere( 'body', 'like', '%' . $search . '%' ) );
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
