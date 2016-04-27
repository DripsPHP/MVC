<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>News</title>
    </head>
    <body>
        <h1>News</h1>
        <ul class="news">
        {foreach $news as $entry}
            <li>{$entry["name"]}</li>
        {foreachelse}
            <li>Es sind aktuell keine Newseinträge vorhanden</li>
        {/foreach}
        </ul>
    </body>
</html>
