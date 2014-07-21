#!/usr/bin/perl

use strict;
#use File::Spec;
use Cwd;
$|=1;

my ($base, $clean) = @ARGV;

die "Some dirs" if $base eq $clean;
die "Use both dirname!" if !$clean;

my $saved=0;
my $files=0;
my $dirs=0;

for my $file (split/\n/,`find $base | sort -r`)
{
    my $to = $file;
    $to =~ s/^\Q$base/$clean/;

    my $s=-s $to;

#	print File::Spec->canonpath($file) . ' == ' . File::Spec->canonpath($to) . "\n";
	my $rpf = Cwd::realpath($file);
	my $rpt = Cwd::realpath($to);
#	print  "'$rpf' == '$rpt' ? -> " . ("$rpf" eq "$rpt") . "\n";
	if($rpf eq $rpt)
	{
		print "=";
	}
	else
	{
	    print ".";
	    if(-e $file and -e $to and (-s $file == $s))# and (-M $file == -M $to))
    	{
        	if(unlink $to)
	        {
    	        print "\n$to";
        	    $saved+=$s;
            	$files++;
	        }
    	}
    }

    if(rmdir $to)
    {
        print "\n$to";
        $dirs++;
    }
}

print "\nRemoved $files files and $dirs dirs. Saved $saved bytes\n";
