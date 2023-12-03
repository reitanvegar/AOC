#!/usr/bin/perl

# Enforce strict check of rules/best practice
use strict;

# Warn about potential issues
use warnings;

# Import max function 
use List::Util qw(max);

# Find max value for colour on line.
sub color_max {
    my $color = shift;
    my $line = shift;

    my (@matches) = $line =~ m/\d{1,} (?=$color)/g;
    return max(@matches);
}


# Loop over input lines
my $sum = 0;
while (<>) {
    $sum += color_max("red", $_) * color_max("green", $_) * color_max("blue", $_);
}
print "\nSUM: " . $sum . "\n";
