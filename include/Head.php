<?php
class Head
{
    public function echoHead()
    {
        echo '
<link rel="stylesheet" href="/styles/reset.css" />
<link rel="stylesheet" href="/styles/style.css" /> <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png?v=7koxj44oew" />
<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png?v=7koxj44oew" /> <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png?v=7koxj44oew" />
<link rel="manifest" href="/icons/site.webmanifest?v=7koxj44oew" /> <link rel="shortcut icon" href="/icons/favicon.ico?v=7koxj44oew" /> <meta name="msapplication-TileColor" content="#da532c" />
<meta name="theme-color" content="#ffffff" /> <meta name="viewport" content="width=device-width, initial-scale=1.0" />
';
    }
}
