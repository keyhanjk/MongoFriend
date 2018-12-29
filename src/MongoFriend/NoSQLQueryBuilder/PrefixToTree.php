<?php

namespace MongoFriend\NoSQLQueryBuilder;

use MongoFriend\DataStructure\Stack;

class PrefixToTree
{
    public function isOperand(string $c): bool
    {
        // If the character is a digit then it must
        // be an operand
        return is_numeric($c);
    }

    public function evaluatePrefix(string $exprsn)
    {
        $stack = new Stack();

        for ($j = strlen($exprsn) - 1; $j >= 0; $j--) {

            // Push operand to stack
            // To convert exprsn[j] to digit subtract
            // '0' from exprsn[j].
            if ($this->isOperand($exprsn[$j])) {
                $stack->push($exprsn[$j]-'0');
            } else {
                // Operator encountered
                // Pop two elements from stack
                $o1 = $stack->top();
                $stack->pop();
                $o2 = $stack->top();
                $stack->pop();

                // Use switch case to operate on o1
                // and o2 and perform o1 O o2.
                switch ($exprsn[$j]) {
                    case '+':
                        $stack->push($o1 + $o2);
                        break;
                    case '-':
                        $stack->push($o1 - $o2);
                        break;
                    case '*':
                        $stack->push($o1 * $o2);
                        break;
                    case '/':
                        $stack->push($o1 / $o2);
                        break;
                }
            }
        }

        return $stack->top();
    }
}
