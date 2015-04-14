
echo 'Updating entities'
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Title.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Address.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/BaseEntity.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/ClubVenue.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Timeslot.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/TimeslotDay.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Email.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Telephone.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Link.php
sed -i 's/class \(.*\)/\0 extends \\AppBundle\\EntityExtended\\\1/g' src/AppBundle/Entity/Tag.php

echo 'Updating schema'
app/console doctrine:schema:drop --force
app/console doctrine:generate:entities AppBundle
rm src/AppBundle/Entity/*.php~
app/console doctrine:schema:update --force