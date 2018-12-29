<?php

namespace Examples;

require 'common.php';

use MongoFriend\NoSQLQueryBuilder\Notation\InfixToPrefix;
use MongoFriend\NoSQLQueryBuilder\PrefixToTree;

print "infixToPrefix\n";
$exp = "((1 + 2) * 3)";
$exp = "(f+((C+D)*(E*A)))";
$exp = "('fname'='hello')";
$exp = "(fname + 'hello')";
$exp = "(1 + ((2 + 3) * (4 * 5)))";
$infixToPrefix = new InfixToPrefix();
var_dump($infixToPrefix->convert($exp));

print "prefixToTree\n";
$exp = "+9*26"; //"+*34*23"
$prefixToTree = new PrefixToTree();
print $prefixToTree->evaluatePrefix($exp);
