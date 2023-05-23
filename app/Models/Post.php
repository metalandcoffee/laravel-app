<?php


namespace App\Models;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post {

    public $title;

    public $excerpt;

    public $date;

    public $body;

    public $slug;

    /**
     * Post constructor.
     *
     * @param $title
     * @param $excerpt
     * @param $date
     * @param $body
     */
    public function __construct( $title, $excerpt, $date, $body, $slug ) {
        $this->title   = $title;
        $this->excerpt = $excerpt;
        $this->date    = $date;
        $this->body    = $body;
        $this->slug    = $slug;
    }

    public static function all() {
        // Cache expires every hour.
        return cache()->remember( 'posts.all', now()->addHour(), function() {
            return collect( File::files(resource_path('posts') ) )
                ->map( fn($file) => YamlFrontMatter::parseFile( $file ) )
                ->map( fn($document) => new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug
                ) )
                ->sortByDesc('date');
        });
    }

    /**
     * Find a post by its slug or fail gracefully.
     *
     * @param string $slug
     *
     * @return static ModelNotFoundException if post not found.
     *
     * @throws
     *
     */
    public static function findOrFail( string $slug ): static {
        $post = static::find( $slug );

        if ( ! $post ) {
            throw new ModelNotFoundException();
        }

        return $post;
    }

    /**
     * Find a post by its slug.
     *
     * @param string $slug
     *
     * @return static|null
     */
    public static function find( string $slug ): static | null {
        return static::all()->firstWhere('slug', $slug);
    }

}
