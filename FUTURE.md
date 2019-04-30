# Future Roadmap

* Add `Data`, unified key value database where operators can read general data from. As an operator.
* Allow passing instances of operator into expressions.
* Exists operator `['exists', 'keyName']`
* Empty operator `['empty', 'keyName']`
* Length operator `['length', <expression>]`, `mb_strlen` for string, `count` for array.
* Split operator `['split', ',', ['value', 'items,and,values']]` -> `['items', 'and', 'values']`
* Trim operator `['trim', 'left|right|all', ['value', ' test ']]`,
* Replace operator `['replace', <subjectExpression>, <fromExpression>, <toExpression>]`,
* Join operator `['join', ',', ['value', [1,2,3]]]` -> `'1,2,3'`
* Each operator `['each', <expressionReturningAnArray>, <expression>]`
* All must be `['allMustBe', <expressionReturningAnArray>, <checkExpression>]` -> all must be true for this to return true
* One must be `['oneMustBe', <expressionReturningAnArray>, <checkExpression>]` -> one must be true for this to return true 
* String concat operator `['concat', ['value', 'hello'], ['value', ' '], ['value', 'world']]` -> `hello world`, Or concat arrays.
* Math operator `['math', ['value', 5], '+', ['math', ['value', 4], '*', ['value', 3]]]` -> 5 + (4 * 3)
* Some additional Array operators?
