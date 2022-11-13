MYSQL database functions [db.php](https://github.com/Erik-KK/db-php/blob/main/db.php) made by ekk v1.1

# Functions list
|function | description |
|:------------------------------------------------------------------------------|:---------------------------------------------------------|
| dbConnect() | connect to database using [config.php](https://github.com/Erik-KK/db-php/blob/main/config.php) |
| dbDisconnect() | disconnect from database |
| [dbQuery($query)](#dbQuery) | make query to database |
| [dbGetLines($table, $column, $value)](#dbGetLines) | get lines array by column = value |
| [dbFilter($table, $filters)](#dbFilter) |  get lines array by filter (columns = values) |
| [dbGetLine($table, $column, $value)](#dbGetLine) | get 1 line by column = value |
| [dbAddLine($table, $columns, $values)](#dbAddLine) | create line |
| [dbDeleteLine($table, $column, $value)](#dbDeleteLine) | delete line |
| [dbUpdateCells($table, $column, $value, $values)](#dbUpdateCells) | update cells by column = value |
| [dbGetMaxID($table)](#dbGetMaxID) | get max id in table |
| [dbJack($data, $splitter)](#dbJack) | Jack the ripper :D (split the string and removes emptiness) |
____

### {database) example

**{table}**
| id | name | password |
|:-:|:----:|:-----:|
| 1 | Ivan | pass1 |
| 2 | Egor | pass2 |
| 3 | Dima | pass3 |
| 4 | Dima | pass4 |
| 5 | Dima | pass4 |
| . | .... | ..... |

____

## dbQuery
    + require $query [SQL code]
	- return [MYSQL-object]
	* example:
	    *call* dbQuery('SELECT * FROM `table` WHERE `id` = 1');
	    *return* Object([current_field] => 0 [field_count] => 3 [lengths] => [num_rows] => 1 [type] => 0)

____

## dbGetLines

    + require:
        ++ $table  [text/table name],
        ++ $column [text/column name where search],
        ++ $value  [text(int)/value wich search in column]
	++ $order [text/column name for order] {optional}
            +++ $column == '*' and $value == '*' to select all from table

    - return [Array(Array('field' => 'value'))] or bool(false) if 0 rows returned

    * example:
        *call* dbGetLines('table', 'name', 'Dima');
        *return* 
        [
            [
                'id'   		=> '3',
                'name' 		=> 'Dima',
                'password'  => 'pass3'
            ],
            [
                'id'   		=> '4',
                'name' 		=> 'Dima',
                'password'  => 'pass4'
            ],
	    [
                'id'   		=> '5',
                'name' 		=> 'Dima',
                'password'  => 'pass4'
            ]
        ]

____

## dbFilter

	+ require:
        ++ $table 	[text/table name],
        ++ $filters [Array('field' => 'value')]
    
    - return [Array(Array('field' => 'value'))] or bool(false) if 0 rows returned

    * example:
        *call* dbFilter('table', Array('name' => 'Dima', 'password' => 'pass4'));
        *return* 
        [
            [
                'id'   		=> '4',
                'name' 		=> 'Dima',
                'password'  => 'pass4'
            ],
            [
                'id'   		=> '5',
                'name' 		=> 'Dima',
                'password'  => 'pass4'
            ]
        ]

____

## dbGetLine
	+ require:
            ++ $table  [text/table name],
            ++ $column [text/column name where search],
            ++ $value  [text(int)/value wich search in column]
    - return [Array('field' => 'value')] or bool(false) if rows != 1 returned

    * example:
        *call* dbFilter('table', 'id', 4);
        *return*
        [
            'id'   		=> '4',
            'name' 		=> 'Dima',
            'password'  => 'pass4'
        ]

____

## dbAddLine
	+ require:
        ++ $table   [text/table name],
        ++ $columns [Array('column1', 'column2',)],
        ++ $values  [Array('value1', 'value2',)]
		
    - return true/false

    * example:
        *call* dbAddLine('table', ['name', 'password'], ['Artem', 'pass6']);
        *return* true

____

## dbDeleteLine
	+ require:
        ++ $table   [text/table name],
        ++ $column  [text/column name where search],
        ++ $value   [text(int)/value wich search in column]
		
    - return true/false

    * example:
        *call* dbDeleteLine('table', 'id', 6);
        *return* false

____

## dbUpdateCells
	+ require:
        ++ $table	[text/table name],
        ++ $column  [text/column name where search],
        ++ $value   [text(int)/value wich search in column],
        ++ $values  [Array('column1' => 'value1', 'column2' => 'value2',)]
		
    - return true/false

    * example:
        *call* dbUpdateCells('table', 'id', '5', ['name' => 'Iva', 'password' => 'pass123']);
        *return* true

____

## dbGetMaxID
	+ require:
        $table [text/table name]
    
    - return [int]

    * example:
        *call* dbGetMaxID('table');
        *return* 5


## dbJack
	+ require:
        $data 	  [text/original string],
        $splitter [text/splitter symb]
    - return Array('val1', 'val2',)

    * example:
        *call* dbJack('a,.,b,.,c,.,d', ',.,');
        *return* ['a', 'b', 'c', 'd']
