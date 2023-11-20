steps for fast automatic deployment:

  1- for very first deployment, rename .!code-build to .code-build and push to git . This will make CodeBuild build vendor and node_modules

  2- save the instance as an image with :

  3. - (recommended) backup vendor and node_modules to /vat/www/ as vendor_backup and node_modules_backup to be able to later
     restore by renaming .!restore-lib to .restore-lib if required.

    - install composer and any other needed tool on your instance

  3. save an image from the instance to be used as beanstalk base ami:
    ws ec2 create-image --instance-id i-some-instance-id --name "Accommo server v2.1" --description "A vue and php server for accommo nd php server for accommo app" --no-reboot


  4- detach beanstalk from old ami and attach to new ami created by above command. This will make sure we will have some vendor and node_modules libs even if
   a deployment fails

  5- if there is no change on composer.json and\or pacage.json , rename .code-build to .code-build and push to git. This will trigger source only deployment to beanstalk
   which is faster.