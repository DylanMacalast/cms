<?php
// the bigger the number assigned to cost the slower the function will work but the more encrypted

// echo password_hash('secret', PASSWORD_DEFAULT, array('cost' => 10) );

echo password_hash('secret', PASSWORD_BCRYPT, array('cost'=>12));





?>