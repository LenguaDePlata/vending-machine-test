# Vending Machine Technical Test

## Usage
----
Vendingmachine is a command-line PHP service for in-memory stock and change keeping, based on the technical test requirements for this challenge.

Built using PHP 7.4+. It requires composer to work.

First, install the dependencis needed via composer:

    composer install

Then, to launch it, execute

    php vendingmachine.php

### Available operations
----

##### SERVICE
----
The SERVICE operation "opens" the machine and allows to set the available change and how many items there are inside the vending machine. As the vending machine can't return the 1 euro coins when giving the change, those coins are set to zero when setting the available change with this operation: it is asumed the service person empties them and takes them to the owner company.

The operation has the following syntax:

    <005_coins>, <010_coins>, <025_coins>, <soda_items>, <water_items>, <juice_items>, SERVICE

- **xxx_coins** (int, required): the number of available coins of that type the service person is setting for the vending machine's change. It replaces the previous number of coins of that type, if there were any. It should be greater than zero.
- **xxxx_items** (int, required): the number of available items of that type the service person is setting for the vending machine's stock. It replaces the previous number of items of that type, if there were any. It should be greater than zero.

This operation returns no response, except in the case of an error.

##### INSERT-COIN
----
The INSERT-COIN operation adds coins to the currently inserted but unused money in the vending machine. The vending machine can later use this money for other operations.

The operation has the following syntax:

    <inserted_coin_1>, <inserted_coin_2>,... <inserted_coin_n>

- **inserted_coin_x** (float, required): a float with the value of one of the accepted coins by the vending machine (0.05, 0.10, 0.25, 1). There is no limit to the number of coins that can be inserted

This operation returns no response, except in the case of an error. In order to retrieve the coins inserted with this operation, the RETURN-COIN (see next) operation should be used.

##### RETURN-COIN
----
The RETURN-COIN operation retrieves all the currently inserted but unused money in the vending machine, both with this operation's arguments and with previous INSERT-COIN operations.

The operation ahs the following syntax:

    <inserted_coin_1>, <inserted_coin_2>,... <inserted_coin_n>, RETURN-COIN

- **inserted_coin_x** (float, required): a float with the value of one of the accepted coins by the vending machine (0.05, 0.10, 0.25, 1). There is no limit to the number of coins that can be inserted

This operation returns the list of coins that were currently inserted in the vending machine, but haven't been used for any purchasing operation. The coins are returned in ascending order of value, separated by commas.

For example, if the vending machine were given the following operations

    1, 1
    //no response because of the INSERT-COIN operation
    1, 1, 0.05, 0.10, RETURN-COIN

The response would be:

    -> 0.05, 0.10, 1, 1, 1, 1

##### GET-ITEM
----

The GET-ITEM operation purchases one of the available items in stock in the vending machine, and returns the change resulted from paying the item with the currently inserted but unused money in the vending machine (both with this operation's arguments and with previous INSERT-COIN operations).

The operation has the following syntax:

   <inserted_coin_1>, <inserted_coin_2>,... <inserted_coin_n>, GET-<item_name_in_caps>

- **inserted_coin_x** (float, required): a float with the value of one of the accepted coins by the vending machine (0.05, 0.10, 0.25, 1). There is no limit to the number of coins that can be inserted
- **item_name_in_caps** (string, required): the name of the item from the vending machine's stock that we want to purchase, all in caps. The only items available for this vending machine are Water, Soda, and Juice.

This operation returns the item purchased (represented by its name, all in caps), separated by a comma from the list of coins that correspond to the change generated after substracting th price of the item from all the currently inserted money. The coins are returned in ascending order of value, separated by commas. However, this change is returned only in 0.05, 0.10, and 0.25 coins -no 1 euro coins are returned in a purchase. The change is always calculated giving preference to the higher value coins over the lower ones, if there are multiple ways to return the change.

##### QUIT
----

Exits the vending machine service, resetting all its in-memory states and values.

The operation has the following syntax:

    QUIT