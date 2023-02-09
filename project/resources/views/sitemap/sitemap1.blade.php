<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($products as $product)
        {{-- @php
            $slug= $product->slug;
            $getUrl = Str   
        @endphp --}}
        <url>
            <loc>{{url('item/'.$product->slug)}}</loc>
            <lastmod>{{ date('Y-m-d\TH:i:s\Z',strtotime($product->updated_at)) }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>