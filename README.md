#MultiInsert

You can specify and run insert queries in chunks.
You need just the associative array and table name
Where key - name of the column and value - value to insert.

#PdoQueryBuilder

Building of prepared PdoQuery

#PdoQuery

Object with the possibility to execute query

#Usage
```php
$dbh = new PDO('mysql:host=localhost;dbname=test', getenv('dbuser'), getenv('dbpass'));
$qf = new PdoQueryFabric($dbh);
$qb = new PdoQueryBuilder($qf);
$mi = new MultiInsert($qb);
$mi->setTable('test');
$mi->setRows(
    [
        [
            'id' => 1,
            'name' => 'Foo',
        ],
        [
            'id' => 2,
            'name' => 'Bar',
        ],
        [
            'id' => 3,
            'name' => 'Baz',
        ],
    ]
);
$mi->setColumns(['name']);
$mi->execute();

/*
Executed: INSERT INTO `test` (`name`) VALUES ('Foo','Bar','Baz')
*/
```