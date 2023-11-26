<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

############################# This system is just an api in laravel with Swegger #############################

Laravel is a framework that is easy to use and maintain, and does not require external servers to run.
Technical decisions for accepting and canceling races
##### 1 Step: Customer registration
      The system will check the customer's account if it is active to initiate a ride request
        
##### 2 - Driver registration
      Drivers will only be able to go "online" when they have an active account and a registered vehicle
            
##### 3 - Request for new races
      The customer can only request a new race after finishing the previous one
    
##### 4 - Driver availability
      The system will check the availability of drivers and their proximity in km to the customer
    
##### 5 - Race cancellation
      Users and drivers will be able to cancel the race normally
      
##### Instructions on how to compile and run the project #####
     #1 - clone project : git clone https://github.com/carlosjuniorsp/vodetaxi.git
     #2 - run in the terminal the command composer install
     #3 - run in the git bash the command: touch database/database.sqlite
     #4 - run the terminal the command: php artisan migrate
     #5 - run the terminal the command: php artisan l5-swagger:generate
     #6 - run the terminal the command: php artisan serve
