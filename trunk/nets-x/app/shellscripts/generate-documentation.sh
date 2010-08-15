#!/bin/sh

controllers_dir="/var/www/nets-x/app/controllers"
models_dir="/var/www/nets-x/app/models"
output_dir="/var/www/nets-x/app/webroot/docs"

/var/www/phpdoc/phpdoc -o HTML:Smarty:PHP -d $controllers_dir,$models_dir  -t $output_dir
# script ends here
