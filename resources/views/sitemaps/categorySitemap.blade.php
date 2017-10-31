<urlset
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- www.check-domains.com sitemap generator -->
    @foreach($types as $type)
        <url>
            <loc>{{url($type->name_unicode)}}</loc>
            <lastmod>2017-10-18T00:00:00+00:00</lastmod>
        </url>
    @endforeach
</urlset>