# ScoreDB
This code won't work as is. It depends on a database with specific tables and relations. It also depends on a Config.php in /config/, with the database name, password, host and the current environment in it (scoredb.localhost or scoredb.julianvos.nl for example). <br>
https://scoredb.julianvos.nl

# Just noticed sorting doesn't work on the score viewing page. Fixing soon™. In the meantime you can add the username yourself in the url.

# TODO:
- Create an API which scans the image with OCR to determine the song's details
- Also save upload date, and add sorting by date added on the view page
