# Practicle free version
Welcome - this is the respository for the free release of Practicle

Practicle is an ITIL-based web system for managing inquiries, orders, changes, projects, tasks, cmdb and much more.

Read this first

This software is provided free of charge and without built in limitations. You are not allowed to sell this software, modify it, or misuse it in any way. Use of this software is at your own discretion, and Practicle is not liable for any data loss or errors arising from its use. We do not have or provide any support for this free version.

To enhance our software and better understand user needs, practicle will regularly transmit the following statistics:

Number of active users
Number of active companies
Number of active teams
Number of active groups
Number of active elements
Number of active projects
Number of active assets types (cmdb)
Number of active assets (cmdb)
Your informations provided in this installer will be registered. Please keep user information anonymous if you prefer that. No further personal or sensitive information is collected, transmitted or registered.

* If you are interested in participating in this project, have reports on security issues or have requests for features (hourly fee of 200 dollars per hour) - please contact Practicle via our contact form here
* If you are using our software on daily basis - please provide us with a recommendation here LinkedIn and here Facebook
* Yes, Practicle is a hobby project. While it may gain commercial traction in the future, please use it at your own risk.

Installation guide

1. install Ubuntu 24.04 (installation script will install all necessary requirements
2. go to user home folder
3. copy/paste installPracticle.sh and make the file executable
4. run ./installPracticle.sh
5. installer will automatically install local mysql server, create admin user and install web files in /var/www/html/practicle
6. install certifiate for https (practicle installs with use of php-fpm)
7. add ssl configuration to the genereated apache config file
8. go to website and run https://systemname.local/install.php file
9. practicle will setup database and more, please note the user credentials the installer provides
10. If run successfully delete /var/www/html/practicle/install.php file and you can login with your provided credentials
