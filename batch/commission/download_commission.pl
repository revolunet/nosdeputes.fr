#!/usr/bin/perl

use WWW::Mechanize;
use HTML::TokeParser;
use URI::Escape;
use Encode;

#Prend en compte uniquement les pages de commission qui ont changé depuis moins de x heures (-1 pour désactiver)
$since_hour = shift || 24;

mkdir "html" unless -e "html";

$a = WWW::Mechanize->new();
$aif = WWW::Mechanize->new();
$aif->add_header('If-Modified-Since' =>  scalar(localtime(time()-3600*$since_hour))) if ($since_hour > 0);
$start = shift || '0';
$count = 50;
$ok = 1;

open FILE, "conf/cr.list";
@indexes = <FILE>;
close FILE;

foreach $index (@indexes) {
    chomp($index);
    eval {$aif->get($index);};
    if ($aif->status() == 404) {
	print "ERR: bad file in index : 404 on $index\n";
	next;
    }
    $content = $aif->content;
    if (!$content) {
	next;
    }
    $a->get($index);
    $p = HTML::TokeParser->new(\$content);
    while ($t = $p->get_tag('a')) {
	if ($t->[1]{href} =~ /compte-rendu-commissions/ || $t->[1]{href} =~ /\d{6}\d*.html/) {
	    $curl =  $t->[1]{href};
	    next if ($curl =~ /\/presse\// || curl =~ /prog.html/);
	    next if ($url{$curl});
	    $uriurl = $curl;
	    $uriurl =~ s/^\//http:\/\/www.senat.fr\//;
 	    next if -e "html/".uri_escape($uriurl);
	    eval {$a->get($curl);};
	    if ($a->status() == 404) {
		print "ERR: 404 ".$a->uri()." (from $index)\n ";
		$a->back();
		next;
	    }
	    $uri = $a->uri();
	    if ($url{$uri}) { $a->back(); next; }
            $url{$curl} = 1;	    
            $url{$uri} = 1;	    
	    $file =  uri_escape($uri);
 	    if (-e "html/$file") { $a->back(); next; }
	    open FILE, ">:utf8", "html/$file.tmp";
	    $thecontent = $a->content;
	    if ($thecontent) {
		if ($thecontent =~ s/iso-8859-1/utf-8/gi) {
		    $thecontent = decode("windows-1252", $thecontent);
		}
		print FILE $thecontent;
		close FILE;
		rename "html/$file.tmp", "html/$file";
		print "$file\n";
	    }
	    $a->back();
	}
    }
}

