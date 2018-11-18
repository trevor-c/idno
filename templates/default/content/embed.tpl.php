<?php

    // Embedded content code from Aaron Parecki, slightly modified:
    // http://aaronparecki.com/articles/2013/05/09/1/experimenting-with-auto-embedding-content
    $embedded = '';
    $urls = [];

    $body = $vars['value'];

    if (preg_match_all('/https?:\/\/([^\s]+\.[^\s\.]+\.(png|jpg|jpeg|gif))/i', $body, $matches)) {
        foreach ($matches[0] as $m) {
            $embedded .= '<p><img src="' . $m . '" /></p>';
            $urls[] = $m;
        }
    }
    if (preg_match_all('/(youtube\.com|youtu\.be)\/watch\?v=([a-z0-9\-\_]+)/i', $body, $matches)) {
        foreach ($matches[2] as $m) {
            $embedded .= '<div><iframe class="youtube-player auto-link figure" width="600" height="420" style="border:0" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" src="//www.youtube-nocookie.com/embed/' . $m . '"></iframe></div>';
            $urls[] = $m;
        }
    } else if (
        preg_match_all('/(youtube\.com|youtu\.be)\/c\/([a-z0-9\-\_]+)/i', $body, $matches) ||
        preg_match_all('/(youtube\.com|youtu\.be)\/channel\/([a-z0-9\-\_]+)/i', $body, $matches)
    ) {
        foreach ($matches[2] as $m) {
            // TODO: see if there's a way to embed YouTube channels
        }
    } else if (preg_match_all('/(youtube\.com|youtu\.be)\/user\/([a-z0-9\-\_]+)/i', $body, $matches)) {
        foreach ($matches[2] as $m) {
            $embedded .= '<div><iframe class="youtube-player auto-link figure" width="600" height="420" style="border:0" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" src="//www.youtube-nocookie.com/embed/?listType=user_uploads&list=' . $m . '"></iframe></div>';
            $urls[] = $m;
        }
    } else if (preg_match_all('/(youtube\.com|youtu\.be)\/([a-z0-9\-\_]+)/i', $body, $matches)) {
        foreach ($matches[2] as $m) {
            $embedded .= '<div><iframe class="youtube-player auto-link figure" width="600" height="420" style="border:0" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" src="//www.youtube-nocookie.com/embed/' . $m . '"></iframe></div>';
            $urls[] = $m;
        }
    }
    if (preg_match_all('/vimeo\.com\/([0-9]+)/i', $body, $matches)) {
        foreach ($matches[1] as $m) {
            $embedded .= '<iframe src="//player.vimeo.com/video/' . $m . '" width="600" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            $urls[] = $m;
        }
    }
//    if (preg_match_all('/https?:\/\/twitter\.com\/[^\s]+\/status\/[^\s]+\/?/i', $body, $matches)) {
//
//        foreach ($matches[0] as $m) {
//            $embedded .= '<div id="sc_' . md5($m) . '" class="twitter-embed" data-url="' . $m . '"></div>';
//            $urls[] = $m;
//        }
//    }
    if (preg_match_all('/https?:\/\/(www\.)?instagram\.com\/p\/([A-Za-z0-9\-\_]+)\/?/i', $body, $matches)) {

        foreach ($matches[0] as $m) {
            $urls[] = $m; 
        } 
        foreach ($matches[2] as $m) {
            $embedded .= '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="7" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
    <div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:50.0% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/'.$m.'/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">loading...</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"></p></div></blockquote> 
<script async defer src="//platform.instagram.com/en_US/embeds.js"></script>';
            
        }
    }
    
    // Use unfurling for the rest (first url only)
    if (preg_match_all('/(?<!=)(?<!["\'])((ht|f)tps?:\/\/[^\s<>"\']+)/i', $body, $matches)) {
        
        foreach ($matches[0] as $m) {
            $found = false;
            foreach ($urls as $url) {
                if (strpos($m, $url)!==false)
                        $found = true;
            }
            if (!$found) {
                $embedded .= $this->__(['data-url' => $m])->draw('content/unfurl');//"<div class=\"unfurl col-md-12\" style=\"display:none;\" data-url=\"".htmlentities($m)."\"></div>";
                break;
            }
        }
    }
    
    echo $embedded;


