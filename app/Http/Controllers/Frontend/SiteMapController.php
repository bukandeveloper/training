<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Laravelium\Sitemap\SitemapServiceProvider;
use App\Models\Project;
use App;
use URL;

class siteMapController extends Controller
{
    // Generate sitemap url
    public function sitemap(){
        // create new sitemap object
        $sitemap = App::make("sitemap");
        $now = Carbon::now();

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to('/'), $now, '1.0', 'daily');
        $sitemap->add(URL::to('/about'), $now, '0.9', 'weekly');

	    /**
	     *  $projects = Project::all();
	     *  foreach ($projects as $project) {
	     *      $sitemap->add(URL::to('/gallery/'.$project->internal_id), $project->created_at, '0.9', 'weekly');
	     *  }
	     */

        /**
         *  show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
         *  generate your sitemap (format, filename)
         *  $sitemap->store('xml', 'sitemap');
         *
         *  this will generate file mysitemap.xml to your public folder
         */

        return $sitemap->render('xml');
    }
}
