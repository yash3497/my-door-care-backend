<<<<<<<< Update Guide >>>>>>>>>>>
Clone Version:1.1.0
Immediate Older Version: 1.1.0
Current Version: 1.2.0

Update Features::
1. PayStack Payment Gateway Added
2. Language Added (French & Hindi)
3. System Maintenance Mode Added
4. Installer Update


Please Use Those Command On Your Terminal To Update v1.1.0 to v1.2.0

1. Update Composer To Add New Package (Make Sure Your Targeted Location Is Project Root)
    composer update

2. To Added New Migration File
    php artisan migrate

3. To Update/Added New Payment Gateway (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\Admin\\PaymentGatewaySeeder

4. To Update Language Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\Update\\LanguageSeeder

5. To Update Version Related Feature Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\UpdateFeatureSeeder

6. To Update System Maintenance Mode Please Run This Command On Your Terminal (Make Sure Your Targeted Location Is Project Root)
    php artisan db:seed --class=Database\\Seeders\\Admin\\SystemMaintenanceSeeder

7. To clear view file cache (Make Sure Your Targeted Location Is Project Root)
    php artisan view:clear
---------------------------------------------------------------------------------

Fresh Installation Guide
1. Update Composer To Update All PHP/Laravel Packages
    composer update

2. Seed Database With Necessary Data
    php artisan migrate:fresh --seed

3. Create Token For API Authentication By Run The Command Below
    php artisan passport:install
