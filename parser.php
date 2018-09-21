<?php

ini_set('error_reporting', 1);
error_reporting(E_ALL);

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_BASENAME', 'parser');

require_once 'DB.php';
require_once "simple_html_dom.php";

$url = "link to resource to be parsed";

$db = new DB(DB_HOST, DB_USER, DB_PASSWORD, DB_BASENAME);

function getArticleData($url)
{
    global $db;

    $article = file_get_html($url);

    $h1 = $db->escape($article->find('h1', 0)->innertext);
    $content = $db->escape($article->find('article', 0)->innertext);

    $data = compact('h1', 'content');

    $sql = "
        update parser
            set h1 = '{$h1}',
                content = '{$content}',
                parse_date = NOW()
            where url = '{$url}'
    ";

    $db->query($sql);

    return $data;
}

function getAtriclesLinksFronUrl($url)
{
    global $db;

    //output the temporary link
    echo PHP_EOL . $url . PHP_EOL;

    //getting page content
    $html = file_get_html($url);

    //ge!!t each artikle link
    foreach ($html->find('a.read-more-link') as $link) {

        $article_url = $db->escape($link->href);
        $sql = "
                INSERT ignore INTO parser SET url='{$article_url}'
        ";

        $db->query($sql);

        getArticleData($link->href);

        echo $link->href . PHP_EOL;
        print_r(getArticleData($link->href));
    }

    //recursion for next page
    if ($next_link = $html->find('a.next', 0)) {
        getAtriclesLinksFronUrl($next_link->href);
    }
}

getAtriclesLinksFronUrl($url);