<?php

namespace MongoFriend\NoSQLQueryBuilder\Notation;

use MongoFriend\DataStructure\Stack;

class InfixToPrefix
{
    public function convert($exp)
    {
        $stack = new Stack();
        $result = [];

        $i = 0;
        while ($i < strlen($exp)) {
            $input = $exp[$i];
            if (in_array($input, ['"', "'", "`"])) {
                $startOfWord = $i;
                $i = strpos($exp, $input, $i + 1);
                $result[] = substr($exp, $startOfWord, $i - $startOfWord + 1);
                $i++;
            } else if (ctype_alpha($input)) { //($input >= 'a' && $input <= 'z') || ($input >= 'A' && $input <= 'Z')
                $startOfWord = $i;
                while (ctype_alpha($input)) {
                    $i++;
                    $input = $exp[$i];
                }
                $result[] = substr($exp, $startOfWord, $i - $startOfWord);
                $i++;
            } else if (($input >= '0' && $input <= '9')) {
                $result[] = $input;
            } else if ($input == '(') {
                $stack->push($input);
            } else if ($input == ')') {
                while (!$stack->isEmpty() && $stack->top() != '(') {
                    $result[] = $stack->top();
                    $stack->pop();
                }

                if (!$stack->isEmpty()) {
                    $stack->pop();
                } else {
                    print "\n";
                    print "Error : No matching '(' token\n";
                    return 100;
                }
            } else if (in_array($input, ['*', '/', '+', '-', '='])) {
                if ($stack->isEmpty() || $this->precedence($stack->top()) < $this->precedence($input)) {
                    $stack->push($input);
                } else {
                    while (!$stack->isEmpty()) {
                        if ($this->precedence($stack->top()) < $this->precedence($input)) {
                            break;
                        }

                        print $stack->top() . "\n";
                        $stack->pop();
                    }

                    $stack->push($input);
                }
            } else if ($input != ' ') {
                print "\nError : Invalid character or token : '" . $input . "'\n";
                return 100;
            }

            $i++;
        }

        while (!$stack->isEmpty()) {
            print $stack->top() . ' ';
            $stack->pop();
        }

        return array_reverse($result);
    }

    /**
     * Returns a precedence value for a certain operator
     *
     * Lowest : (
     * Normal : + -
     * Highest : * /
     *
     * @param [type] $input
     * @return integer
     */
    public function precedence($input): int
    {
        if ($input == '=') {
            $p = 0;
        } else if ($input == '(') {
            $p = 1;
        } else {
            if ($input == '+' || $input == '-') {
                $p = 2;
            } else {
                if ($input == '*' || $input == '/') {
                    $p = 3;
                } else {
                    print "\nError : Invalid input operator : $input\n";
                    exit(100);
                }
            }
        }

        return $p;
    }
}
