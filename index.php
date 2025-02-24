<?php namespace x\score;

function content($content) {
    if (!$content) {
        return $content;
    }
    $text = \i('This web page took %.5f seconds to render and used %s of memory on %s, at %s.', [(\microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) / 1000, \size(\memory_get_usage(true)), \date('F j, Y'), \date('h:i:s A')]);
    if ($type = \type()) {
        if ('text/css' === $type) {
            return $content . "\n/* " . $text . ' */';
        }
        if ('text/html' === $type) {
            return $content . "\n<!-- " . $text . ' -->';
        }
        if (
            'application/javascript' === $type ||
            'application/x-javascript' === $type ||
            'text/javascript' === $type
        ) {
            return $content . "\n// " . $text;
        }
        if (
            'application/atom+xml' === $type ||
            'application/mathml+xml' === $type ||
            'application/rdf+xml' === $type ||
            'application/rss+xml' === $type ||
            'image/svg+xml' === $type ||
            'text/xml' === $type
        ) {
            return $content . "\n<!-- " . $text . ' -->';
        }
    }
    if ($x = \pathinfo(\lot('url')->path ?? "", \PATHINFO_EXTENSION)) {
        if ('css' === $x) {
            return $content . "\n/* " . $text . ' */';
        }
        if (
            'htm' === $x ||
            'html' === $x
        ) {
            return $content . "\n<!-- " . $text . ' -->';
        }
        if (
            'js' === $x ||
            'mjs' === $x
        ) {
            return $content . "\n// " . $text;
        }
        if (
            'svg' === $x ||
            'xht' === $x ||
            'xhtm' === $x ||
            'xhtml' === $x ||
            'xml' === $x
        ) {
            return $content . "\n<!-- " . $text . ' -->';
        }
    }
    return $content;
}

\Hook::set('content', __NAMESPACE__ . "\\content", 1000.1);