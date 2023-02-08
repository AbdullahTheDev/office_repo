<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- @foreach($sitemap as $site) --}}
        <sitemap>
    
        <loc>{{url($sitemap)}}</loc>
    
        <lastmod>2004-10-01T18:23:17+00:00</lastmod>
    
        </sitemap>
    {{-- @endforeach --}}
 
 </sitemapindex>