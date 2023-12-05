#!/bin/python3
import sys

sum = 0
for line in sys.stdin:
    card = line.split(':')[1].split('|')
    my_numbers = card[0].split()
    winning_numbers = card[1].split()
    hits = 0
    for number in my_numbers:
        if number in winning_numbers:
            hits+=1
    if hits:
        sum += 2**(hits-1)

print(sum)
