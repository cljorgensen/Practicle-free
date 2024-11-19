#!/bin/bash
# Practicle Install Script: v.1.0.0 (2024-11-19)

# Exit immediately if a command exits with a non-zero status.
version="3.93.111"

set -e

# Function to install PHP extension
install_php_extension() {
    WEB_PROJECT_PATH=$1
    EXTENSION_PATH="$WEB_PROJECT_PATH/inc/practiclefunctions.so"
    PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')
    PHP_EXT_DIR=$(php -i | grep "^extension_dir" | awk '{print $3}')

    # Verify the extension file exists
    if [ ! -f "$EXTENSION_PATH" ]; then
        echo "Error: Extension file $EXTENSION_PATH not found."
        exit 1
    fi

    echo "Installing PHP extension practiclefunctions.so for PHP $PHP_VERSION..."

    # Copy the .so file to the PHP extension directory
    sudo cp "$EXTENSION_PATH" "$PHP_EXT_DIR/"

    # Add configuration files for CLI, Apache2, and FPM
    CONF_PATHS=(
        "/etc/php/$PHP_VERSION/cli/conf.d"
        "/etc/php/$PHP_VERSION/apache2/conf.d"
        "/etc/php/$PHP_VERSION/fpm/conf.d"
    )

    for CONF_PATH in "${CONF_PATHS[@]}"; do
        if [ -d "$CONF_PATH" ]; then
            INI_FILE="$CONF_PATH/20-practiclefunctions.ini"
            echo "Adding configuration to $INI_FILE..."
            echo "extension=practiclefunctions.so" | sudo tee "$INI_FILE" > /dev/null
        fi
    done

    # Reload Apache2 and FPM (if installed) to apply the extension
    echo "Reloading services..."
    sudo systemctl reload apache2
    if command -v php-fpm > /dev/null; then
        sudo systemctl reload php$PHP_VERSION-fpm
    fi

    # Verify the extension is loaded
    echo "Verifying the extension is loaded in CLI..."
    php -m | grep practiclefunctions && echo "Extension loaded successfully in CLI." || echo "Error: Extension not loaded in CLI."
}

# Function to create systemd service
create_service() {
    WEB_PROJECT_PATH=$1
    SERVICE_NAME="practicle-service"

    # Define the full path to the jobengine.php file
    PHP_FILE="$WEB_PROJECT_PATH/watchers/jobengine.php"

    # Check if the PHP file exists
    if [ ! -f "$PHP_FILE" ];then
        echo "Error: $PHP_FILE does not exist."
        exit 1
    fi

    # Create a systemd service file
    SERVICE_FILE="/etc/systemd/system/${SERVICE_NAME}.service"

    echo "Creating systemd service file at $SERVICE_FILE..."

    sudo tee "$SERVICE_FILE" > /dev/null <<EOL
[Unit]
Description=Job Engine PHP Service
After=network.target

[Service]
ExecStart=/usr/bin/php $PHP_FILE
Restart=always
User=www-data
Group=www-data

[Install]
WantedBy=multi-user.target
EOL

    # Create the systemd timer file
    TIMER_FILE="/etc/systemd/system/${SERVICE_NAME}.timer"

    echo "Creating systemd timer file at $TIMER_FILE..."

    sudo tee "$TIMER_FILE" > /dev/null <<EOL
[Unit]
Description=Run Job Engine PHP Service every 10 seconds

[Timer]
OnBootSec=10
OnUnitActiveSec=10
Unit=${SERVICE_NAME}.service

[Install]
WantedBy=timers.target
EOL

    # Reload systemd and enable the timer
    echo "Reloading systemd daemon..."
    sudo systemctl daemon-reload

    echo "Enabling and starting the service and timer..."
    sudo systemctl enable ${SERVICE_NAME}.timer
    sudo systemctl start ${SERVICE_NAME}.timer

    echo "Job engine service and timer created successfully!"
    echo "Service: $SERVICE_NAME"
    echo "Timer: $SERVICE_NAME.timer"
    echo "Job file: $PHP_FILE"
    systemctl enable $SERVICE_NAME.service
}

# Function to create Apache configuration
create_apache_config() {
    echo "Enabling rewrite mod..."
    sudo a2enmod rewrite

    SITE_NAME="practicle"
    APACHE_CONFIG_FILE="/etc/apache2/sites-available/${SITE_NAME}.conf"

    echo "Creating Apache configuration file at $APACHE_CONFIG_FILE..."

    sudo tee "$APACHE_CONFIG_FILE" > /dev/null <<EOL
<VirtualHost *:80>
    ServerName ${SITE_NAME}.dk
    DocumentRoot $WEB_PROJECT_PATH/
    Redirect permanent / https://${SITE_NAME}.dk
    RewriteEngine on
    RewriteCond %{SERVER_NAME} =${SITE_NAME}.dk
    RewriteRule ^ https://${SITE_NAME}.dk%{REQUEST_URI} [END,NE,R=permanent]
</VirtualHost>
EOL

    echo "Enabling site ${SITE_NAME}..."
    sudo a2ensite ${SITE_NAME}

    echo "Reloading Apache..."
    sudo systemctl reload apache2

    echo "Apache configuration for ${SITE_NAME} created and enabled."
}

# Prompt for the web project path with a default value
read -p "Enter the full path to your web project (e.g., /var/www/html/practicle) [default: /var/www/html/practicle]: " WEB_PROJECT_PATH
WEB_PROJECT_PATH=${WEB_PROJECT_PATH:-/var/www/html/practicle}

# Install Apache web server
echo "Installing Apache web server..."
sudo apt update # Added to ensure package lists are up-to-date
sudo apt install -y apache2

# Start Apache and enable it to run on boot
echo "Starting Apache service..."
sudo systemctl start apache2
sudo systemctl enable apache2

sudo apt install -y libapache2-mod-php
sudo systemctl restart apache2

# Install MySQL server
echo "Installing MySQL server..."
sudo apt install -y mysql-server

# Secure MySQL installation (optional)
echo "Securing MySQL installation..."
sudo mysql_secure_installation

# Start MySQL and enable it to run on boot
echo "Starting MySQL service..."
sudo systemctl start mysql
sudo systemctl enable mysql

echo "Installing prerequisites..."
sudo apt install -y php php-mysql php-cli php-common
sudo apt install -y git php php-dev re2c gcc make autoconf
sudo locale-gen da_DK.UTF-8
sudo locale-gen de_DE.UTF-8
sudo locale-gen es_ES.UTF-8
sudo locale-gen fr_FR.UTF-8
sudo locale-gen fi_FI.UTF-8
sudo locale-gen it_IT.UTF-8
sudo locale-gen tr_TR.UTF-8
sudo locale-gen zh_CN.UTF-8
sudo locale-gen zh_TW.UTF-8
sudo locale-gen ru_RU.UTF-8
sudo locale-gen ja_JP.UTF-8
sudo locale-gen pt_PT.UTF-8
sudo update-locale
echo "Installed prerequisites."

# Download latest release of Practicle
echo "Downloading and installing Practicle..."
mkdir -p $WEB_PROJECT_PATH # Added -p to prevent errors if the directory already exists
wget -O $WEB_PROJECT_PATH/${version}.tar.gz https://support.practicle.dk/backups/releases/hekx85klqcs5yhw7vfw5mq9sak0g/practicle_release_${version}.tar.gz
tar -xvf $WEB_PROJECT_PATH/${version}.tar.gz -C $WEB_PROJECT_PATH --strip-components=1 # Added --strip-components to extract directly into the directory
rm $WEB_PROJECT_PATH/${version}.tar.gz
echo "Downloaded Practicle."

# Call the function to install the PHP extension
install_php_extension "$WEB_PROJECT_PATH"

# Call the function to create the service
create_service "$WEB_PROJECT_PATH"

# Call the function to create the Apache configuration
create_apache_config
