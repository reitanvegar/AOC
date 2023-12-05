#!/bin/python3
import sys

# Add all inital cards.
my_cards=[]
for line in sys.stdin:
    card=line.split(':')[1].split('|')
    my_cards.append([len(my_cards), card[0].split(), card[1].split()])

# Process cards
for [card_nr, my_numbers, winning_numbers] in my_cards:
    hits=1
    for number in my_numbers:
        if number in winning_numbers:
            my_cards.append(my_cards[card_nr+hits])
            hits+=1

print("my_cards: " + str(len(my_cards)))
