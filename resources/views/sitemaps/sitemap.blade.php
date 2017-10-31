<urlset
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- www.check-domains.com sitemap generator -->
    @foreach($posts as $post)
        <url>
            <loc>{{url($post->title_seo)}}</loc>
            <lastmod>{{$post->created_at->toAtomString()}}</lastmod>
        </url>
    @endforeach
</urlset>