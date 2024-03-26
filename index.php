<?php

$db = new SQLite3('db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
// Errors are emitted as warnings by default, enable proper error handling.
$db->enableExceptions(true);

$db->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS people (
  id INTEGER PRIMARY KEY,
  first_name TEXT,
  last_name TEXT,
  game TEXT,
  Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);
SQL);

if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
  $statement = $db->prepare('INSERT INTO people (first_name, last_name) VALUES (:first_name, :last_name)');
  $statement->bindValue(':first_name', $_POST['first_name']);
  $statement->bindValue(':last_name', $_POST['last_name']);
  $statement->execute();
}

/* $statement = $db->prepare('SELECT * FROM people'); */
/* $statement->bindValue(1, 42); */
/* $statement->bindValue(2, '2017-01-14'); */
/* $result = $statement->execute(); */

$query = $db->query('SELECT * FROM people');

/* $people = $result->fetchArray(SQLITE3_ASSOC); */

?>

<h1>Add Person</h1>

<form method="post">
  <label for="first_name">First Name:</label>
  <input type="text" id="first_name" name="first_name">

  <label for="last_name">Last Name:</label>
  <input type="text" id="last_name" name="last_name">

  <button type="submit">Add Person</button>
</form>

<h2>People</h2>

<ul>
  <?php
    while($person = $query->fetchArray(SQLITE3_ASSOC)) {
      echo "<li>{$person['first_name']} {$person['last_name']}</li>";
    }
  ?>
</ul>

