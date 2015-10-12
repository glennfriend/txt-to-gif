install
    imagemagick

find your fonts
    ./tool/imageick_type_gen > type.xml

try
     cat readme.txt | convert -pointsize 16 label:@- tmp/just-try.gif

run before
    chmod 777 tmp output

run
    php build.php 1.txt
