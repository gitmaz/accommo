@@@ Installing backend:
   via locally installed php 8.2 and composer
    open a terminal
    cd backend
    composer install

@@@ Installing frontend:
   via locally installed node 14
    open a terminal
    cd frontend
    npm install

@@@ running spa
  via locally installed php 8.2 and node 14 (using separate terminal windows):
    cd backend
    serve.bat (on Windows)
    . ./serve.sh (on unix based machines)

    cd frontend
    npm run serve

    wait until http://localhost:8080/ appears , then you can go to that url to run the app

  via docker:

   IMPORTANT: making installation of libraries in backend is not yet possible via docker, to
        achieve that, we need to use this image: composer:2 and we should run this command in docker-compose.yml:
        sh -c "composer install && php -S 0.0.0.0:8000 -t public"
        as a workaround you need to do composer install in backend folder using your locally installed composer.
        Please follow below steps when you installed vendor dir, to run tha application via docker.

   on the root do:
    docker-compose up -d  (spins up the containers for both backend and frontend)
    docker-compose down   (shuts down the containers for both backend and frontend)

    Note: it takes a while for the container to run (specially frontend), either wait or run it in detached mode and
    wait until - Local:   http://localhost:8080/ appears , then you can go to that url to run the app



@@@ running unit tests
 on Unix based systems:
  cd backend
  vendor/bin/phpunit SydneyAreasControllerTest.php
   or
  vendor/bin/phpunit tests/AccommodationsControllerTest.php
   or for running all tests:
  vendor/bin/phpunit

 on Windows:
  cd backend
  php vendor/bin/phpunit tests/SydneyAreasControllerTest.php
   or
  php vendor/bin/phpunit tests/AccommodationsControllerTest.php
   or for running all tests:
  php vendor/bin/phpunit


@@@ Known design shortcomings:
  the ATLAS had a problem retrieving accommodations that if an area + the suburb in that area is passed as query string,
  (using ar and ct keys), it didn't returned anything, so I was not able to make suburb dropdown as detail of area dropdown
  (which is logical solution if that was handled by ATLAS correctly). I also needed to clear one when other was selected in fe.

  Also, I could not find a way to filter suburbs of greater sydney area as suburbs endpoint only was accepting state as input,
  so the dropdown for suburbs, is not realy only suburbs of sydney, but suburbs of NSW state.