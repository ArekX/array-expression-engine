# Future Roadmap

* Add `Data`, unified key value database where operators can read general data from. As an operator.
* Allow passing instances of operator into expressions.
* Exists operator `['exists', 'keyName']`
* Empty operator `['empty', <expression>]`
* Length operator `['length', <expression>]`, `mb_strlen` for string, `count` for array.
* Split operator `['split', ',', ['value', 'items,and,values']]` -> `['items', 'and', 'values']`
* Trim operator `['trim', 'left|right|both', ['value', ' test ']]`,
* Replace operator `['replace', <subjectExpression>, <fromExpression>, <toExpression>]`,
* Join operator `['join', ',', ['value', [1,2,3]]]` -> `'1,2,3'`
* Each operator `['each', <expressionReturningAnArray>, <expression>]`
    * We will need `ValueParser::getSubParser($requestedName, $default = null)` which returns subparsed value which will be scoped to requested name. Value parser to determine which parser?
* All must be `['allMustBe', <valueExpression>, <expressionReturningAnArray>, <checkExpression>]` -> all must be equal to valueExpression to return true
* One must be `['oneMustBe', <valueExpression>, <expressionReturningAnArray>, <checkExpression>]` -> one must be equal to valueExpression to return true 
* String concat operator `['concat', ['value', 'hello'], ['value', ' '], ['value', 'world']]` -> `hello world`, Or concat arrays.
* Math operator `['math', ['value', 5], '+', ['math', ['value', 4], '*', ['value', 3]]]` -> 5 + (4 * 3)
* Some additional Array operators? (must not contain values, array diff, intersection, to_keys, to_values, etc?)
* Get with no parameters `['get']` equals to `['get', '']` which means whole result.