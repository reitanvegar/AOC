#!/usr/bin/perl

# Enforce strict check of rules/best practice
use strict;

# Warn about potential issues
use warnings;

# Import sum so we can use sum() function
use List::Util qw/sum/;

# Get max values from arg
my $max_red = 12;
my $max_green = 13;
my $max_blue = 14;

# color_sum
sub color_sum {
    my $color = shift;
    my $reveal = shift;
    my $sum = 0;

    my (@matches) = $reveal =~ m/\d{1,} (?=$color)/g;
    if(scalar @matches == 0){
    	return 0;
    }
    return sum(@matches);
}

my $game = 1;
my $sum_ids = 0;

# Loop over input lines
while (<>) {
    my $is_possible = 1;
    my @reveals = split /;/, $_;
    foreach my $r (@reveals) {
        if(color_sum("red", $r) > $max_red || color_sum("green", $r) > $max_green || color_sum("blue", $r) > $max_blue){
            $is_possible=0;
	}
    }
    if($is_possible){
        print "GAME " . $game . "POSSIBLE\n";
        $sum_ids += $game;
    }
    $game += 1;
}

print "\nSUM: " . $sum_ids . "\n";
