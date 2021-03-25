# Simulations Website
./post_try.py - Inserts a new record **without** parameters to lab1 table with dbex/insert.php

./post.py - Inserts a new record **with** parameters to lab1 table with dbex/insert.php

dbex/insert.php - Inserts a new record to lab1 (gets all the fields from post request)

scripts/post.py - Inserts a new record to any table and takes parameters from scripts/params.yaml

scripts/clean.py - Cleans all the records from a table

scripts/post_table.py - Creates a new table with the regular fields